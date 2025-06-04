<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || empty($data['provider'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Provider is required']);
    exit;
}

$userId = 1; // static user

$db = new SQLite3(__DIR__ . '/../db/database.db');

if (!empty($data['id'])) {
    // update
    $stmt = $db->prepare('UPDATE cookie_policy_tools SET provider = :provider, embed_code = :embed_code, status = :status WHERE id = :id AND user_id = :user_id');
    $stmt->bindValue(':id', $data['id'], SQLITE3_INTEGER);
    $stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
} else {
    // insert
    $stmt = $db->prepare('INSERT INTO cookie_policy_tools (user_id, provider, embed_code, status, created_at) VALUES (:user_id, :provider, :embed_code, :status, :created_at)');
    $stmt->bindValue(':created_at', date('c'), SQLITE3_TEXT);
}

$stmt->bindValue(':provider', $data['provider'], SQLITE3_TEXT);
$stmt->bindValue(':embed_code', $data['embed_code'] ?? '', SQLITE3_TEXT);
$stmt->bindValue(':status', $data['status'] ?? 'disabled', SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
