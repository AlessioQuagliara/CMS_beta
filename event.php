<?php
session_start();
require_once 'app.php'; // Connessione al database

// Recupera l'id_evento dalla URL in modo sicuro
$id_evento = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Controlla se l'utente è loggato
if (!isset($_SESSION['user'])) {
    header('Location: Login');
    exit();
}

// Recupera il nome dell'utente dalla sessione
$userName = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');

// Controlla che l'ID evento sia valido
if (!$id_evento) {
    die('ID evento non valido o mancante.');
}

// Recupera l'evento dal database in modo sicuro
try {
    $stmt = $conn->prepare("SELECT * FROM eventi WHERE id_evento = ?");
    $stmt->bind_param('i', $id_evento);
    $stmt->execute();
    $result = $stmt->get_result();
    $evento = $result->fetch_assoc();

    if (!$evento) {
        die('Evento non trovato.');
    }
} catch (Exception $e) {
    die("Errore durante il recupero dell'evento: " . $e->getMessage());
}

$dataEuropea = date('d/m/Y', strtotime($evento['data_evento']));
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($evento['titolo'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <style>
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
    <button class="btn btn-primary mb-4" id="toggle-sidebar">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="row justify-content-start">
        <div class="col-12">
            <div class="text-left px-4 py-3" style="border-left: 4px;">
                <h1 class="display-5" style="color: rgb(240, 126, 70);">
                    <?php echo htmlspecialchars($evento['titolo'], ENT_QUOTES, 'UTF-8'); ?>
                </h1>
                <h6 class="text-primary">
                    <?php echo htmlspecialchars($evento['categoria'], ENT_QUOTES, 'UTF-8'); ?>, 
                    <?php echo htmlspecialchars($dataEuropea, ENT_QUOTES, 'UTF-8'); ?>
                </h6>
                <p class="text-muted">
                    <?php echo htmlspecialchars($evento['descrizione'], ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <img src="uploads/events/<?php echo htmlspecialchars($evento['immagine'], ENT_QUOTES, 'UTF-8'); ?>" 
                     class="rounded mt-3" 
                     style="max-width: 20%; height: auto;" 
                     alt="Immagine Evento">
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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>