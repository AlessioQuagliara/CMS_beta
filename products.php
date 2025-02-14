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

        $limit = 20;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        // Filtro per ricerca
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $mezzo_pubblicitario = isset($_GET['mezzo_pubblicitario']) ? trim($_GET['mezzo_pubblicitario']) : '';
        $genere = isset($_GET['genere']) ? trim($_GET['genere']) : '';
        $eta = isset($_GET['eta']) ? trim($_GET['eta']) : '';
        $concessionaria = isset($_GET['concessionaria']) ? trim($_GET['concessionaria']) : '';
        $tipo_periodo = isset($_GET['tipo_periodo']) ? trim($_GET['tipo_periodo']) : '';

        // Costruzione della query dinamica con filtri
        $query = "SELECT * FROM prodotti_pubblicitari WHERE 1=1";
        $params = [];
        $types = "";

        // Aggiunta dei filtri dinamicamente
        if ($search) {
            $query .= " AND (nome LIKE ? OR slug LIKE ? OR description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "sss";
        }

        if ($mezzo_pubblicitario) {
            $query .= " AND mezzo_pubblicitario = ?";
            $params[] = $mezzo_pubblicitario;
            $types .= "s";
        }

        if ($genere) {
            $query .= " AND genere = ?";
            $params[] = $genere;
            $types .= "s";
        }

        if ($eta) {
            $query .= " AND eta = ?";
            $params[] = $eta;
            $types .= "s";
        }

        if ($concessionaria) {
            $query .= " AND concessionaria = ?";
            $params[] = $concessionaria;
            $types .= "s";
        }

        if ($tipo_periodo) {
            $query .= " AND tipo_periodo = ?";
            $params[] = $tipo_periodo;
            $types .= "s";
        }

        // Aggiunta della paginazione
        $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        // Preparazione ed esecuzione della query
        $stmt = $conn->prepare($query);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        // Conteggio totale per la paginazione
        $count_query = "SELECT COUNT(*) as total FROM prodotti_pubblicitari WHERE 1=1";
        $stmt_count = $conn->prepare($count_query);
        $stmt_count->execute();
        $count_result = $stmt_count->get_result();
        $total_products = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_products / $limit);


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
    <title><?php echo htmlspecialchars($page['title'] ?? 'Acquista'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['description'] ?? 'Acquista ora i nostri prodotti pubblicitari'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page['keywords'] ?? 'DSP'); ?>">
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
    ?>

    <br><br><br>

<div class="container mt-4">
        <h1 class="text-center">Prodotti Pubblicitari</h1>

        <!-- Form di Ricerca e Filtri -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cerca per nome, slug o descrizione" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-2">
                <select name="mezzo_pubblicitario" class="form-select">
                    <option value="">Mezzo Pubblicitario</option>
                    <option value="Tv" <?php echo $mezzo_pubblicitario == 'Tv' ? 'selected' : ''; ?>>Tv</option>
                    <option value="Radio" <?php echo $mezzo_pubblicitario == 'Radio' ? 'selected' : ''; ?>>Radio</option>
                    <option value="Quotidiani" <?php echo $mezzo_pubblicitario == 'Quotidiani' ? 'selected' : ''; ?>>Quotidiani</option>
                    <option value="Periodici" <?php echo $mezzo_pubblicitario == 'Periodici' ? 'selected' : ''; ?>>Periodici</option>
                    <option value="Digital" <?php echo $mezzo_pubblicitario == 'Digital' ? 'selected' : ''; ?>>Digital</option>
                    <option value="OOH" <?php echo $mezzo_pubblicitario == 'OOH' ? 'selected' : ''; ?>>OOH</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="genere" class="form-select">
                    <option value="">Genere</option>
                    <option value="Uomo" <?php echo $genere == 'Uomo' ? 'selected' : ''; ?>>Uomo</option>
                    <option value="Donna" <?php echo $genere == 'Donna' ? 'selected' : ''; ?>>Donna</option>
                    <option value="Entrambi" <?php echo $genere == 'Entrambi' ? 'selected' : ''; ?>>Entrambi</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="eta" class="form-control" placeholder="Età target" value="<?php echo htmlspecialchars($eta); ?>">
            </div>
            <div class="col-md-2">
                <select name="concessionaria" class="form-select">
                    <option value="">Seleziona Concessionaria</option>
                    <option value="Sipra" <?php echo $concessionaria == 'Sipra' ? 'selected' : ''; ?>>Sipra</option>
                    <option value="Publitalia 80" <?php echo $concessionaria == 'Publitalia 80' ? 'selected' : ''; ?>>Publitalia 80</option>
                    <option value="Mediamond" <?php echo $concessionaria == 'Mediamond' ? 'selected' : ''; ?>>Mediamond</option>
                    <option value="Manzoni" <?php echo $concessionaria == 'Manzoni' ? 'selected' : ''; ?>>Manzoni</option>
                    <option value="Piemme" <?php echo $concessionaria == 'Piemme' ? 'selected' : ''; ?>>Piemme</option>
                    <option value="Speed" <?php echo $concessionaria == 'Speed' ? 'selected' : ''; ?>>Speed</option>
                    <option value="CairoRCS" <?php echo $concessionaria == 'CairoRCS' ? 'selected' : ''; ?>>CairoRCS</option>
                    <option value="Pubbliesse" <?php echo $concessionaria == 'Pubbliesse' ? 'selected' : ''; ?>>Pubbliesse</option>
                    <option value="IGPDecaux" <?php echo $concessionaria == 'IGPDecaux' ? 'selected' : ''; ?>>IGPDecaux</option>
                    <option value="Digitalia 08" <?php echo $concessionaria == 'Digitalia 08' ? 'selected' : ''; ?>>Digitalia 08</option>
                    <option value="RDS adv" <?php echo $concessionaria == 'RDS adv' ? 'selected' : ''; ?>>RDS adv</option>
                    <option value="Open Space" <?php echo $concessionaria == 'Open Space' ? 'selected' : ''; ?>>Open Space</option>
                    <option value="Wayap" <?php echo $concessionaria == 'Wayap' ? 'selected' : ''; ?>>Wayap</option>
                    <option value="Carminati" <?php echo $concessionaria == 'Carminati' ? 'selected' : ''; ?>>Carminati</option>
                    <option value="Salina" <?php echo $concessionaria == 'Salina' ? 'selected' : ''; ?>>Salina</option>
                    <option value="Publiadige" <?php echo $concessionaria == 'Publiadige' ? 'selected' : ''; ?>>Publiadige</option>
                </select>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Filtra</button>
                <a href="products.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Lista Prodotti -->
        <div class="row">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['nome']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                            <p class="card-text"><strong>Mezzo:</strong> <?php echo htmlspecialchars($product['mezzo_pubblicitario']); ?></p>
                            <p class="card-text"><strong>Genere:</strong> <?php echo htmlspecialchars($product['genere']); ?></p>
                            <p class="card-text"><strong>Età Target:</strong> <?php echo htmlspecialchars($product['eta']); ?></p>
                            <a href="product_details.php?slug=<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-sm btn-primary">Dettagli</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Paginazione -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <?php
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
</body>

</html>