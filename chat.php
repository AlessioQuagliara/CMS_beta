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
    <title>Chat Assistenza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</head>
<body>
<?php
    if (function_exists('customNav')) {
        customNav();
    } else {
        echo "<p>Errore: funzione customNav non definita.</p>";
    }
?>
    <!-- Menu Footer Fisso -->
<nav class="navbar navbar-dark bg-dark navbar-expand fixed-bottom shadow-lg">
    <div class="container-fluid d-flex justify-content-around">
        <a class="nav-link text-white" href="dashboard.php">
            <i class="fa fa-home"></i> <br>Dashboard
        </a>
        <a class="nav-link text-white" href="chat.php">
            <i class="fa fa-comments"></i> <br>Chat
        </a>
        <a class="nav-link text-white" href="eventi.php">
            <i class="fa fa-calendar-alt"></i> <br>Eventi
        </a>
        <a class="nav-link text-white" href="logout.php">
            <i class="fa fa-sign-out-alt"></i> <br>Logout
        </a>
    </div>
</nav>

    <!-- Contenuto della pagina -->
    <div class="container mt-4">
        <button class="btn btn-primary" id="toggle-sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Messaggio personalizzato -->
        <div class="container text-center mt-3">
            <div class="row">
                <div class="col">
                    <h1 style="color:rgb(0, 0, 0);">Chat</h1>
                    <p class="lead">Ciao, <strong><?php echo $userName; ?></strong>! Siamo felici di rivederti.</p>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- Colonna Chat -->
                <div class="col-12 d-flex flex-column">
                    <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                        <h5>Scrivici!</h5>
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