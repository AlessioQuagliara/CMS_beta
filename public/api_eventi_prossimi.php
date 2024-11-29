<?php
require_once '../app.php'; // Include connessione al database e classi necessarie

header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("
        SELECT id_evento, titolo, descrizione, data_evento, immagine 
        FROM eventi 
        WHERE pubblicato = 1 AND data_evento >= CURDATE()
        ORDER BY data_evento ASC 
        LIMIT 3
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $eventi = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['success' => true, 'data' => $eventi]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>