<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (!isset($_GET['slug'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing page slug']);
    exit;
}

$slug = $_GET['slug'];
$dbPath = __DIR__ . '/../db/database.db';

if (!file_exists($dbPath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Database not found']);
    exit;
}

$db = new SQLite3($dbPath);

$stmt = $db->prepare('SELECT title, slug, description, keywords, language, content FROM pages WHERE slug = :slug LIMIT 1');
$stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
$result = $stmt->execute();

if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo json_encode([
        'title' => $row['title'],
        'slug' => $row['slug'],
        'description' => $row['description'],
        'keywords' => $row['keywords'],
        'language' => $row['language'],
        'content' => $row['content']
    ]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Page not found']);
}

$db->close();
?>