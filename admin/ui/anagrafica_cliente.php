<?php
session_start();
require('../../app.php');
loggato();

require_once '../../config.php';
require_once '../../models/user.php';

$userModel = new UserModel($pdo);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID Cliente non valido.');
}

$cliente = $userModel->getUserById($_GET['id']);

if (!$cliente) {
    die('Cliente non trovato.');
}

// Formatta la data di registrazione senza orario (es. "1 Marzo 2025")
$dateFormatter = new IntlDateFormatter(
    'it_IT',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE
);
$dataRegistrazione = $dateFormatter->format(new DateTime($cliente['data_registrazione']));
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anagrafica Cliente</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<?php 
$sidebar_cate = 'clienti'; 
$currentPage = basename($_SERVER['PHP_SELF']);
include '../materials/sidebar.php'; 
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <br>
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa fa-user"></i> Anagrafica Cliente</h5>
            <button class="btn btn-light btn-sm" onclick="window.history.back();">
                <i class="fa fa-arrow-left"></i> Indietro
            </button>
        </div>
        <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>ID Cliente:</strong> #<?php echo $cliente['id_utente']; ?></li>
                    <li class="list-group-item"><strong>Nome:</strong> <?php echo htmlspecialchars($cliente['nome'] . ' ' . $cliente['cognome']); ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($cliente['email']); ?></li>
                    <li class="list-group-item"><strong>Telefono:</strong> <?php echo htmlspecialchars($cliente['telefono']); ?></li>
                    <li class="list-group-item"><strong>Codice Fiscale:</strong> <?php echo htmlspecialchars($cliente['codice_fiscale'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Partita IVA:</strong> <?php echo htmlspecialchars($cliente['partita_iva'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Ragione Sociale:</strong> <?php echo htmlspecialchars($cliente['ragione_sociale'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Indirizzo:</strong> <?php echo htmlspecialchars($cliente['indirizzo'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>CAP:</strong> <?php echo htmlspecialchars($cliente['cap'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Città:</strong> <?php echo htmlspecialchars($cliente['citta'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Provincia:</strong> <?php echo htmlspecialchars($cliente['provincia'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Nazione:</strong> <?php echo htmlspecialchars($cliente['nazione'] ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Data Registrazione:</strong> <?php echo $dataRegistrazione; ?></li>
                </ul>
            </div>
    </div>
</main>

<?php include '../materials/script.php'; ?>

</body>
</html>