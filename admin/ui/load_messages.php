<?php
require ("../../conn.php");

// Carica tutti i messaggi dal database ordinati per data
$query = "SELECT sender_name, sender_type, message, created_at FROM chat_messages ORDER BY created_at ASC";
$result = $conn->query($query);

$messages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Restituisce i messaggi in formato JSON
header('Content-Type: application/json');
echo json_encode($messages);
?>