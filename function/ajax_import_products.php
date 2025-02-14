<?php
header('Content-Type: application/json');

require_once '../../config.php';
require_once '../../models/prodotti_pubblicitari.php';

/**
 * Funzione per importare i prodotti da un file CSV.
 * Il file CSV deve avere le seguenti intestazioni (header):
 * nome, slug, description, mezzo_pubblicitario, dimensione, concessionaria, genere, eta, tipo_periodo, valore_periodo, slot, posizionamento, spot
 *
 * @param string $csvFilePath Il percorso del file CSV.
 * @param PDO $pdo La connessione PDO.
 * @return array Un array con il risultato dell'importazione.
 */
function importProductsFromCSV($csvFilePath, $pdo) {
    $model = new ProdottiPubblicitariModel($pdo);

    if (!file_exists($csvFilePath)) {
        return ["success" => false, "message" => "Il file CSV non esiste."];
    }

    $handle = fopen($csvFilePath, "r");
    if ($handle === false) {
        return ["success" => false, "message" => "Impossibile aprire il file CSV."];
    }

    // Leggi la prima riga per ottenere le intestazioni
    $header = fgetcsv($handle, 1000, ",");
    if ($header === false) {
        fclose($handle);
        return ["success" => false, "message" => "CSV vuoto o non valido."];
    }

    // Definisci l'ordine atteso delle colonne
    $expectedHeaders = ['nome', 'slug', 'description', 'mezzo_pubblicitario', 'dimensione', 'concessionaria', 'genere', 'eta', 'tipo_periodo', 'valore_periodo', 'slot', 'posizionamento', 'spot'];
    // (Opzionale) Potresti verificare se le intestazioni del CSV corrispondono a quelle attese.
    // Per semplicità qui assumiamo che l'ordine sia corretto.

    $importCount = 0;
    $errorCount  = 0;
    $errors      = [];

    // Leggi le righe successive
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if (count($data) < count($expectedHeaders)) {
            $errorCount++;
            $errors[] = "Riga incompleta: " . implode(",", $data);
            continue;
        }
        // Associa i dati alle intestazioni
        $row = array_combine($header, $data);

        // Gestisci la conversione dei campi numerici
        $row['slot']           = ($row['slot'] !== "") ? intval($row['slot']) : null;
        $row['posizionamento'] = ($row['posizionamento'] !== "") ? intval($row['posizionamento']) : null;
        $row['spot']           = ($row['spot'] !== "") ? intval($row['spot']) : null;

        // Inserisci il prodotto tramite il model
        if ($model->createProduct($row)) {
            $importCount++;
        } else {
            $errorCount++;
            $errors[] = "Errore nell'inserimento della riga: " . json_encode($row);
        }
    }
    fclose($handle);

    return [
        "success"   => true,
        "imported"  => $importCount,
        "errors"    => $errors,
        "message"   => "Importazione completata: $importCount prodotti importati, $errorCount errori."
    ];
}

// Verifica che il file CSV sia stato caricato correttamente
if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "message" => "Errore nel caricamento del file CSV."]);
    exit;
}

// Verifica che il file abbia estensione .csv
$fileInfo = pathinfo($_FILES['csv_file']['name']);
if (strtolower($fileInfo['extension']) !== 'csv') {
    echo json_encode(["success" => false, "message" => "Il file deve essere in formato CSV."]);
    exit;
}

// Utilizza il file temporaneo caricato
$tmpFilePath = $_FILES['csv_file']['tmp_name'];

// Chiamata alla funzione di importazione
$result = importProductsFromCSV($tmpFilePath, $pdo);
echo json_encode($result);