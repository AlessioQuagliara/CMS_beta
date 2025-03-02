<?php
session_start();
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
} else {
    session_start();
    require_once 'app.php';
    require_once 'visita.php';
    require_once 'conn.php';
    require_once 'config.php';
    
    // Recupera l'ID utente dalla query string, con fallback alla sessione
    $userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : (isset($_SESSION['user']['id_utente']) ? $_SESSION['user']['id_utente'] : null);
    
    // Se l'ID utente non è presente, mostra errore e interrompi l'esecuzione
    if (!$userId) {
        die("❌ ERRORE: ID utente non trovato.");
    }
    
    $errorMsg = isset($_GET['error']) ? htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') : null;

    // Controllo sessione
    if (!isset($_SESSION['user'])) {
        header("Location: /Login");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa i Dati</title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <?php include 'marketing/market_integration.php'; ?>
</head>
<body>
    <?php if (function_exists('customNav')) customNav(); ?>

    <br><br><br>

    <section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h5>Completa i Dati</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($errorMsg)): ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle"></i> <?php echo $errorMsg; ?>
                        </div>
                    <?php endif; ?>

                    <form action="salva_dati_utente.php" method="POST">
                        <input type="hidden" name="id_utente" value="<?php echo $userId; ?>">

                        <!-- 🔹 Sezione 1: Codice Fiscale e Partita IVA -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codice_fiscale" class="form-label">Codice Fiscale</label>
                                <input type="text" class="form-control" name="codice_fiscale" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="partita_iva" class="form-label">Partita IVA</label>
                                <input type="text" class="form-control" name="partita_iva">
                            </div>
                        </div>

                        <!-- 🔹 Sezione 2: Ragione Sociale e Indirizzo -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ragione_sociale" class="form-label">Ragione Sociale</label>
                                <input type="text" class="form-control" name="ragione_sociale">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="indirizzo" class="form-label">Indirizzo</label>
                                <input type="text" class="form-control" name="indirizzo" required>
                            </div>
                        </div>

                        <!-- 🔹 Sezione 3: CAP e Città -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cap" class="form-label">CAP</label>
                                <input type="text" class="form-control" name="cap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="citta" class="form-label">Città</label>
                                <input type="text" class="form-control" name="citta" required>
                            </div>
                        </div>

                        <!-- 🔹 Sezione 4: Provincia e Nazione -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="provincia" class="form-label">Provincia</label>
                                <input type="text" class="form-control" name="provincia" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nazione" class="form-label">Nazione</label>
                                <input type="text" class="form-control" name="nazione" required>
                            </div>
                        </div>

                        <!-- 🔹 Bottone di Invio -->
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa fa-save"></i> Salva Dati
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

    <?php if (function_exists('customFooter')) customFooter(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>