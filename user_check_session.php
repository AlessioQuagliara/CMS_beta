<?php
session_start();
header('Content-Type: application/json');

// Controlla se la sessione è attiva
if (isset($_SESSION['user'])) {
    echo json_encode(['authenticated' => true, 'user' => $_SESSION['user']]);
} else {
    echo json_encode(['authenticated' => false]);
}
?>