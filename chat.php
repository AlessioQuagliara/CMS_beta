<?php
session_start();
require_once 'app.php';

if (!isset($_SESSION['user'])) {
    header('Location: Login');
    exit();
}

$userName = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Assistenza</title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <link rel="stylesheet" href="chat.css">
</head>
<body>
<?php
    if (function_exists('customNav')) {
        customNav();
    } else {
        echo "<p>Errore: funzione customNav non definita.</p>";
    }
?>
<nav class="navbar navbar-dark bg-dark navbar-expand fixed-bottom shadow-lg">
    <div class="container-fluid d-flex justify-content-around">
        <a class="nav-link text-white" href="dashboard.php">
            <i class="fa fa-home"></i> <br>Dashboard
        </a>
        <a class="nav-link text-white" href="chat.php">
            <i class="fa fa-comments"></i> <br>Chat
        </a>
        <a class="nav-link text-white" href="logout.php">
            <i class="fa fa-sign-out-alt"></i> <br>Logout
        </a>
    </div>
</nav>

<br><br><br>

<div class="container mt-4">
    <div class="chat-container">
        <div class="p-3 bg-primary text-white text-center">
            <h5 class="mb-0">Chat Assistenza</h5>
        </div>
        <div id="chat-messages"></div>
        <form id="chat-form" class="chat-form">
            <input type="text" id="user-message" placeholder="Scrivi un messaggio..." autocomplete="off" required>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script/chat_user.js"></script>
</body>
</html>