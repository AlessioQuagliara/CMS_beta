<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['page_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing page_id']);
    exit;
}

$pageId = intval($data['page_id']);

try {
    $db = new SQLite3(__DIR__ . '/../db/database.db');
    $stmt = $db->prepare('DELETE FROM pages WHERE id = :id');
    $stmt->bindValue(':id', $pageId, SQLITE3_INTEGER);
    $stmt->execute();

    if ($db->changes() > 0) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Pagina non trovata']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore interno: ' . $e->getMessage()]);
}
