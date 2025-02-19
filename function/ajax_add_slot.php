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
if (!isset($input['product_id']) || !is_numeric($input['product_id']) || !isset($input['slot'])) {
    echo json_encode(['success' => false, 'message' => 'Dati non validi.']);
    exit;
}

$product_id = intval($input['product_id']);
$slot = $input['slot']; // Slot in formato "HH:MM"

// Validazione del formato orario
if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $slot)) {
    echo json_encode(['success' => false, 'message' => 'Formato orario non valido. Usa HH:MM.']);
    exit;
}

$slotModel = new ProductSlotModel($pdo);
if ($slotModel->addSlotToProduct($product_id, $slot)) {
    echo json_encode(['success' => true, 'message' => 'Slot aggiunto con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore nell\'aggiunta dello slot.']);
}
?>