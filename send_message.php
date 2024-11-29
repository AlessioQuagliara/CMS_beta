<?php
session_start();
require ("conn.php");

// Genera un nome utente random se non è già in sessione
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = 'User_' . rand(1000, 9999);
}

$user_name = $_SESSION['user_name'];

// Recupera il messaggio inviato
$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'] ?? '';

if (!empty($message)) {
    $stmt = $conn->prepare("INSERT INTO chat_messages (sender_type, message, sender_name) VALUES ('user', ?, ?)");
    $stmt->bind_param('ss', $message, $user_name);
    $stmt->execute();
    $stmt->close();
}
?>