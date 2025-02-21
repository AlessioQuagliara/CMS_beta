<?php
session_start();
require ('../../app.php');
loggato();

require_once '../../config.php';
require_once '../../models/orders.php';
require_once '../../models/order_items.php';
require_once '../../models/user.php'; // Aggiunta del modello utente

$ordersModel = new OrdersModel($pdo);
$orderItemsModel = new OrderItemsModel($pdo);
$userModel = new UserModel($pdo); // Inizializza il modello utente

// Recupera l'ID dell'ordine dalla query string
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id === 0) {
    die("ID ordine non valido.");
}

// Recupera i dettagli dell'ordine
$order = $ordersModel->getOrderById($order_id);

// Recupera gli articoli associati all'ordine
$orderItems = $orderItemsModel->getItemsByOrderId($order_id);

// Recupera le informazioni dell'utente associato all'ordine
$user = $userModel->getUserById($order['user_id']);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettaglio Ordine #<?php echo $order_id; ?></title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    <?php 
    $sidebar_cate = 'App'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <br>
    <div class="card mb-4 shadow-lg border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">🛒 Dettaglio Ordine #<?php echo $order_id; ?></h5>
            <a href="ordini_righe" class="btn btn-light btn-sm">
                <i class="fa fa-arrow-left"></i> Torna alla Gestione Ordini
            </a>
        </div>
        <div class="card-body">
            <?php if ($order): ?>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-receipt"></i> Dettagli Ordine</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>ID Ordine:</strong></span> 
                                        <span class="badge bg-dark">#<?php echo $order['id']; ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>ID Utente:</strong></span> 
                                        <span class="badge bg-info"><?php echo $order['user_id']; ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Totale:</strong></span> 
                                        <span class="badge bg-success">€<?php echo number_format($order['total_price'], 2); ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Stato:</strong></span> 
                                        <span class="badge 
                                            <?php 
                                                switch ($order['status']) {
                                                    case 'pending': echo 'bg-warning text-dark'; break;
                                                    case 'paid': echo 'bg-info'; break;
                                                    case 'shipped': echo 'bg-primary'; break;
                                                    case 'completed': echo 'bg-success'; break;
                                                    case 'cancelled': echo 'bg-danger'; break;
                                                    default: echo 'bg-secondary';
                                                }
                                            ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Creato il:</strong></span> 
                                        <span><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card bg-light shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-user"></i> Informazioni Utente</h5>
                                <?php if ($user): ?>
                                    <p class="card-text">
                                        <strong>ID Utente:</strong> <?php echo $user['id_utente']; ?><br>
                                        <strong>Nome:</strong> <?php echo htmlspecialchars($user['nome'] . ' ' . $user['cognome']); ?><br>
                                        <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?><br>
                                        <strong>Telefono:</strong> <?php echo htmlspecialchars($user['telefono']); ?><br>
                                        <strong>Data Registrazione:</strong> <?php echo date('d/m/Y H:i', strtotime($user['data_registrazione'])); ?><br>
                                        <strong>Ultimo Accesso:</strong> <?php echo date('d/m/Y H:i', strtotime($user['ultimo_accesso'])); ?><br>
                                    </p>
                                <?php else: ?>
                                    <div class="alert alert-warning mb-0">
                                        <i class="fa fa-exclamation-triangle"></i> Utente non trovato.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3"><i class="fa fa-boxes"></i> Prodotti Associati</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Prodotto</th>
                                <th>Tipo Periodo</th>
                                <th>Valore Periodo</th>
                                <th>Slot</th>
                                <th>Spot</th>
                                <th>Prezzo</th>
                                <th>Data Aggiunta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><span class="badge bg-secondary">#<?php echo $item['product_id']; ?></span></td>
                                    <td><?php echo ucfirst($item['tipo_periodo']); ?></td>
                                    <td><?php echo $item['valore_periodo']; ?></td>
                                    <td><?php echo $item['slot']; ?></td>
                                    <td><?php echo $item['spot']; ?></td>
                                    <td><span class="badge bg-success">€<?php echo number_format($item['price'], 2); ?></span></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($item['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div class="alert alert-warning shadow-sm">
                    <i class="fa fa-exclamation-triangle"></i> Ordine non trovato.
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include '../materials/script.php'; ?>

</body>
</html>