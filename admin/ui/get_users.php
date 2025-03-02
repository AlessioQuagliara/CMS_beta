<?php
require_once '../../app.php';
require_once '../../config.php';
require_once '../../models/ChatManager.php';
loggato();

$chatManager = new ChatManager($pdo);
$users = $chatManager->getUtentiConMessaggi();
echo json_encode($users);
?>