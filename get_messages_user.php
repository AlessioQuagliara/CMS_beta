<?php
session_start();
require_once 'config.php';
require_once 'models/ChatManager.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Accesso negato']);
    exit();
}

$userName = $_SESSION['user']['nome'];
$chatManager = new ChatManager($pdo);
$messages = $chatManager->getMessaggiPerUtente($userName);
echo json_encode($messages);
?>