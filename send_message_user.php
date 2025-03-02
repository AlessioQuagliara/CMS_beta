<?php
session_start();
require_once 'config.php';
require_once 'models/ChatManager.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Accesso negato']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['message']) || empty(trim($data['message']))) {
    http_response_code(400);
    echo json_encode(['error' => 'Messaggio vuoto']);
    exit();
}

$userName = $_SESSION['user']['nome'];
$chatManager = new ChatManager($pdo);
$success = $chatManager->inviaMessaggio('user', $userName, 'admin', $data['message']);
echo json_encode(['success' => $success]);
?>