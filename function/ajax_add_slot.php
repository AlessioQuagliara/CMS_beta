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
if (!isset($input['product_id']) || !is_numeric($input['product_id']) || 
    !isset($input['slot']) || !isset($input['valore_slot'])) {
    echo json_encode(['success' => false, 'message' => 'Dati non validi.']);
    exit;
}

$product_id = intval($input['product_id']);
$slot = trim($input['slot']); 
$valore_slot = floatval($input['valore_slot']); // Converte in numero decimale

// Validazione del formato orario dello slot (HH:MM)
if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $slot)) {
    echo json_encode(['success' => false, 'message' => 'Formato orario non valido. Usa HH:MM.']);
    exit;
}

// Validazione del valore_slot (deve essere un numero positivo)
if ($valore_slot <= 0) {
    echo json_encode(['success' => false, 'message' => 'Il valore dello slot deve essere maggiore di zero.']);
    exit;
}

$slotModel = new ProductSlotModel($pdo);
if ($slotModel->addSlotToProduct($product_id, $slot, $valore_slot)) {
    echo json_encode(['success' => true, 'message' => 'Slot aggiunto con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore nell\'aggiunta dello slot.']);
}
?>