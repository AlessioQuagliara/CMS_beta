<?php
require_once '../../app.php';
require_once '../../config.php';
require_once '../../models/ChatManager.php';
loggato();

$data = json_decode(file_get_contents("php://input"), true);
$userName = $data['user_name'] ?? null;

if (!$userName) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nome utente mancante']);
    exit();
}

$chatManager = new ChatManager($pdo);
$success = $chatManager->marcaMessaggiComeLettiAdmin($userName);
echo json_encode(['success' => $success]);
?>