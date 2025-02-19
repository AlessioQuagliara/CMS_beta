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

if (!isset($input['product_id'], $input['tipo_periodo'], $input['valore_periodo']) || !is_numeric($input['product_id']) || !is_numeric($input['valore_periodo'])) {
    echo json_encode(['success' => false, 'message' => 'Dati non validi.']);
    exit;
}

$product_id = intval($input['product_id']);
$tipo_periodo = $input['tipo_periodo'];
$valore_periodo = intval($input['valore_periodo']);

$periodoModel = new ProdottiPeriodiModel($pdo);
if ($periodoModel->addPeriodoToProduct($product_id, $tipo_periodo, $valore_periodo)) {
    echo json_encode(['success' => true, 'message' => 'Periodo aggiunto con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore nell\'aggiunta del periodo.']);
}
?>