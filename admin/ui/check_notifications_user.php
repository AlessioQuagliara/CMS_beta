<?php
require ('../../conn.php');

// Recupera il nome dell'utente dalla richiesta
$user_name = $_GET['user_name'] ?? '';

if (!empty($user_name)) {
    $query = "SELECT COUNT(*) as unread_count FROM chat_messages WHERE sender_name = ? AND sender_type = 'user' AND is_read_admin = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode(['unread_count' => $row['unread_count']]);
}
?>