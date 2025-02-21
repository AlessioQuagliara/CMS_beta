<?php
session_start();
require ('../../app.php');
loggato();

require_once '../../config.php';
require_once '../../models/orders.php';
require_once '../../models/order_items.php';

$ordersModel = new OrdersModel($pdo);
$orderItemsModel = new OrderItemsModel($pdo);

// Recupera tutti gli ordini per l'area admin
$orders = $ordersModel->getAllOrders();

$errors = [];
$successMsg = "";

// Gestione aggiornamento stato ordine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = trim($_POST['status']);
    
    if ($ordersModel->updateOrderStatus($order_id, $new_status)) {
        $successMsg = "Stato dell'ordine aggiornato con successo.";
        $orders = $ordersModel->getAllOrders(); // Aggiorna gli ordini
    } else {
        $errors[] = "Errore durante l'aggiornamento dello stato dell'ordine.";
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Ordini - Admin</title>
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
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📦 Gestione Ordini</h5>
            <button class="btn btn-light btn-sm" onclick="location.reload();">
                <i class="fa fa-sync-alt"></i> Aggiorna
            </button>
        </div>
        <div class="card-body">
            <?php if ($successMsg): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle"></i> <?php echo $successMsg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($errors): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle"></i> 
                    <?php foreach ($errors as $error) echo $error . '<br>'; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Ordine</th>
                            <th>ID Utente</th>
                            <th>Totale</th>
                            <th>Stato</th>
                            <th>Creato il</th>
                            <th class="text-center">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td onclick="window.location.href='visualizza_ordine.php?order_id=<?php echo $order['id']; ?>';" style="cursor: pointer;"><strong>#<?php echo $order['id']; ?></strong></td>
                                <td onclick="window.location.href='visualizza_ordine.php?order_id=<?php echo $order['id']; ?>';" style="cursor: pointer;"><?php echo $order['user_id']; ?></td>
                                <td onclick="window.location.href='visualizza_ordine.php?order_id=<?php echo $order['id']; ?>';" style="cursor: pointer;"><span class="badge bg-success">€<?php echo number_format($order['total_price'], 2); ?></span></td>
                                <td onclick="window.location.href='visualizza_ordine.php?order_id=<?php echo $order['id']; ?>';" style="cursor: pointer;">
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
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td class="text-center">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <div class="input-group input-group-sm mb-2">
                                            <select name="status" class="form-select form-select-sm">
                                                <?php 
                                                $statuses = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
                                                foreach ($statuses as $status): ?>
                                                    <option value="<?php echo $status; ?>" 
                                                        <?php if ($order['status'] === $status) echo 'selected'; ?>>
                                                        <?php echo ucfirst($status); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" name="update_status" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../materials/script.php'; ?>

</body>
</html>
