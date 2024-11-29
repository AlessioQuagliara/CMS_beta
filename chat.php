<?php
session_start();
require_once 'app.php'; // Connessione al database

// Controlla se l'utente è loggato
if (!isset($_SESSION['user'])) {
    header('Location: Login');
    exit();
}

// Recupera il nome dell'utente dalla sessione
$userName = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat con AssoLabFondi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <style>
        #chat-messages .text-start,
        #chat-messages .text-end {
            margin-bottom: 10px;
        }

        #chat-messages .text-start div,
        #chat-messages .text-end div {
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 75%;
            word-wrap: break-word;
        }

        #chat-messages .text-start div {
            background-color: #f8f9fa;
            color: #000;
        }

        #chat-messages .text-end div {
            background-color: #007bff;
            color: #fff;
            margin-left: auto;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #003f88;
            color: #fff;
            transition: left 0.3s ease;
            z-index: 1040;
        }
        .sidebar.active {
            left: 0;
        }
        .sidebar .nav-link {
            color: #fff;
            transition: background-color 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #0056b3;
        }
        .sidebar-header {
            padding: 1rem;
            font-size: 1.25rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1030;
        }
        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Overlay -->
    <div class="overlay" id="menu-overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <strong><img src="src/media_system/logo_site.png" width="150px"></strong>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="dashboard.php">Eventi</a>
            <a class="nav-link" href="chat.php">Chat</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </nav>
    </div>

    <!-- Contenuto della pagina -->
    <div class="container mt-4">
        <button class="btn btn-primary" id="toggle-sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Messaggio personalizzato -->
        <div class="container text-center mt-3">
            <div class="row">
                <div class="col">
                    <h1 style="color: #f08046;">Chat con AssoLabFondi</h1>
                    <p class="lead">Ciao, <strong><?php echo $userName; ?></strong>! Siamo felici di rivederti.</p>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- Colonna Chat -->
                <div class="col-12 d-flex flex-column">
                    <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                        <h5>Chat con Sergio</h5>
                    </div>
                    <div id="chat-messages" class="flex-grow-1 p-3" style="overflow-y: auto; background-color: #f8f9fa; border-bottom: 1px solid #ddd; height: 500px;">
                        <!-- I messaggi verranno caricati dinamicamente -->
                    </div>
                    <form id="chat-form" class="p-3 bg-light border-top d-flex">
                        <input type="text" id="user-message" class="form-control me-2" placeholder="Scrivi un messaggio..." autocomplete="off" required>
                        <button type="submit" class="btn btn-primary">Invia</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <?php
        if (function_exists('customFooter')) {
            customFooter();
        } else {
            echo "<p>Errore: funzione customFooter non definita.</p>";
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Selettori
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarButton = document.getElementById('toggle-sidebar');
        const menuOverlay = document.getElementById('menu-overlay');

        // Mostra/nascondi sidebar
        toggleSidebarButton.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            menuOverlay.classList.toggle('active');
        });

        // Chiudi sidebar cliccando sull'overlay
        menuOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            menuOverlay.classList.remove('active');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatMessages = document.getElementById('chat-messages');
            const chatForm = document.getElementById('chat-form');
            const userMessage = document.getElementById('user-message');

            // Funzione per caricare i messaggi
            const loadMessages = () => {
                fetch('get_messages_user.php')
                    .then(response => response.json())
                    .then(data => {
                        chatMessages.innerHTML = ''; // Svuota l'area dei messaggi
                        data.forEach(msg => {
                            const messageDiv = document.createElement('div');
                            messageDiv.className = msg.sender_type === 'user' ? 'text-end' : 'text-start';
                            messageDiv.innerHTML = `
                                <div style="margin-bottom: 10px; padding: 10px; border-radius: 10px; background: ${msg.sender_type === 'user' ? '#007bff' : '#f8f9fa'}; color: ${msg.sender_type === 'user' ? '#fff' : '#000'};">
                                    ${msg.message}
                                </div>
                            `;
                            chatMessages.appendChild(messageDiv);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight; // Scorri in basso
                    })
                    .catch(error => console.error('Errore nel caricamento dei messaggi:', error));
            };

            // Carica i messaggi iniziali
            loadMessages();

            // Aggiorna automaticamente i messaggi ogni 3 secondi
            setInterval(loadMessages, 3000);

            // Invio messaggi
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const message = userMessage.value.trim();

                if (message !== '') {
                    fetch('send_message_user.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ message })
                    })
                        .then(response => {
                            if (response.ok) {
                                userMessage.value = ''; // Svuota il campo
                                loadMessages(); // Ricarica i messaggi
                            } else {
                                console.error('Errore durante l\'invio del messaggio.');
                            }
                        });
                }
            });
        });
    </script>
</body>
</html>