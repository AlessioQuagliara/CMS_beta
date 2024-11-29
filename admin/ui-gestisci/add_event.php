<?php
require '../../app.php';

header('Content-Type: application/json');

// Verifica se la richiesta è POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metodo non consentito.']);
    exit();
}

// Controllo di validazione dei dati inviati
if (empty($_POST['titolo']) || empty($_POST['descrizione']) || empty($_POST['categoria']) || empty($_POST['data_evento']) || empty($_POST['ora_evento'])) {
    echo json_encode(['success' => false, 'message' => 'Tutti i campi sono obbligatori.']);
    exit();
}

$titolo = htmlspecialchars($_POST['titolo'], ENT_QUOTES, 'UTF-8');
$descrizione = htmlspecialchars($_POST['descrizione'], ENT_QUOTES, 'UTF-8');
$categoria = htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8');
$dataEvento = htmlspecialchars($_POST['data_evento'], ENT_QUOTES, 'UTF-8');
$oraEvento = htmlspecialchars($_POST['ora_evento'], ENT_QUOTES, 'UTF-8');

// Gestione immagine
$immagine = null;
if (!empty($_FILES['immagine']['name'])) {
    $targetDir = '../../uploads/events/';
    $fileName = basename($_FILES['immagine']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Estensioni consentite
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
        // Sposta il file caricato nella directory di destinazione
        if (move_uploaded_file($_FILES['immagine']['tmp_name'], $targetFilePath)) {
            $immagine = $fileName;
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore durante il caricamento dell\'immagine.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Formato immagine non supportato.']);
        exit();
    }
}

$eventManager = new EventoManager($conn);

try {
    $eventManager->aggiungiEvento(
        $titolo,
        $descrizione,
        $immagine, // Immagine gestita
        $categoria,
        $dataEvento,
        $oraEvento,
        0 // Pubblicato di default
    );

    echo json_encode(['success' => true, 'message' => 'Evento aggiunto con successo!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Errore durante l\'aggiunta: ' . $e->getMessage()]);
}
?>