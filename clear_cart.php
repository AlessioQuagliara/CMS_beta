<?php
session_start();
header('Content-Type: application/json');

// Assicura che la sessione sia attiva
if (session_status() !== PHP_SESSION_ACTIVE) {
    echo json_encode(['success' => false, 'message' => 'Errore: sessione non attiva']);
    exit();
}

// Svuota il carrello
$_SESSION['cart'] = [];

// Debug: Registra l'operazione nei log
error_log("🔄 Carrello svuotato con successo.");

// Risposta JSON
echo json_encode([
    'success' => true,
    'message' => 'Carrello svuotato con successo'
]);
exit();
?>