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

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Errore nel caricamento del file.']);
    exit;
}

if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID prodotto non valido.']);
    exit;
}

$product_id = intval($_POST['product_id']);
$uploadDir = '../uploads/products/';  // Modifica il percorso in base alla tua struttura
$fileName = uniqid() . '_' . basename($_FILES['image']['name']);
$filePath = $uploadDir . $fileName;

// Controllo dell'estensione
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if (!in_array($fileExtension, $allowedExtensions)) {
    echo json_encode(['success' => false, 'message' => 'Formato file non supportato.']);
    exit;
}

// Sposta il file nella cartella di destinazione
if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
    echo json_encode(['success' => false, 'message' => 'Errore nello spostamento del file.']);
    exit;
}

// Salva il percorso nel database
$imageModel = new ProductImagesModel($pdo);
if ($imageModel->addImageToProduct($product_id, $filePath)) {
    echo json_encode(['success' => true, 'message' => 'Immagine caricata con successo.', 'image_url' => $filePath]);
} else {
    unlink($filePath); // Rimuovi il file se il database non viene aggiornato
    echo json_encode(['success' => false, 'message' => 'Errore nel salvataggio dell\'immagine nel database.']);
}
?>