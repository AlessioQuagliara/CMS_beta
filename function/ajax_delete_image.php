<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once '../config.php';
require_once '../models/prodotti_pubblicitari.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false, 
        'message' => 'Metodo non consentito. Metodo ricevuto: ' . $_SERVER['REQUEST_METHOD']
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['id']) || !is_numeric($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID immagine non valido.']);
    exit;
}

$image_id = intval($input['id']);
$imageModel = new ProductImagesModel($pdo);

// Recupera l'immagine dal database
$image = $imageModel->getImageById($image_id);
if (!$image) {
    echo json_encode(['success' => false, 'message' => 'Immagine non trovata.']);
    exit;
}

// Cancella il file fisico
if (file_exists($image['image_url'])) {
    unlink($image['image_url']);
}

// Cancella il record dal database
if ($imageModel->deleteImage($image_id)) {
    echo json_encode(['success' => true, 'message' => 'Immagine eliminata con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore nella cancellazione dell\'immagine dal database.']);
}
?>