<?php
session_start();
require_once 'app.php'; // Include la connessione al database e la classe ChatManager

// Controlla se l'utente è loggato
if (!isset($_SESSION['user'])) {
    http_response_code(401); // Non autorizzato
    echo json_encode(['error' => 'Non sei autorizzato']);
    exit();
}

// Verifica il metodo della richiesta
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Metodo non consentito
    echo json_encode(['error' => 'Metodo non consentito. Usa POST.']);
    exit();
}

// Raccogli i dati dal corpo della richiesta
$data = json_decode(file_get_contents('php://input'), true);
$message = trim($data['message'] ?? '');

if (empty($message)) {
    http_response_code(400); // Richiesta errata
    echo json_encode(['error' => 'Il messaggio non può essere vuoto.']);
    exit();
}

$userName = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');

// Istanzia la classe ChatManager
$chatManager = new ChatManager($conn);

try {
    // Salva il messaggio nel database
    $chatManager->inviaMessaggio('user', $userName, $message);
    echo json_encode(['success' => true, 'message' => 'Messaggio inviato con successo.']);
} catch (Exception $e) {
    http_response_code(500); // Errore interno
    echo json_encode(['error' => 'Errore durante l\'invio del messaggio: ' . $e->getMessage()]);
}
?>