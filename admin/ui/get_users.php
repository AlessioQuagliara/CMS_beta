<?php
require ("../../conn.php");

// Ottieni l'ultimo messaggio per ogni utente
$query = "
    SELECT sender_name, MAX(created_at) as last_message_time, 
           (SELECT message FROM chat_messages cm2 WHERE cm2.sender_name = cm1.sender_name ORDER BY created_at DESC LIMIT 1) as last_message
    FROM chat_messages cm1
    WHERE sender_type = 'user'
    GROUP BY sender_name
    ORDER BY last_message_time DESC
";
$result = $conn->query($query);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($users);
?>