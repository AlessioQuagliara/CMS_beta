<?php
header('Content-Type: application/json');

$db = new SQLite3(__DIR__ . '/../db/database.db');

// For simplicity we use user_id = 1
$userId = 1;

$stmt = $db->prepare('SELECT * FROM cookie_policy_tools WHERE user_id = :user_id ORDER BY id DESC');
$stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
$result = $stmt->execute();

$policies = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $policies[] = $row;
}

echo json_encode($policies);
