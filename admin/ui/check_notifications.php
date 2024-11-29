<?php
require ("../../conn.php");

// Conta i messaggi degli utenti non letti dall'admin
$query = "SELECT COUNT(*) as unread_count FROM chat_messages WHERE sender_type = 'user' AND is_read_admin = 0";
$result = $conn->query($query);

$row = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode(['unread_count' => $row['unread_count']]);
?>