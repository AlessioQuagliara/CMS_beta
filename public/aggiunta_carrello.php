<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require('../conn.php');
require_once('../app.php');

$productTitle = isset($_GET['titolo']) ? htmlspecialchars($_GET['titolo'], ENT_QUOTES, 'UTF-8') : '';
$productQuantity = isset($_GET['quantita']) ? intval($_GET['quantita']) : 1;
$productPrice = isset($_GET['prezzo']) ? intval($_GET['prezzo']) : 0;
$productDescription = isset($_GET['descrizione']) ? htmlspecialchars($_GET['descrizione'], ENT_QUOTES, 'UTF-8') : '';


if ($productTitle && $productQuantity && $productPrice && $productDescription > 0) {
    aggiungiAlCarrello($productTitle, $productQuantity, $productPrice, $productDescription);
    header("Location: ../cart"); // Redireziona a una pagina di successo o carrello
    exit();
} else {
    exit();
}

// Funzione aggiungiAlCarrello
function aggiungiAlCarrello($titolo, $quantita, $prezzo, $descrizione) {
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
            'quantita' => $quantita,
            'prezzo' => $prezzo, 
            'descrizione' => $descrizione
        ];
    }
}

// Chiusura connessioni (se esistono connessioni attive)
if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>