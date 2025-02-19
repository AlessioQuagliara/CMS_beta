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

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['product_id']) || !is_numeric($input['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID prodotto non valido.']);
    exit;
}

$product_id = intval($input['product_id']);
$spotModel = new ProductSpotModel($pdo);

// Conta gli spot esistenti per questo prodotto
$existingSpots = $spotModel->getSpotsByProductId($product_id);
$spotNumber = count($existingSpots) + 1;
$spotName = "{$spotNumber}° Posizione";

// Aggiungi lo spot al prodotto
if ($spotModel->addSpotToProduct($product_id, $spotName)) {
    echo json_encode(['success' => true, 'message' => 'Spot aggiunto con successo.', 'spot' => $spotName]);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante l\'aggiunta dello spot.']);
}