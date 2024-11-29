<?php
session_start();
require_once 'app.php'; // Include la connessione al database e la classe ChatManager

// Controlla se l'utente è loggato
if (!isset($_SESSION['user'])) {
    http_response_code(401); // Non autorizzato
    echo json_encode(['error' => 'Non sei autorizzato']);
    exit();
}

$userName = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');

// Istanzia la classe ChatManager
$chatManager = new ChatManager($conn);

try {
    // Recupera i messaggi per l'utente
    $messages = $chatManager->getMessaggiPerUtente($userName);
    echo json_encode($messages);
} catch (Exception $e) {
    http_response_code(500); // Errore interno
    echo json_encode(['error' => 'Errore durante il recupero dei messaggi: ' . $e->getMessage()]);
}
?>