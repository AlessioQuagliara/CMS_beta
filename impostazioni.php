<?php
session_start();
require_once 'app.php'; // Connessione al database
require_once 'config.php';
require_once 'models/orders.php';
require_once 'models/user.php';

// Controlla se l'utente è loggato
if (!isset($_SESSION['user'])) {
    header('Location: Login');
    exit();
}

// Recupera l'ID dell'utente dalla sessione
$userId = intval($_SESSION['user']['id_utente']);

// Inizializza il modello e recupera i dati dal database
$userModel = new UserModel($pdo);
$user = $userModel->getUserById($userId);

// Recupera gli ordini dell'utente
$ordersModel = new OrdersModel($pdo);
$userOrders = $ordersModel->getOrdersByUserId($userId);

// Gestione messaggi di successo/errore
$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8') : '';
$errorMessage = isset($_GET['error']) ? htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') : '';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utente - I miei ordini</title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</head>
<body style="background-color: #f1f1f1;">

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
        <a class="nav-link text-white" href="impostazioni.php">
            <i class="fa fa-cog"></i> <br>Impostazioni
        </a>
        <a class="nav-link text-white" href="chat.php">
            <i class="fa fa-comments"></i> <br>Chat
        </a>
        <a class="nav-link text-white" href="logout.php">
            <i class="fa fa-sign-out-alt"></i> <br>Logout
        </a>
    </div>
</nav>

<br><br><br><br><br>

<div class="container mt-5">
    <h2 class="text-center mb-4">🔧 Aggiorna i tuoi dati</h2>

    <!-- Messaggi di successo/errore -->
    <?php if (!empty($successMessage)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle"></i> <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
        
    <?php if (!empty($errorMessage)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle"></i> <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="update_user.php" method="POST" id="updateForm">
        <input type="hidden" name="id_utente" value="<?php echo htmlspecialchars($userId, ENT_QUOTES, 'UTF-8'); ?>">

        <!-- Sezione Dati Personali -->
        <div class="card shadow-sm p-4 mb-4">
            <h4><i class="fa fa-user"></i> Dati Personali</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cognome" class="form-label">Cognome</label>
                    <input type="text" class="form-control" id="cognome" name="cognome" value="<?php echo htmlspecialchars($user['cognome'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
            </div>
        </div>

        <!-- Sezione Contatti -->
        <div class="card shadow-sm p-4 mb-4">
            <h4><i class="fa fa-envelope"></i> Contatti</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Es: +39 345 678 9012" value="<?php echo htmlspecialchars($user['telefono'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>
        </div>

        <!-- Sezione Fiscale -->
        <div class="card shadow-sm p-4 mb-4">
            <h4><i class="fa fa-file-invoice"></i> Dati Fiscali</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="codice_fiscale" class="form-label">Codice Fiscale</label>
                    <input type="text" class="form-control" id="codice_fiscale" name="codice_fiscale" value="<?php echo htmlspecialchars($user['codice_fiscale'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="partita_iva" class="form-label">Partita IVA</label>
                    <input type="text" class="form-control" id="partita_iva" name="partita_iva" value="<?php echo htmlspecialchars($user['partita_iva'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label for="ragione_sociale" class="form-label">Ragione Sociale</label>
                <input type="text" class="form-control" id="ragione_sociale" name="ragione_sociale" value="<?php echo htmlspecialchars($user['ragione_sociale'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>

        <!-- Sezione Indirizzo -->
        <div class="card shadow-sm p-4 mb-4">
            <h4><i class="fa fa-map-marker-alt"></i> Indirizzo</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="indirizzo" class="form-label">Indirizzo</label>
                    <input type="text" class="form-control" id="indirizzo" name="indirizzo" value="<?php echo htmlspecialchars($user['indirizzo'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="cap" class="form-label">CAP</label>
                    <input type="text" class="form-control" id="cap" name="cap" value="<?php echo htmlspecialchars($user['cap'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="citta" class="form-label">Città</label>
                    <input type="text" class="form-control" id="citta" name="citta" value="<?php echo htmlspecialchars($user['citta'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="provincia" class="form-label">Provincia</label>
                    <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo htmlspecialchars($user['provincia'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="nazione" class="form-label">Nazione</label>
                    <select class="form-select" id="nazione" name="nazione" required>
                        <option value="">Seleziona la tua nazione</option>
                        <option value="Italia" <?php echo ($user['nazione'] == 'Italia') ? 'selected' : ''; ?>>Italia</option>
                        <option value="Francia" <?php echo ($user['nazione'] == 'Francia') ? 'selected' : ''; ?>>Francia</option>
                        <option value="Germania" <?php echo ($user['nazione'] == 'Germania') ? 'selected' : ''; ?>>Germania</option>
                        <option value="Spagna" <?php echo ($user['nazione'] == 'Spagna') ? 'selected' : ''; ?>>Spagna</option>
                        <option value="Regno Unito" <?php echo ($user['nazione'] == 'Regno Unito') ? 'selected' : ''; ?>>Regno Unito</option>
                        <option value="Stati Uniti" <?php echo ($user['nazione'] == 'Stati Uniti') ? 'selected' : ''; ?>>Stati Uniti</option>
                        <option value="Altro" <?php echo (!in_array($user['nazione'], ['Italia', 'Francia', 'Germania', 'Spagna', 'Regno Unito', 'Stati Uniti'])) ? 'selected' : ''; ?>>Altro</option>
                    </select>
                    <input type="text" class="form-control mt-2 d-none" id="nazione_altro" name="nazione_altro" placeholder="Inserisci la tua nazione"
                            value="<?php echo (!in_array($user['nazione'], ['Italia', 'Francia', 'Germania', 'Spagna', 'Regno Unito', 'Stati Uniti'])) ? htmlspecialchars($user['nazione'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                            </div>

                            <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const selectNazione = document.getElementById("nazione");
                                const inputNazioneAltro = document.getElementById("nazione_altro");

                                function toggleCustomInput() {
                                    if (selectNazione.value === "Altro") {
                                        inputNazioneAltro.classList.remove("d-none");
                                        inputNazioneAltro.setAttribute("required", "required");
                                    } else {
                                        inputNazioneAltro.classList.add("d-none");
                                        inputNazioneAltro.removeAttribute("required");
                                        inputNazioneAltro.value = "";
                                    }
                                }

                                selectNazione.addEventListener("change", toggleCustomInput);
                                toggleCustomInput(); // Controlla al caricamento della pagina
                            });
                            </script>
            </div>
        </div>

        <!-- Sezione Sicurezza -->
        <div class="card shadow-sm p-4 mb-4">
            <h4><i class="fa fa-lock"></i> Sicurezza</h4>
            <div class="mb-3">
                <label for="password" class="form-label">Nuova Password (lascia vuoto per mantenere quella attuale)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>

        <!-- Pulsante di invio -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa fa-save"></i> Salva Modifiche
            </button>
        </div>
    </form>

    <br><br><br>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        let alerts = document.querySelectorAll(".alert");
        alerts.forEach(alert => {
            alert.classList.remove("show");
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Aggiunta di un'alert di conferma prima dell'invio del form
    document.getElementById("updateForm").addEventListener("submit", function(event) {
        event.preventDefault();
        Swal.fire({
            title: "Confermi l'aggiornamento?",
            text: "I tuoi dati verranno modificati!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sì, aggiorna",
            cancelButtonText: "Annulla"
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once 'cart_edit.php'; ?>
</html>