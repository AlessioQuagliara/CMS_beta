<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['title']) || empty($data['slug'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Titolo e slug sono obbligatori']);
    exit;
}

$title = trim($data['title']);
$slug = trim($data['slug']);
$language = $data['language'] ?? 'it';
$description = $data['description'] ?? '';
$keywords = $data['keywords'] ?? '';
$content = $data['content'] ?? '';
$created_at = date('c');

try {
    $db = new SQLite3(__DIR__ . '/../db/database.db');

    // Controlla se esiste già una pagina con lo stesso slug
    $check = $db->prepare("SELECT COUNT(*) as count FROM pages WHERE slug = :slug");
    $check->bindValue(':slug', $slug, SQLITE3_TEXT);
    $result = $check->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    if ($row['count'] > 0) {
        http_response_code(409);
        echo json_encode(['error' => 'Slug già esistente']);
        exit;
    }

    // Inserisci la nuova pagina
    $stmt = $db->prepare("INSERT INTO pages (title, slug, language, description, keywords, content, created_at) 
                          VALUES (:title, :slug, :language, :description, :keywords, :content, :created_at)");

    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
    $stmt->bindValue(':language', $language, SQLITE3_TEXT);
    $stmt->bindValue(':description', $description, SQLITE3_TEXT);
    $stmt->bindValue(':keywords', $keywords, SQLITE3_TEXT);
    $stmt->bindValue(':content', $content, SQLITE3_TEXT);
    $stmt->bindValue(':created_at', $created_at, SQLITE3_TEXT);

    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Pagina creata con successo']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore interno: ' . $e->getMessage()]);
}