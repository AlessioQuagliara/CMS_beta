<?php
session_start();
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
} else {
    require_once 'app.php';
    require 'visita.php';
    require 'conn.php';
    require 'config.php';

    // Controllo dello slug
    $slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8') : 'home';

    // Se lo slug è 'dashboard', controlla la sessione utente
    if ($slug === 'dashboard') {
        if (!isset($_SESSION['user'])) {
            header("Location: /Login");
            exit();
        }
    }

    // Controlla se è presente un errore passato tramite GET
    $errorMsg = isset($_GET['error']) ? htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') : null;
    $successMsg = isset($_GET['success']) ? htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8') : null;

    // Controlla se l'utente è autenticato (usato per il placeholder)
    $userPlaceholder = 'ospite';
    if (isset($_SESSION['user'])) {
        $userPlaceholder = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info - Login</title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
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
    <br><br><br><br><br><br><br><br><br><br><br><br>

<section class="container-fluid my-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <?php if (!empty($successMsg)): ?>
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <i class="fa fa-check-circle"></i> Operazione riuscita
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text"><?php echo $successMsg; ?></p>
                        <a href="/Login" class="btn btn-primary">Login</a>
                    </div>
                </div>
            <?php elseif (!empty($errorMsg)): ?>
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <i class="fa fa-exclamation-circle"></i> Errore
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text"><?php echo $errorMsg; ?></p>
                        <a href="/Login" class="btn btn-primary">Login</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

    <br><br><br><br><br><br><br><br><br>

    <?php
    if (function_exists('customFooter')) {
        customFooter();
    } else {
        echo "<p>Errore: funzione customFooter non definita.</p>";
    }

    include('public/cookie_banner.php');
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>