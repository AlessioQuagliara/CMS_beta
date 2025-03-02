<?php 
require ('../../app.php');
loggato();

// Importa i modelli necessari
require_once '../../config.php';
require_once '../../models/orders.php';
require_once '../../models/ChatManager.php';

// Inizializza i modelli
$ordersModel = new OrdersModel($pdo);
$chatManager = new ChatManager($pdo);

// Recupera gli ordini dell'utente loggato
$Orders = $ordersModel->getAllOrders();

// Recupera i messaggi non letti
$messaggiNonLetti = $chatManager->contaMessaggiNonLettiUtente($_SESSION['user']['nome']);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - HomePage</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <br><br>
        <!-- STATISTICHE RAPIDE -->
        <div class="p-3 mb-2 bg-light rounded-3 border">

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-visite-tab" data-bs-toggle="tab" data-bs-target="#nav-visite" type="button" role="tab" aria-controls="nav-visite" aria-selected="true">
                        Visite
                    </button>
                    <button class="nav-link" id="nav-clienti-tab" data-bs-toggle="tab" data-bs-target="#nav-clienti" type="button" role="tab" aria-controls="nav-clienti" aria-selected="false">
                        Clienti
                    </button>
                    <button class="nav-link" id="nav-ordini-tab" data-bs-toggle="tab" data-bs-target="#nav-ordini" type="button" role="tab" aria-controls="nav-ordini" aria-selected="false">
                        Ordini
                    </button>
                    <button class="nav-link position-relative" id="nav-messaggi-tab" data-bs-toggle="tab" data-bs-target="#nav-messaggi" type="button" role="tab" aria-controls="nav-messaggi" aria-selected="false">
                        Messaggi 
                        <?php if ($messaggiNonLetti > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo $messaggiNonLetti; ?>
                            </span>
                        <?php endif; ?>
                    </button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <!-- TAB PER LE VISITE -->
                <div class="tab-pane fade active show" id="nav-visite" role="tabpanel" aria-labelledby="nav-visite-tab" tabindex="0">
                    <?php echo visite(); ?>
                </div>

                <!-- TAB PER I CLIENTI -->
                <div class="tab-pane fade" id="nav-clienti" role="tabpanel" aria-labelledby="nav-clienti-tab" tabindex="0">
                    <?php echo visualizzaClientiELeads(); ?>
                </div>

                <!-- TAB PER GLI ORDINI -->
                <div class="tab-pane fade" id="nav-ordini" role="tabpanel" aria-labelledby="nav-ordini-tab" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Ordine</th>
                                    <th>Utente</th>
                                    <th>Totale</th>
                                    <th>Stato</th>
                                    <th>Data</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($Orders)): ?>
                                    <?php foreach ($Orders as $order): ?>
                                        <tr>
                                            <td>#<?php echo $order['id']; ?></td>
                                            <td>
                                                <i class="fa fa-user-circle"></i> <?php echo htmlspecialchars($order['user_id']); ?>
                                            </td>
                                            <td>€<?php echo number_format($order['total_price'], 2); ?></td>
                                            <td>
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
                                                    <i class="fa 
                                                        <?php 
                                                            switch ($order['status']) {
                                                                case 'pending': echo 'fa-hourglass-half'; break;
                                                                case 'paid': echo 'fa-check-circle'; break;
                                                                case 'shipped': echo 'fa-truck'; break;
                                                                case 'completed': echo 'fa-check-double'; break;
                                                                case 'cancelled': echo 'fa-times-circle'; break;
                                                                default: echo 'fa-info-circle';
                                                            }
                                                        ?>"></i> 
                                                    <?php 
                                                        $stati_tradotti = [
                                                            'pending'   => 'In Attesa',
                                                            'paid'      => 'Pagato',
                                                            'shipped'   => 'Spedito',
                                                            'completed' => 'Completato',
                                                            'cancelled' => 'Annullato'
                                                        ];
                                                        echo $stati_tradotti[$order['status']] ?? ucfirst($order['status']); 
                                                    ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                            <td>
                                                <a href="visualizza_ordine.php?order_id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye"></i> Dettagli
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nessun ordine trovato.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB PER I MESSAGGI -->
                <div class="tab-pane fade" id="nav-messaggi" role="tabpanel" aria-labelledby="nav-messaggi-tab" tabindex="0">
                    <div class="list-group">
                        <?php 
                        $messaggi = $chatManager->getMessaggiPerUtente($_SESSION['user']['nome']);
                        if (!empty($messaggi)):
                            foreach ($messaggi as $msg):
                        ?>
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <strong><?php echo htmlspecialchars($msg['sender_name']); ?>:</strong>
                                    <p class="mb-1"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                                    <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($msg['created_at'])); ?></small>
                                </div>
                                <span class="badge bg-<?php echo $msg['is_read'] ? 'secondary' : 'primary'; ?>">
                                    <?php echo $msg['is_read'] ? 'Letto' : 'Nuovo'; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center text-muted">Nessun messaggio ricevuto.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="p-3 mb-2 bg-light rounded-3 border">
            <?php echo dettagli_negozio(); ?>
        </div>

    </main>

<?php include '../materials/script.php'; ?>
</body>
</html>