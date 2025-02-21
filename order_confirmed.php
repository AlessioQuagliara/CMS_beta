<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'app.php';
require_once 'conn.php';
require_once 'config.php';
require_once 'models/orders.php';
require_once 'models/order_items.php';

if (!isset($_GET['order_id'])) {
    echo "ID dell'ordine non fornito.";
    exit();
}

$order_id = intval($_GET['order_id']);

try {
    $ordersModel = new OrdersModel($pdo);

    $order = $ordersModel->getOrderById($order_id);

    if (!$order) {
        echo "Ordine non trovato.";
        exit();
    }

} catch (Exception $e) {
    echo "Errore durante il recupero dell'ordine: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ordine Confermato</title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
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
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Ordine Confermato!</h3>
            <p>Il tuo ordine è stato inviato con successo. Qui sotto trovi i dettagli per il pagamento.</p>

            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>ID Ordine:</strong> <?php echo htmlspecialchars($order['id']); ?></li>
                <li class="list-group-item"><strong>Totale:</strong> €<?php echo htmlspecialchars($order['total_price']); ?></li>
                <li class="list-group-item"><strong>Stato:</strong> <?php echo htmlspecialchars($order['status']); ?></li>
                <li class="list-group-item"><strong>Data:</strong> <?php echo htmlspecialchars($order['created_at']); ?></li>
            </ul>

            <h5>Dettagli per il pagamento:</h5>
            <p>Effettua il pagamento tramite bonifico bancario utilizzando i seguenti dati:</p>
            <p>
                <strong>Intestatario:</strong> Spotex SRL<br>
                <strong>IBAN:</strong> IT60X0542811101000000123456<br>
                <strong>Causale:</strong> Ordine #<?php echo htmlspecialchars($order['id']); ?>
            </p>

            <a href="products.php" class="btn btn-primary">Torna ai prodotti</a>
            <a href="dashboard.php" class="btn btn-dark">Vai alla dashboard</a>
        </div>
    </div>
</div>

<br><br><br><br><br><br>

<?php
    if (function_exists('customFooter')) {
        customFooter();
    } else {
        echo "<p>Errore: funzione customFooter non definita.</p>";
    }

    include('public/cookie_banner.php');
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>