<?php 
require ('../../app.php');
loggato();
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
        #notification-badge {
            font-weight: bold;
            text-align: center;
            display: none; /* Nascondi il badge di default */
        }
        #user-list .user-item {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        #user-list .user-item:hover {
            background-color: #f1f1f1;
        }
        
        #user-list .user-item.active {
            background-color: #e9ecef;
        }
        
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
            background-color: #e9ecef;
            color: #000;
        }
        
        #chat-messages .text-end div {
            background-color: #007bff;
            color: #fff;
            margin-left: auto;
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
                <!-- Colonna Utenti -->
                <div class="col-md-4 bg-light border-end" id="user-list" style="overflow-y: auto; height: 630px;">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0">Chat Admin</h4>
                    </div>
                    <!-- Gli utenti verranno caricati dinamicamente -->
                </div>
        
                <!-- Colonna Chat -->
                <div class="col-md-8 d-flex flex-column">
                    <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                        <h5 id="selected-user-name" class="mb-0">Seleziona un utente</h5>
                        <!-- Badge per notifiche -->
                        <span id="chat-notification-badge" style="background-color: red; color: white; border-radius: 50%; padding: 5px 10px; font-size: 14px; display: none;">
                            0
                        </span>
                    </div>
                    <div id="chat-messages" class="flex-grow-1 p-3" style="overflow-y: auto; background-color: #f8f9fa; border-bottom: 1px solid #ddd; height: 500px;">
                        <!-- I messaggi verranno caricati dinamicamente -->
                    </div>
                    <form id="chat-form" class="p-3 bg-light border-top d-flex">
                        <input type="hidden" id="selected-user" value="">
                        <input type="text" id="admin-message" class="form-control me-2" placeholder="Scrivi un messaggio..." autocomplete="off" required>
                        <button type="submit" class="btn btn-primary">Invia</button>
                    </form>
                </div>
            </div>
        </div>


    </main>

    
<?php include '../materials/script.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const userList = document.getElementById('user-list');
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const adminMessage = document.getElementById('admin-message');
    const selectedUser = document.getElementById('selected-user');
    const selectedUserName = document.getElementById('selected-user-name');
    const chatNotificationBadge = document.getElementById('chat-notification-badge');

    // Carica l'elenco degli utenti
    const loadUsers = () => {
        fetch('get_users.php')
            .then(response => response.json())
            .then(data => {
                userList.innerHTML = ''; // Svuota la lista
                data.forEach(user => {
                    const userDiv = document.createElement('div');
                    userDiv.className = 'user-item d-flex justify-content-between align-items-center';
                    userDiv.dataset.userName = user.sender_name;
                    userDiv.style.padding = '10px';
                    userDiv.style.cursor = 'pointer';
                    userDiv.innerHTML = `
                        <div>
                            <strong>${user.sender_name}</strong><br>
                            <span class="text-muted">${user.last_message}</span><br>
                            <small class="text-muted">${new Date(user.last_message_time).toLocaleString()}</small>
                        </div>
                        <span class="badge bg-primary text-white" style="display: none;" id="notification-${user.sender_name}">0</span>
                    `;
                    userDiv.addEventListener('click', () => {
                        selectUser(user.sender_name); // Seleziona l'utente
                    });
                    userList.appendChild(userDiv);

                    // Aggiorna notifiche per ogni utente
                    updateUserNotification(user.sender_name);
                });
            })
            .catch(error => console.error('Errore nel caricamento utenti:', error));
    };

    // Seleziona un utente e carica i suoi messaggi
    const selectUser = (userName) => {
        selectedUser.value = userName;
        selectedUserName.textContent = userName;
        document.getElementById(`notification-${userName}`).style.display = 'none'; // Nascondi il badge per l'utente selezionato
        loadMessages(userName); // Carica i messaggi dell'utente
        markMessagesAsRead(userName); // Marca i messaggi come letti
    };

    // Carica i messaggi per un utente selezionato
    const loadMessages = (userName) => {
        fetch(`get_user_messages.php?user_name=${encodeURIComponent(userName)}`)
            .then(response => response.json())
            .then(data => {
                chatMessages.innerHTML = ''; // Svuota l'area dei messaggi
                data.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = msg.sender_type === 'admin' ? 'text-end' : 'text-start';
                    messageDiv.innerHTML = `
                        <div style="margin-bottom: 10px; padding: 10px; border-radius: 10px; background: ${msg.sender_type === 'admin' ? '#007bff' : '#f1f1f1'}; color: ${msg.sender_type === 'admin' ? '#fff' : '#000'};">
                            ${msg.message}
                        </div>
                    `;
                    chatMessages.appendChild(messageDiv);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight; // Scorri in basso
            })
            .catch(error => console.error('Errore nel caricamento dei messaggi:', error));
    };

    // Invia i messaggi dell'admin
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const userName = selectedUser.value;
        const message = adminMessage.value.trim();

        if (userName && message !== '') {
            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message, sender: 'admin', user_name: userName })
            })
                .then(response => {
                    if (response.ok) {
                        adminMessage.value = ''; // Svuota il campo
                        loadMessages(userName); // Ricarica i messaggi
                    } else {
                        console.error('Errore durante l\'invio del messaggio.');
                    }
                });
        }
    });

    // Marca i messaggi come letti per un utente
    const markMessagesAsRead = (userName) => {
        fetch('mark_as_read.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_name: userName })
        }).catch(error => console.error('Errore nel marcare i messaggi come letti:', error));
    };

    // Aggiorna notifiche per un utente specifico
    const updateUserNotification = (userName) => {
        fetch(`check_notifications_user.php?user_name=${encodeURIComponent(userName)}`)
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById(`notification-${userName}`);
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(error => console.error(`Errore nel controllo notifiche per ${userName}:`, error));
    };

    // Aggiorna notifiche per tutti gli utenti ogni 5 secondi
    setInterval(() => {
        const userItems = document.querySelectorAll('.user-item');
        userItems.forEach(item => {
            const userName = item.dataset.userName;
            updateUserNotification(userName);
        });
    });

    // Carica l'elenco utenti iniziale
    loadUsers();

    // Aggiorna automaticamente l'elenco utenti ogni 30 secondi
    setInterval(loadUsers, 5000);
});
</script>
</body>
</html>
