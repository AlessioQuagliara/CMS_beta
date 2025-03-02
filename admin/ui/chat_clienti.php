<?php 
require_once '../../app.php';
loggato();
require_once '../../config.php';
require_once '../../models/ChatManager.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Chat Clienti</title>
    <?php include '../materials/head_content.php'; ?>
    <style>
        #user-list .user-item {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        #user-list .user-item:hover {
            background-color: #f1f1f1;
        }

        #user-list .user-item.active {
            background-color: #007bff;
            color: white;
        }

        #chat-messages {
            overflow-y: auto;
            height: 450px;
            padding: 10px;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        .text-start div {
            background-color: #e9ecef;
            color: #000;
        }

        .text-end div {
            background-color: #007bff;
            color: #fff;
            margin-left: auto;
        }

        #chat-form input {
            flex-grow: 1;
        }
    </style>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php 
    $sidebar_cate = 'App'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <br>
    <div class="container-fluid">
        <div class="row">
            <!-- Lista utenti -->
            <div class="col-md-4 bg-light border-end" id="user-list" style="overflow-y: auto; height: 500px;">
                <div class="p-3 border-bottom">
                    <h4 class="text-primary mb-0"><i class="fa fa-users"></i> Clienti</h4>
                </div>
            </div>

            <!-- Chat -->
            <div class="col-md-8 d-flex flex-column">
                <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                    <h5 id="selected-user-name" class="mb-0 text-primary">Seleziona un utente</h5>
                </div>

                <div id="chat-messages" class="flex-grow-1 p-3">
                    <div class="text-muted text-center mt-3">Nessun messaggio</div>
                </div>

                <form id="chat-form" class="p-3 bg-light border-top d-flex">
                    <input type="hidden" id="selected-user">
                    <input type="text" id="admin-message" class="form-control me-2" placeholder="Scrivi un messaggio..." autocomplete="off" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane"></i>
                        <span id="send-text">Invia</span>
                        <span id="loading-dots" style="display: none;">...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</main>

    
<?php include '../materials/script.php'; ?>
<script src="chat.js"></script>
</body>
</html>
