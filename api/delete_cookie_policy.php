<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing id']);
    exit;
}

$userId = 1;

$db = new SQLite3(__DIR__ . '/../db/database.db');

$stmt = $db->prepare('DELETE FROM cookie_policy_tools WHERE id = :id AND user_id = :user_id');
$stmt->bindValue(':id', $data['id'], SQLITE3_INTEGER);
$stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
