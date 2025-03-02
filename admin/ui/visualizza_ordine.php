<?php
session_start();
require ('../../app.php');
loggato();

require_once '../../config.php';
require_once '../../models/orders.php';
require_once '../../models/order_items.php';
require_once '../../models/user.php'; // Aggiunta del modello utente
require '../../models/prodotti_pubblicitari.php';

$ordersModel = new OrdersModel($pdo);
$orderItemsModel = new OrderItemsModel($pdo);
$userModel = new UserModel($pdo); // Inizializza il modello utente
$productModel = new ProdottiPubblicitariModel($pdo);

if (!isset($_GET['order_id']) || !ctype_digit($_GET['order_id'])) {
    die("❌ Errore: ID ordine non valido.");
}

$order_id = intval($_GET['order_id']); // Converti l'ID in intero per sicurezza

// Recupera i dettagli dell'ordine
$order = $ordersModel->getOrderById($order_id);

// Recupera gli articoli associati all'ordine
$orderItems = $orderItemsModel->getItemsByOrderId($order_id);

// Recupera il nome prodotto dal product_id dell'ordine items
foreach ($orderItems as $key => $item) {
    $product = $productModel->getProductById($item['product_id']);
    $orderItems[$key]['product_name'] = $product['nome'];
}

// Recupera le informazioni dell'utente associato all'ordine
$user = $userModel->getUserById($order['user_id']);
?>
<?php
    // Percorso delle cartelle dei media associati all'ordine
    $orderMediaPath = '../../uploads/content/' . $order_id;
    $imageFolder = $orderMediaPath . '/immagini';
    $videoFolder = $orderMediaPath . '/video';

    // Funzione per contare i file in una cartella
    function countFilesInFolder($folderPath) {
        if (file_exists($folderPath)) {
            $files = glob($folderPath . '/*.*');
            return count($files);
        }
        return 0;
    }

    // Conta il numero di file nelle cartelle immagini e video
    $imageFileCount = countFilesInFolder($imageFolder);
    $videoFileCount = countFilesInFolder($videoFolder);

    // Link per scaricare i media come ZIP
    $downloadLink = "download_media.php?order_id=" . $order_id;
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
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <strong>Nome:</strong><br>
                                            <?php echo htmlspecialchars($user['nome'] . ' ' . $user['cognome']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Email:</strong><br>
                                            <?php echo htmlspecialchars($user['email']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Telefono:</strong><br>
                                            <?php echo htmlspecialchars($user['telefono']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Codice Fiscale:</strong><br>
                                            <?php echo htmlspecialchars($user['codice_fiscale']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Partita IVA:</strong><br>
                                            <?php echo htmlspecialchars($user['partita_iva']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Ragione Sociale:</strong><br>
                                            <?php echo htmlspecialchars($user['ragione_sociale']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Indirizzo:</strong><br>
                                            <?php echo htmlspecialchars($user['indirizzo']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>CAP:</strong><br>
                                            <?php echo htmlspecialchars($user['cap']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Città:</strong><br>
                                            <?php echo htmlspecialchars($user['citta']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Provincia:</strong><br>
                                            <?php echo htmlspecialchars($user['provincia']); ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Nazione:</strong><br>
                                            <?php echo htmlspecialchars($user['nazione']); ?>
                                        </div>
                                    </div>
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
                                <th>Prodotto</th>
                                <th>Giorno</th>
                                <th>Slot</th>
                                <th>Spot</th>
                                <th>Prezzo</th>
                                <th>Data Aggiunta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?php echo $item['product_name']; ?></td>
                                    <td><?php echo ucfirst($item['tipo_periodo']); ?></td>
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

        <div class="col-md-6">
            <div class="card bg-light shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-folder"></i> Media Associati all'Ordine</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Numero di Immagini:</strong></span> 
                            <span class="badge bg-info"><?php echo $imageFileCount; ?> file</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Numero di Video:</strong></span> 
                            <span class="badge bg-info"><?php echo $videoFileCount; ?> file</span>
                        </li>
                    </ul>
                    <div class="text-end mt-3">
                        <a href="<?php echo $downloadLink; ?>" class="btn btn-sm btn-primary">
                            <i class="fa fa-download"></i> Scarica Media
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <?php if ($order && $order['status'] === 'completed'): ?>
            <div class="card mb-4 shadow-lg border-0">
                <div class="card-body">
                    <h5><i class="fa fa-upload"></i> Carica il Report della Campagna</h5>
                    <p>Puoi caricare un file <strong>PDF</strong> o un'immagine <strong>PNG</strong> per questo ordine.</p>

                    <!-- Form per l'upload -->
                    <form id="upload-form" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        
                        <div class="mb-3">
                            <input type="file" class="form-control" id="report_file" name="report_file" accept=".pdf, .png" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-upload"></i> Carica Report
                        </button>
                    </form>

                    <!-- Area di visualizzazione file -->
                    <div class="mt-3" id="report-preview">
                        <?php
                        $reportPDF = "../../uploads/reports/{$order_id}/report.pdf";
                        $reportImage = "../../uploads/reports/{$order_id}/report.png";

                        if (file_exists($reportPDF)) {
                            echo '<object data="' . $reportPDF . '" type="application/pdf" width="100%" height="500px">
                                    <p>Il tuo browser non supporta la visualizzazione dei PDF. <a href="' . $reportPDF . '" target="_blank">Clicca qui per visualizzarlo.</a></p>
                                </object>';
                        } elseif (file_exists($reportImage)) {
                            echo '<img src="' . $reportImage . '" class="img-fluid" width="10%" alt="Report della Campagna">';
                        } else {
                            echo '<div class="alert alert-warning">
                                    <i class="fa fa-exclamation-circle"></i> Nessun report caricato.
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const uploadForm = document.getElementById("upload-form");

    if (uploadForm) {
        uploadForm.addEventListener("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(uploadForm);
            let fileInput = document.getElementById("report_file");

            if (!fileInput.files.length) {
                alert("Seleziona un file da caricare.");
                return;
            }

            fetch("upload_report.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Ricarica la pagina per mostrare il file caricato
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Errore:", error);
                alert("Errore nel caricamento del file.");
            });
        });
    }
});
</script>

<?php include '../materials/script.php'; ?>

</body>
</html>