<?php
require_once '../../app.php'; // Include la classe per gestire gli eventi

header('Content-Type: application/json');

try {
    // Istanzia la classe EventManager
    $eventManager = new EventoManager($conn);

    // Ottieni tutti gli eventi
    $events = $eventManager->getEventi();

    // Invia la risposta come JSON
    echo json_encode($events);
} catch (Exception $e) {
    // Gestione errori
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Errore durante il caricamento degli eventi: ' . $e->getMessage()
    ]);
}
?>