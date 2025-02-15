<?php
header('Content-Type: application/json');

require_once '../config.php';
require_once '../models/prodotti_pubblicitari.php';

// Recupera i dati JSON inviati
$input = json_decode(file_get_contents('php://input'), true);

// Inizializza l'array dei dati del prodotto principale
$data = [
    'nome'                => $input['nome'] ?? 'Nuovo prodotto',
    'slug'                => $input['slug'] ?? 'nuovo-prodotto-' . time(),
    'description'         => $input['description'] ?? '',
    'mezzo_pubblicitario' => $input['mezzo_pubblicitario'] ?? 'Digital',
    'dimensione'          => $input['dimensione'] ?? 'Locale',
    'concessionaria'      => $input['concessionaria'] ?? 'Sipra',
    'genere'              => $input['genere'] ?? 'Entrambi',
    'eta'                 => $input['eta'] ?? 'Meno di 30 anni',
];

try {
    // Inizia una transazione per garantire la coerenza
    $pdo->beginTransaction();

    // Creazione del prodotto pubblicitario
    $model = new ProdottiPubblicitariModel($pdo);
    $product_id = $model->createProduct($data);

    if (!$product_id) {
        throw new Exception("Errore durante la creazione del prodotto.");
    }

    // Conferma la transazione
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Prodotto creato con successo.'
    ]);
} catch (Exception $e) {
    // In caso di errore, annulla tutto
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Errore: ' . $e->getMessage()
    ]);
}