<?php
session_start();
unset($_SESSION['user']); // Distruggi solo la sessione utente
header('Location: login');
exit();
?>