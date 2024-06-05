<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require('../conn.php');
require_once('../app.php');

$productTitle = isset($_GET['titolo']) ? $_GET['titolo'] : '';
$productQuantity = isset($_GET['quantita']) ? intval($_GET['quantita']) : 1;

if ($productTitle && $productQuantity > 0) {
    aggiungiAlCarrello($productTitle, $productQuantity);
    header("Location: ../cart"); // Redireziona a una pagina di successo o carrello
    exit();
} else {
    header("Location: error"); // Redireziona a una pagina di errore
    exit();
}

// Funzione aggiungiAlCarrello
function aggiungiAlCarrello($titolo, $quantita) {
    if (!isset($_SESSION['carrello'])) {
        $_SESSION['carrello'] = [];
    }

    $trovato = false;
    foreach ($_SESSION['carrello'] as &$item) {
        if ($item['titolo'] === $titolo) {
            $item['quantita'] += $quantita;
            $trovato = true;
            break;
        }
    }

    if (!$trovato) {
        $_SESSION['carrello'][] = [
            'titolo' => $titolo,
            'quantita' => $quantita
        ];
    }
}

// Chiudi connessioni
$stmt->close();
$conn->close();
?>