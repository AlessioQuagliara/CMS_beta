<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once '../config.php';
require_once '../models/prodotti_pubblicitari.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metodo non consentito.']);
    exit;
}

// Decodifica l'input JSON
$input = json_decode(file_get_contents('php://input'), true);

// Controllo dei dati ricevuti
if (!isset($input['product_id']) || !is_numeric($input['product_id']) || !isset($input['valore_spot'])) {
    echo json_encode(['success' => false, 'message' => 'Dati non validi.']);
    exit;
}

$product_id = intval($input['product_id']);
$valore_spot = floatval($input['valore_spot']); // Converte in numero decimale

// Validazione del valore dello spot (deve essere maggiore di zero)
if ($valore_spot <= 0) {
    echo json_encode(['success' => false, 'message' => 'Il valore dello spot deve essere maggiore di zero.']);
    exit;
}

$spotModel = new ProductSpotModel($pdo);

// Conta gli spot esistenti per questo prodotto
$existingSpots = $spotModel->getSpotsByProductId($product_id);
$spotNumber = count($existingSpots) + 1;
$spotName = "{$spotNumber}° Posizione";

// Aggiungi lo spot con valore
if ($spotModel->addSpotToProduct($product_id, $spotName, $valore_spot)) {
    echo json_encode([
        'success' => true, 
        'message' => 'Spot aggiunto con successo.', 
        'spot' => $spotName,
        'valore_spot' => $valore_spot
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante l\'aggiunta dello spot.']);
}
?>