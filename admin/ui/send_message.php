<?php
session_start();
require ("../../conn.php");


$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'] ?? '';
$sender = $data['sender'] ?? 'user'; // Default a 'user'
$user_name = $data['user_name'] ?? ''; // Nome dell'utente destinatario

if (!empty($message) && !empty($user_name)) {
    $stmt = $conn->prepare("INSERT INTO chat_messages (sender_type, sender_name, message) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $sender, $user_name, $message);
    $stmt->execute();
    $stmt->close();
}
?>
?>