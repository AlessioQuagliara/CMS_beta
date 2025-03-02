<?php
require_once '../../app.php';
require_once '../../config.php';
require_once '../../models/ChatManager.php';
loggato();

$data = json_decode(file_get_contents("php://input"), true);
$chatManager = new ChatManager($pdo);
$success = $chatManager->inviaMessaggio('admin', $_SESSION['user']['nome'], $data['user_name'], $data['message']);
echo json_encode(['success' => $success]);
?>