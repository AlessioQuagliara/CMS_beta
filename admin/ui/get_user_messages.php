<?php
require ("../../conn.php");

// Recupera il nome dell'utente dai parametri
$user_name = $_GET['user_name'] ?? '';

if (!empty($user_name)) {
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
}
?>