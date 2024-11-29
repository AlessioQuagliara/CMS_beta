<?php
require ("../../conn.php");

// Recupera il nome dell'utente dalla richiesta
$data = json_decode(file_get_contents('php://input'), true);
$user_name = $data['user_name'] ?? '';

if (!empty($user_name)) {
    $stmt = $conn->prepare("UPDATE chat_messages SET is_read_admin = 1 WHERE sender_name = ? AND sender_type = 'user'");
    $stmt->bind_param('s', $user_name);
    $stmt->execute();
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>