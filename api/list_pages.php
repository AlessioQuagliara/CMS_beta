<?php
header('Content-Type: application/json');

try {
    $db = new SQLite3(__DIR__ . '/../db/database.db');
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$results = $db->query('SELECT id, title, slug, language, description, keywords, created_at, updated_at FROM pages ORDER BY created_at DESC');

$pages = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $pages[] = $row;
}

echo json_encode($pages);
?>