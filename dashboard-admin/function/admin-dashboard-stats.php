

<?php
header('Content-Type: application/json');

$db = new SQLite3(__DIR__ . '/../../db/database.db');

$today = date('Y-m-d');

$usersStmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = :today");
$usersStmt->bindValue(':today', $today);
$usersResult = $usersStmt->execute()->fetchArray(SQLITE3_ASSOC);
$usersToday = $usersResult['count'] ?? 0;

$viewsStmt = $db->prepare("SELECT COUNT(*) as count FROM views WHERE DATE(viewed_at) = :today");
$viewsStmt->bindValue(':today', $today);
$viewsResult = $viewsStmt->execute()->fetchArray(SQLITE3_ASSOC);
$viewsToday = $viewsResult['count'] ?? 0;

echo json_encode([
    'usersToday' => $usersToday,
    'viewsToday' => $viewsToday
]);