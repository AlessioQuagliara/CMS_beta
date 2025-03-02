document.addEventListener('DOMContentLoaded', function () {
    const chatApp = {
        userList: document.getElementById('user-list'),
        chatMessages: document.getElementById('chat-messages'),
        chatForm: document.getElementById('chat-form'),
        adminMessage: document.getElementById('admin-message'),
        selectedUser: document.getElementById('selected-user'),
        selectedUserName: document.getElementById('selected-user-name'),
        activeUser: null
    };

    function loadUsers() {
        fetch('get_users.php')
            .then(response => response.json())
            .then(data => {
                chatApp.userList.innerHTML = '';
                data.forEach(user => {
                    const userDiv = document.createElement('div');
                    userDiv.className = 'user-item p-2';
                    userDiv.dataset.userName = user.user_name;
                    userDiv.innerHTML = `<strong>${user.user_name}</strong>`;
                    userDiv.addEventListener('click', () => selectUser(user.user_name));
                    chatApp.userList.appendChild(userDiv);
                });
            })
            .catch(error => console.error('Errore caricamento utenti:', error));
    }

    function selectUser(userName) {
        if (!userName) return;
        chatApp.selectedUser.value = userName;
        chatApp.selectedUserName.textContent = userName;
        chatApp.activeUser = userName;
        loadMessages(userName);
    }

    function loadMessages(userName) {
        fetch(`get_messages_admin.php?user_name=${encodeURIComponent(userName)}`)
            .then(response => response.json())
            .then(data => {
                chatApp.chatMessages.innerHTML = '';
                data.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = msg.sender_type === 'admin' ? 'text-end' : 'text-start';
                    messageDiv.innerHTML = `<div class="p-2 rounded">${msg.message}</div>`;
                    chatApp.chatMessages.appendChild(messageDiv);
                });
                chatApp.chatMessages.scrollTop = chatApp.chatMessages.scrollHeight;
            })
            .catch(error => console.error('Errore caricamento messaggi:', error));
    }

    chatApp.chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const userName = chatApp.selectedUser.value;
        const message = chatApp.adminMessage.value.trim();
        if (!userName || !message) return;

        fetch('send_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message, sender_type: 'admin', user_name: userName })
        })
        .then(response => response.json())
        .then(() => {
            chatApp.adminMessage.value = '';
            loadMessages(userName);
        })
        .catch(error => console.error('Errore invio messaggio:', error));
    });

    loadUsers();
    setInterval(() => {
        if (chatApp.activeUser) {
            loadMessages(chatApp.activeUser);
        }
    }, 3000);
});