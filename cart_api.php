<?php
session_start();
header('Content-Type: application/json');

// Assicura che il carrello sia un array
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Debug: stampa il contenuto del carrello nel log
error_log("🛒 Contenuto del carrello: " . print_r($_SESSION['cart'], true));

// Creiamo un array per l'output JSON
$cartItems = [];

foreach ($_SESSION['cart'] as $key => $item) {
    $cartItems[] = [
        'unique_id' => $key,  // Passiamo la chiave univoca
        'id' => $item['id'],
        'name' => $item['name'],
        'price' => $item['price'],
        'image' => $item['image'],
        'quantity' => $item['quantity']
    ];
}

// Rispondi con i dati del carrello
echo json_encode([
    'success' => true,
    'total_items' => count($_SESSION['cart']),
    'items' => $cartItems // Ora ogni oggetto ha `unique_id`
], JSON_PRETTY_PRINT);
exit();
?>