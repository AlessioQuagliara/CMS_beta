<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['slug']) || !isset($data['content'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input: missing slug or content']);
    exit;
}

$slug = $data['slug'];
$content = $data['content'];

try {
    $db = new SQLite3(__DIR__ . '/../db/database.db');

    $stmt = $db->prepare("UPDATE pages SET content = :content, updated_at = :updated_at WHERE slug = :slug");
    $stmt->bindValue(':content', $content, SQLITE3_TEXT);
    $stmt->bindValue(':updated_at', date('c'), SQLITE3_TEXT);
    $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);

    $result = $stmt->execute();

    if ($db->changes() > 0) {
        echo json_encode(['success' => true, 'message' => 'Pagina salvata con successo!']);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Pagina non trovata o contenuto invariato']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nel database: ' . $e->getMessage()]);
}