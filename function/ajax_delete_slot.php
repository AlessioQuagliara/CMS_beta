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
if (!isset($input['id']) || !is_numeric($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID slot non valido.']);
    exit;
}

$slot_id = intval($input['id']);
$slotModel = new ProductSlotModel($pdo);

if ($slotModel->deleteSlot($slot_id)) {
    echo json_encode(['success' => true, 'message' => 'Slot eliminato con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore nella cancellazione dello slot.']);
}
?>