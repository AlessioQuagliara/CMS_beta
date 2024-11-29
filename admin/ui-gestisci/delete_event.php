<?php
require_once('../../app.php'); // Include la classe EventoManager

header('Content-Type: application/json');

// Verifica che il metodo sia POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metodo non consentito. Usa POST.'
    ]);
    exit();
}

// Raccogli i dati inviati
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se l'ID è stato passato
if (empty($data['event_ids']) || !is_array($data['event_ids'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Nessun ID evento fornito o formato non valido.'
    ]);
    exit();
}

try {
    $eventManager = new EventoManager($conn);
    $deletedCount = 0;

    foreach ($data['event_ids'] as $eventId) {
        if ($eventManager->eliminaEvento($eventId)) {
            $deletedCount++;
        }
    }

    echo json_encode([
        'success' => true,
        'message' => "$deletedCount eventi eliminati con successo."
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Errore durante l\'eliminazione degli eventi: ' . $e->getMessage()
    ]);
}
?>