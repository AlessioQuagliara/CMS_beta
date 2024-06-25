<?php
session_start();
require('../conn.php');
require_once('../app.php');

$productPrice = isset($_GET['prezzo']) ? intval($_GET['prezzo']) : 0;
$productQuantity = isset($_GET['quantita']) ? intval($_GET['quantita']) : 1;
$productTitle = isset($_GET['titolo']) ? htmlspecialchars($_GET['titolo'], ENT_QUOTES, 'UTF-8') : '';
$productDescription = isset($_GET['descrizione']) ? htmlspecialchars($_GET['descrizione'], ENT_QUOTES, 'UTF-8') : '';

// Debug: stampa i valori delle variabili
echo 'productPrice: ' . $productPrice . '<br>';
echo 'Type of productPrice: ' . gettype($productPrice) . '<br>';
echo 'productQuantity: ' . $productQuantity . '<br>';
echo 'productTitle: ' . $productTitle . '<br>';
echo 'productDescription: ' . $productDescription . '<br>';

// Condizione migliorata per gestire il prezzo 0
if ($productQuantity > 0 && !empty($productTitle) && !empty($productDescription)) {
    echo 'Condizione soddisfatta<br>'; // Debug
    aggiungiAlCarrello($productTitle, $productQuantity, $productPrice, $productDescription);
    header("Location: ../cart"); // Redireziona a una pagina di successo o carrello
    exit();
} else {
    echo 'errore<br>';
    echo 'Valori ricevuti non validi.<br>'; // Debug
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