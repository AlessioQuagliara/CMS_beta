<?php
require_once '../session/session.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['role']) || !in_array($data['role'], ['admin', 'user'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$db = new SQLite3('../db/database.db');
$table = $data['role'] === 'admin' ? 'admins' : 'users';

$stmt = $db->prepare("SELECT * FROM $table WHERE username = :username");
$stmt->bindValue(':username', $data['username'], SQLITE3_TEXT);
$result = $stmt->execute();
$userFound = $result->fetchArray(SQLITE3_ASSOC);

if (!$userFound || !password_verify($data['password'], $userFound['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}

$session = new SessionManager();
if ($data['role'] === 'admin') {
    $session->createAdminSession($userFound);
} else {
    $session->createUserSession($userFound);
}

echo json_encode(['success' => true]);