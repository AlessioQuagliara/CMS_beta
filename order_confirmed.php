<?php
session_start();
require_once 'conn.php';
require_once 'models/OrdersModel.php';

if (!isset($_GET['order_id'])) {
    echo "ID dell'ordine non fornito.";
    exit();
}

$order_id = intval($_GET['order_id']);

try {
    $pdo = new PDO($dsn, $username, $password, $options);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>