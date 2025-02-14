<?php
header('Content-Type: application/json');

// Includi il file di configurazione con la connessione PDO
require_once '../config.php';
// Includi il model
require_once '../models/prodotti_pubblicitari.php';

// Instanzia il model
$model = new ProdottiPubblicitariModel($pdo);

// Recupera tutti i prodotti
$products = $model->getAllProducts();

// Restituisci i dati in formato JSON
echo json_encode($products);