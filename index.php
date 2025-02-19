<?php
session_start();
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
} else {
    require_once 'app.php';
    require 'visita.php';
    require 'conn.php';

    // Controllo dello slug
    $slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8') : 'home';

    // Se lo slug è 'dashboard', controlla la sessione utente
    if ($slug === 'dashboard') {
        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: /Login");
            exit();
        }
    }

    // Controlla se l'utente è autenticato (usato per il placeholder)
    $userPlaceholder = 'ospite';
    if (isset($_SESSION['user'])) {
        $userPlaceholder = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');
    }

    // Caricamento contenuto in base allo slug
    $stmt = $conn->prepare("SELECT * FROM seo WHERE slug = ?");
    if ($stmt) {
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $page = $result->fetch_assoc();

        if (!$page) {
            header("Location: error.php");
            exit();
        }

        // Sostituisci il placeholder nel contenuto
        if (isset($page['content'])) {
            $page['content'] = str_replace('{{ nome }}', $userPlaceholder, $page['content']);
        }
    } else {
        header("Location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title'] ?? 'Default Title'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['description'] ?? 'Default Description'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page['keywords'] ?? 'Default Keywords'); ?>">
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page['title'] ?? 'Default Title'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page['description'] ?? 'Default Description'); ?>">
    <meta property="og:image" content="src/media_system/logo_site.png">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <?php include 'marketing/market_integration.php'; ?>
</head>

<body>
    <?php
    if (function_exists('customNav')) {
        customNav();
    } else {
        echo "<p>Errore: funzione customNav non definita.</p>";
    }

    if (function_exists('customPage')) {
        customPage($slug);
    } else {
        echo "<p>Errore: funzione customPage non definita.</p>";
    }

    if (function_exists('customFooter')) {
        customFooter();
    } else {
        echo "<p>Errore: funzione customFooter non definita.</p>";
    }

    include('public/cookie_banner.php');
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatMessages = document.getElementById('chat-messages');
            const chatForm = document.getElementById('chat-form');
            const userMessage = document.getElementById('user-message');

            // Carica i messaggi esistenti
            const loadMessages = () => {
                fetch('load_messages.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Errore nel caricamento dei messaggi.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        chatMessages.innerHTML = ''; // Svuota l'area dei messaggi
                        data.forEach(msg => {
                            const messageDiv = document.createElement('div');
                            messageDiv.className = msg.sender_type === 'admin' ? 'text-start' : 'text-end';
                            messageDiv.innerHTML = `
                                <div style="margin-bottom: 10px; padding: 10px; border-radius: 10px; background: ${msg.sender_type === 'admin' ? '#f1f1f1' : '#007bff'}; color: ${msg.sender_type === 'admin' ? '#000' : '#fff'};">
                                    ${msg.message}
                                </div>
                            `;
                            chatMessages.appendChild(messageDiv);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight; // Scorri in basso
                    })
                    .catch(error => {
                        console.error('Errore:', error);
                        chatMessages.innerHTML = '<p style="color: red;">Errore nel caricamento dei messaggi.</p>';
                    });
            };

            // Invia messaggi
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const message = userMessage.value.trim();
                if (message !== '') {
                    fetch('send_message.php', {
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

            // Carica i messaggi iniziali
            loadMessages();

            // Aggiorna automaticamente i messaggi ogni 5 secondi
            setInterval(loadMessages, 5000);
        });

    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('eventi-container');
        fetch('public/api_eventi_prossimi.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    container.innerHTML = ''; // Svuota il contenitore
                    data.data.forEach(evento => {
                        const eventHTML = `
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 15px;">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <img src="uploads/events/${evento.immagine}" alt="${evento.titolo}" class="img-fluid rounded" style="height: 150px; object-fit: cover; border-radius: 10px;">
                                        </div>
                                        <h5 class="fw-bold text-warning">${evento.titolo}</h5>
                                        <p class="text-muted">${evento.descrizione.substring(0, 100)}...</p>
                                        <p class="text-muted"><small>${new Date(evento.data_evento).toLocaleDateString('it-IT')}</small></p>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += eventHTML;
                    });
                } else {
                    container.innerHTML = '<p class="text-center text-danger">Errore nel caricamento degli eventi.</p>';
                }
            })
            .catch(error => {
                console.error('Errore nel caricamento degli eventi:', error);
                container.innerHTML = '<p class="text-center text-danger">Errore nel caricamento degli eventi.</p>';
            });
    });
</script>
<?php require_once 'cart_edit.php'; ?>
</body>

</html>