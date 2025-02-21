<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'app.php';
require_once 'config.php';
require_once 'models/orders.php';
require_once 'models/order_items.php';

if (!isset($_SESSION['user'])) {
    header('Location: Login');
    exit();
}

// Recupera i modelli
$ordersModel = new OrdersModel($pdo);
$orderItemsModel = new OrderItemsModel($pdo);

// Recupera l'ID dell'ordine dalla query string
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id === 0) {
    die("ID ordine non valido.");
}

// Recupera i dettagli dell'ordine e gli articoli associati
$order = $ordersModel->getOrderById($order_id);
$orderItems = $orderItemsModel->getItemsByOrderId($order_id);

// Controlla se l'ordine è nello stato 'completed'
$isCompleted = $order && $order['status'] === 'completed' || $order && $order['status'] === 'paid';

// Percorso di caricamento media
$uploadDir = "uploads/content/$order_id";

// Crea automaticamente le cartelle se non esistono
if (!file_exists($uploadDir)) {
    mkdir("$uploadDir/immagini", 0777, true);
    mkdir("$uploadDir/video", 0777, true);
}

// Gestione del caricamento dei media
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isCompleted) {
    $response = ['success' => false, 'message' => 'Errore durante il caricamento.'];

    if (!empty($_FILES['media']['name'])) {
        $fileName = basename($_FILES['media']['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            $targetFile = "$uploadDir/immagini/$fileName";
        } elseif ($fileType === 'mp4') {
            $targetFile = "$uploadDir/video/$fileName";
        } else {
            $response['message'] = 'Formato file non supportato.';
            echo json_encode($response);
            exit;
        }

        if (move_uploaded_file($_FILES['media']['tmp_name'], $targetFile)) {
            $response = ['success' => true, 'message' => 'File caricato con successo!'];
        } else {
            $response['message'] = 'Errore durante lo spostamento del file.';
        }
    } else {
        $response['message'] = 'Nessun file selezionato.';
    }

    echo json_encode($response);
    exit;
}
?>
<?php
// Conta i file nelle cartelle immagini e video
$imageFiles = glob("$uploadDir/immagini/*.{jpg,jpeg,png}", GLOB_BRACE);
$videoFiles = glob("$uploadDir/video/*.mp4");

// Conta i file trovati
$imageCount = count($imageFiles);
$videoCount = count($videoFiles);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettaglio Ordine #<?php echo $order_id; ?></title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <a class="nav-link text-white" href="chat.php">
            <i class="fa fa-comments"></i> <br>Chat
        </a>
        <a class="nav-link text-white" href="eventi.php">
            <i class="fa fa-calendar-alt"></i> <br>Eventi
        </a>
        <a class="nav-link text-white" href="logout.php">
            <i class="fa fa-sign-out-alt"></i> <br>Logout
        </a>
    </div>
</nav>

<br><br><br><br>

<div class="container mt-4">
    <h1 class="mb-4" style="color: #003f88;">Dettaglio Ordine #<?php echo $order_id; ?></h1>

    <?php if ($order): ?>
        <div class="card mb-4 shadow-lg border-0">
            <div class="card-body">
                <h5><i class="fa fa-info-circle"></i> Informazioni Ordine</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID Ordine:</strong> #<?php echo $order['id']; ?></li>
                    <li class="list-group-item"><strong>Totale:</strong> €<?php echo number_format($order['total_price'], 2); ?></li>
                    <li class="list-group-item"><strong>Stato:</strong> <?php echo ucfirst($order['status']); ?></li>
                    <li class="list-group-item"><strong>Creato il:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></li>
                </ul>
            </div>
        </div>

        <?php if ($isCompleted): ?>
            <div class="card mb-4 shadow-lg border-0">
                <div class="card-body">
                    <h5><i class="fa fa-upload"></i> Carica Immagini e Video</h5>
                    <button class="btn btn-primary" onclick="showUploadModal()">
                        <i class="fa fa-cloud-upload-alt"></i> Carica Media
                    </button>
                </div>
            </div>

            <!-- Card per il contatore dei media caricati -->
            <div class="card mb-4 shadow-lg border-0">
                <div class="card-body">
                    <h5><i class="fa fa-folder"></i> Media Caricati</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-image"></i> Immagini Caricate:</span> 
                            <span class="badge bg-primary"><?php echo $imageCount; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-video"></i> Video Caricati:</span> 
                            <span class="badge bg-secondary"><?php echo $videoCount; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-circle"></i> Ordine non trovato.
        </div>
    <?php endif; ?>
</div>

<script>
function showUploadModal() {
    Swal.fire({
        title: 'Carica Immagini o Video',
        html: `<input type="file" id="mediaFile" class="form-control" accept=".jpg,.png,.mp4">`,
        showCancelButton: true,
        confirmButtonText: 'Carica',
        cancelButtonText: 'Annulla',
        preConfirm: () => {
            const fileInput = document.getElementById('mediaFile');
            if (!fileInput.files.length) {
                Swal.showValidationMessage('Seleziona un file prima di procedere.');
            }
            return fileInput.files[0];
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('media', result.value);

            fetch('visualizza_ordine.php?order_id=<?php echo $order_id; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? 'Caricamento Completato!' : 'Errore',
                    text: data.message
                });
            })
            .catch(error => {
                Swal.fire('Errore!', 'Si è verificato un problema durante il caricamento.', 'error');
            });
        }
    });
}
</script>
<?php require_once 'cart_edit.php'; ?>
</body>
</html>