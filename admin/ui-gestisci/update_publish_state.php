<?php
require('../../app.php');
header('Content-Type: application/json');

// Verifica che la richiesta sia POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metodo non consentito.']);
    exit();
}

// Decodifica il corpo della richiesta
$data = json_decode(file_get_contents('php://input'), true);

// Verifica i parametri richiesti
if (empty($data['id_evento']) || !isset($data['pubblicato'])) {
    echo json_encode(['success' => false, 'message' => 'Parametri mancanti.']);
    exit();
}

$id_evento = (int)$data['id_evento'];
$pubblicato = (int)$data['pubblicato'];

try {
    // Aggiorna lo stato "Pubblicato" nel database
    $stmt = $conn->prepare("UPDATE eventi SET pubblicato = ? WHERE id_evento = ?");
    $stmt->bind_param('ii', $pubblicato, $id_evento);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Stato pubblicazione aggiornato.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nessuna riga aggiornata.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Errore durante l\'aggiornamento: ' . $e->getMessage()]);
}