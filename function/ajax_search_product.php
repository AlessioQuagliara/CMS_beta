<?php
header('Content-Type: application/json');

require_once '../config.php';
require_once '../models/prodotti_pubblicitari.php';

// Ottieni il termine di ricerca passato come query string (GET)
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($query === '') {
    // Se la ricerca è vuota, restituisci tutti i prodotti
    $model = new ProdottiPubblicitariModel($pdo);
    $products = $model->getAllProducts();
    echo json_encode($products);
    exit;
}

// Esegui la ricerca per nome o slug
$sql = "SELECT * FROM prodotti_pubblicitari WHERE nome LIKE :q OR slug LIKE :q ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$likeQuery = '%' . $query . '%';
$stmt->bindParam(':q', $likeQuery, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);