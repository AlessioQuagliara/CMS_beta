document.addEventListener('DOMContentLoaded', function () {
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const userMessage = document.getElementById('user-message');

    function loadMessages() {
        fetch('get_messages_user.php')
            .then(response => response.json())
            .then(data => {
                chatMessages.innerHTML = ''; 

                data.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = msg.sender_type === 'user' ? 'message user' : 'message admin';
                    
                    const avatarSrc = msg.sender_type === 'user' 
                        ? 'https://villagesonmacarthur.com/wp-content/uploads/2020/12/Blank-Avatar.png' 
                        : 'https://villagesonmacarthur.com/wp-content/uploads/2020/12/Blank-Avatar.png';

                    messageDiv.innerHTML = `<img src="${avatarSrc}" class="avatar"><div>${msg.message}</div>`;
                    chatMessages.appendChild(messageDiv);
                });

                chatMessages.scrollTop = chatMessages.scrollHeight; 
            })
            .catch(error => console.error('❌ Errore nel caricamento dei messaggi:', error));
    }

    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = userMessage.value.trim();
        if (!message) return;

        fetch('send_message_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(() => {
            userMessage.value = ''; 
            loadMessages(); 
        })
        .catch(error => console.error('❌ Errore durante l\'invio:', error));
    });

    setInterval(loadMessages, 5000);
    loadMessages();
});