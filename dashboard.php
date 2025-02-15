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

// Recupera gli eventi dal database
try {
    $stmt = $conn->prepare("
        SELECT id_evento, titolo, descrizione, categoria, data_evento, immagine
        FROM eventi
        WHERE pubblicato = 1
        ORDER BY data_evento DESC
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $eventi = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    die("Errore durante il recupero degli eventi: " . $e->getMessage());
}

$nomeUtente = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard utente</title>
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
        <button class="btn btn-primary" id="toggle-sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <h1 style="color:rgb(0, 56, 73);"> Dashboard </h1>
                </div>
            </div>
          </div>


          <div class="row mt-4">
              <?php if (!empty($eventi)) : ?>
                  <?php foreach ($eventi as $evento) : ?>
                      <div class="col-lg-4 col-md-6 mb-4">
                          <a href="event.php?id=<?php echo htmlspecialchars($evento['id_evento']); ?>" style="text-decoration: none;">
                              <div class="card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid rgba(0, 0, 0, 0.1);">
                                  <div class="row g-0 align-items-center">
                                  <div class="card-img-top" style="height: 150px; background: url('uploads/events/<?php echo htmlspecialchars($evento['immagine'], ENT_QUOTES, 'UTF-8'); ?>') center center / cover no-repeat;">
                                  </div>
                                      <!-- Colonna sinistra: Calendario -->
                                      <div class="col-4 text-center" style="background-color: #f9f9f9; padding: 20px;">
                                          <div style="font-size: 0.8rem; color: #555;">Mese</div>
                                          <div style="font-size: 1.8rem; font-weight: bold; color: #003f88;">
                                              <?php echo strtoupper(date('M', strtotime($evento['data_evento']))); ?>
                                          </div>
                                          <div style="font-size: 2rem; font-weight: bold; color: #003f88;">
                                              <?php echo date('d', strtotime($evento['data_evento'])); ?>
                                          </div>
                                      </div>
          
                                      <!-- Colonna destra: Contenuto -->
                                      <div class="col-8">
                                          <div class="card-body">
                                              <h5 class="card-title mb-2" style="font-weight: bold; color: #f08046;">
                                                  <?php echo htmlspecialchars($evento['titolo'], ENT_QUOTES, 'UTF-8'); ?>
                                              </h5>
                                              <p class="card-text text-muted" style="font-size: 0.9rem;">
                                                  <?php echo htmlspecialchars($evento['descrizione'], ENT_QUOTES, 'UTF-8'); ?>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
        
                              </div>
                          </a>
                      </div>
                  <?php endforeach; ?>
              <?php else : ?>
                  <div class="col-12 text-center">
                      <p class="text-muted">Nessun evento disponibile al momento.</p>
                  </div>
              <?php endif; ?>
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