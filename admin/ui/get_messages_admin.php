<?php
require_once '../../app.php';
require_once '../../config.php';
require_once '../../models/ChatManager.php';
loggato();

$userName = $_GET['user_name'] ?? null;

if (!$userName) {
    http_response_code(400);
    echo json_encode(['error' => 'Nome utente mancante']);
    exit();
}

$chatManager = new ChatManager($pdo);
$messages = $chatManager->getMessaggiPerAdmin($userName);
echo json_encode($messages);
?>