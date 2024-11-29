<?php
require ("conn.php");

session_start();
$user_name = $_SESSION['user_name'] ?? '';

// Recupera solo i messaggi per l'utente corrente
$query = "SELECT sender_type, message, created_at FROM chat_messages WHERE sender_name = ? ORDER BY created_at ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_name);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($messages);
?>