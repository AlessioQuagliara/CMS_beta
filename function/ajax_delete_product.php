<?php
header('Content-Type: application/json');

require_once '../config.php';
require_once '../models/prodotti_pubblicitari.php';

// Ricevi i dati in input (JSON) e decodifica
$input = json_decode(file_get_contents('php://input'), true);

// Verifica che sia stato passato un array di ID
if (!isset($input['ids']) || !is_array($input['ids'])) {
    echo json_encode(['success' => false, 'message' => 'Dati non validi.']);
    exit;
}

$model = new ProdottiPubblicitariModel($pdo);
$allSuccess = true;

// Esegui la cancellazione per ogni ID
foreach ($input['ids'] as $id) {
    $id = (int)$id;
    if (!$model->deleteProduct($id)) {
        $allSuccess = false;
        break;
    }
}

if ($allSuccess) {
    echo json_encode(['success' => true, 'message' => 'Prodotto/i cancellato/i con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore nella cancellazione dei prodotti.']);
}