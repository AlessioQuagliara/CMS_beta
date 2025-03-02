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

// Recupera le informazioni dell'utente loggato
$userId = intval($_SESSION['user']['id_utente']); // Ora prende l'ID corretto
$userName = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');

// Recupera gli ordini dell'utente
$ordersModel = new OrdersModel($pdo);
$userOrders = $ordersModel->getOrdersByUserId($userId);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['user']['id'])) {
    $userModel = new UserModel($pdo);
    $_SESSION['user'] = $userModel->getUserById($_SESSION['user']['id']);
}
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

<?php
$required_fields = ['codice_fiscale', 'partita_iva', 'ragione_sociale', 'indirizzo', 'cap', 'citta', 'provincia', 'nazione'];
$missingData = false;

foreach ($required_fields as $field) {
    if (empty($_SESSION['user'][$field])) {
        $missingData = true;
        break;
    }
}

if ($missingData): ?>
<div class="container mt-4">
    <br><br><br>
    <div class="card text-white bg-warning mb-3">
        <div class="card-header">Dati Profilo Incompleti</div>
        <div class="card-body">
            <p class="card-text">Hai dei dati mancanti nel tuo profilo. Completa le informazioni nelle impostazioni.</p>
            <a href="impostazioni.php" class="btn btn-primary">Vai alle impostazioni</a>
        </div>
    </div>
</div>
<?php endif; ?>

    <!-- Contenuto della pagina -->
    <div class="container mt-4">

        <h1 class="mt-4" style="color: #003f88;">I miei ordini</h1>

        <?php if (!empty($userOrders)): ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Ordine</th>
                            <th>Totale</th>
                            <th>Stato</th>
                            <th>Creato il</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userOrders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><span class="badge bg-success">€<?php echo number_format($order['total_price'], 2); ?></span></td>
                                <td>
                                    <?php 
                                        // Classi badge in base allo status
                                        switch ($order['status']) {
                                            case 'pending': $badgeClass = 'bg-warning text-dark'; break;
                                            case 'paid': $badgeClass = 'bg-info'; break;
                                            case 'shipped': $badgeClass = 'bg-primary'; break;
                                            case 'completed': $badgeClass = 'bg-success'; break;
                                            case 'cancelled': $badgeClass = 'bg-danger'; break;
                                            default: $badgeClass = 'bg-secondary';
                                        }
                                        // Traduzioni front-end
                                        $statusTranslations = [
                                            'pending' => 'In attesa',
                                            'paid' => 'Pagato',
                                            'shipped' => 'In Corso',
                                            'completed' => 'Completato',
                                            'cancelled' => 'Annullato'
                                        ];
                                        $translatedStatus = isset($statusTranslations[$order['status']]) ? $statusTranslations[$order['status']] : ucfirst($order['status']);
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo $translatedStatus; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                        setlocale(LC_TIME, 'it_IT.UTF-8');
                                        echo strftime('%A %d %B %Y', strtotime($order['created_at']));
                                    ?>
                                </td>
                                <td>
                                    <a href="visualizza_ordine.php?order_id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-eye"></i> Dettagli
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-4">
                <i class="fa fa-exclamation-circle"></i> Non hai ancora effettuato ordini.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php require_once 'cart_edit.php'; ?>
</body>
</html>