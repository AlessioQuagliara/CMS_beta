<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Avvia la sezione
session_start();
include '../app.php';

// Gestice l'aggiunta di prodotti al carrello

if (isset($_POST['id_prodotto']) && isset($_POST['quantita'])) {
    $productId = $_POST['id_prodotto'];
    $quantity = $_POST['quantita'];

    addToCart($productId, $quantity);

    header('Location: ../cart.php');
    exit();
}
