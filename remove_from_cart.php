<?php
session_start();
header('Content-Type: application/json');

// Se la sessione non è avviata, inizializza il carrello
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Controllo validità richiesta
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID non valido']);
    exit();
}

$itemId = $_POST['id']; // L'ID ricevuto da AJAX (deve essere la chiave univoca)

// Debugging: Verifica se l'elemento esiste nel carrello
error_log("🗑️ Tentativo di rimuovere il prodotto con chiave: " . $itemId);
error_log("📌 Contenuto del carrello PRIMA della rimozione: " . print_r($_SESSION['cart'], true));

if (isset($_SESSION['cart'][$itemId])) {
    unset($_SESSION['cart'][$itemId]);

    // Debug dopo la rimozione
    error_log("✅ Prodotto rimosso con successo");
    error_log("📌 Contenuto del carrello DOPO la rimozione: " . print_r($_SESSION['cart'], true));

    echo json_encode(['success' => true, 'message' => 'Prodotto rimosso con successo']);
} else {
    error_log("❌ Prodotto NON trovato nel carrello");
    echo json_encode(['success' => false, 'message' => 'Prodotto non trovato nel carrello']);
}
?>