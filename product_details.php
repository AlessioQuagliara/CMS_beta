<?php
session_start();
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
} else {
    require_once 'app.php';
    require 'visita.php';
    require 'conn.php';

    // Controllo dello slug del prodotto
    $slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8') : '';

    if (empty($slug)) {
        header("Location: products.php");
        exit();
    }

    // Verifica se l'utente è loggato
    $userPlaceholder = 'ospite';
    if (isset($_SESSION['user'])) {
        $userPlaceholder = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');
    }

    // Recupero dati del prodotto
    $stmt = $conn->prepare("SELECT * FROM prodotti_pubblicitari WHERE slug = ?");
    if ($stmt) {
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            header("Location: products.php");
            exit();
        }
    } else {
        header("Location: error.php");
        exit();
    }

    // Recupero l'immagine del prodotto
    $stmt_img = $conn->prepare("SELECT image_url FROM product_images WHERE product_id = ? LIMIT 1");
    $stmt_img->bind_param('i', $product['id']);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    $image = $result_img->fetch_assoc();
    $product_image = $image ? $image['image_url'] : 'src/media_system/placeholder.jpg';

    // Recupero i periodi associati
    $stmt_periodi = $conn->prepare("SELECT * FROM prodotti_periodi WHERE prodotto_id = ?");
    $stmt_periodi->bind_param('i', $product['id']);
    $stmt_periodi->execute();
    $result_periodi = $stmt_periodi->get_result();
    $periodi = $result_periodi->fetch_all(MYSQLI_ASSOC);

    // Recupero gli slot associati
    $stmt_slot = $conn->prepare("SELECT * FROM prodotti_slot WHERE prodotto_id = ?");
    $stmt_slot->bind_param('i', $product['id']);
    $stmt_slot->execute();
    $result_slot = $stmt_slot->get_result();
    $slots = $result_slot->fetch_all(MYSQLI_ASSOC);

    // Recupero gli spot associati
    $stmt_spot = $conn->prepare("SELECT * FROM prodotti_spot WHERE prodotto_id = ?");
    $stmt_spot->bind_param('i', $product['id']);
    $stmt_spot->execute();
    $result_spot = $stmt_spot->get_result();
    $spots = $result_spot->fetch_all(MYSQLI_ASSOC);

    // Aggiunta al carrello
    require_once 'cart_session.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'] ?? null;
        $product_name = $_POST['product_name'] ?? '';
        $product_price = $_POST['product_price'] ?? 0;
        $product_image = $_POST['product_image'] ?? 'src/media_system/placeholder.jpg';
    
        $tipo_periodo = $_POST['tipo_periodo'] ?? null;
        $slot = $_POST['slot'] ?? null;
        $spot = $_POST['spot'] ?? null;
    
        // Controllo se tutti i parametri sono stati selezionati
        if (!$product_id || !$tipo_periodo || !$slot || !$spot) {
            echo json_encode(['success' => false, 'message' => 'Seleziona tutte le opzioni richieste prima di aggiungere al carrello.']);
            exit();
        }
    
        // Aggiungiamo il prodotto al carrello
        addToCart($product_id, $product_name, $product_price, $product_image, $tipo_periodo, $slot, $spot);
    
        echo json_encode(['success' => true, 'message' => 'Prodotto aggiunto al carrello']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['nome']); ?> - Dettaglio</title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>

<?php
    if (function_exists('customNav')) {
        customNav();
    } else {
        echo "<p>Errore: funzione customNav non definita.</p>";
    }
?>

<br><br>

<div class="container mt-5">
    <div class="row">
        <!-- Card 1: Dettagli del prodotto -->
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($product['nome']); ?></h3>
                    <img src="../../<?php echo htmlspecialchars($product_image); ?>"  width="40%" alt="<?php echo htmlspecialchars($product['nome']); ?>">
                    <p class="text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Mezzo Pubblicitario:</strong> <?php echo htmlspecialchars($product['mezzo_pubblicitario']); ?></li>
                        <li class="list-group-item"><strong>Genere:</strong> <?php echo htmlspecialchars($product['genere']); ?></li>
                        <li class="list-group-item"><strong>Età Target:</strong> <?php echo htmlspecialchars($product['eta']); ?></li>
                        <li class="list-group-item"><strong>Concessionaria:</strong> <?php echo htmlspecialchars($product['concessionaria']); ?></li>
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['nome']); ?>">
                        <input type="hidden" id="product_price" name="product_price" value="">
                        <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product_image); ?>">
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card 2: Selezione opzioni e aggiunta al carrello -->
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h4 class="card-title text-center mb-3">Configura il tuo acquisto</h4>

                    <form id="add-to-cart-form" method="POST">

                        <!-- Selezione Slot Disponibile -->
                        <h5>Seleziona uno slot</h5>
                        <div class="list-group mb-3">
                                <select name="slot" class="form-select" required>
                                    <option value="">Seleziona uno slot</option>
                                    <?php foreach ($slots as $slot): ?>
                                        <option value="<?php echo htmlspecialchars($slot['slot']); ?>" data-price="<?php echo htmlspecialchars($slot['valore_slot']); ?>">
                                            <?php echo htmlspecialchars($slot['slot']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                        </div>

                        <!-- Selezione Spot Disponibile -->
                        <h5>Seleziona uno spot</h5>
                        <div class="list-group mb-3">
                            <select name="spot" class="form-select mb-3" required>
                                <option value="">Seleziona uno spot</option>
                                <?php foreach ($spots as $spot): ?>
                                    <option value="<?php echo htmlspecialchars($spot['spot']); ?>" data-price="<?php echo htmlspecialchars($spot['valore_spot']); ?>">
                                        <?php echo htmlspecialchars($spot['spot']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <!-- Selezione Tipo di Periodo -->
                        <div class="mb-3">
                            <h5>Seleziona il periodo</h5>
                            <select name="tipo_periodo" id="tipo_periodo" class="form-select" required>
                                <option value="" data-price="">Seleziona un periodo</option>
                                <?php foreach ($periodi as $periodo): ?>
                                    <?php 
                                        // Imposta la localizzazione in italiano se non già fatto
                                        setlocale(LC_TIME, 'it_IT.UTF-8');
                                        // Converte la data da "A/M/D" a formato esteso (es. "lunedì 01 gennaio 2020")
                                        $timestamp = strtotime($periodo['tipo_periodo']);
                                        $dataEstesa = $timestamp ? strftime("%A %d %B %Y", $timestamp) : htmlspecialchars($periodo['tipo_periodo']);
                                    ?>
                                    <option value="<?php echo htmlspecialchars($periodo['tipo_periodo']); ?>" data-price="<?php echo htmlspecialchars($periodo['valore_periodo']); ?>">
                                        <?php echo ucfirst($dataEstesa); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Pulsante Aggiungi al Carrello -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-cart-plus"></i> Aggiungi al Carrello
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br>

<?php
    if (function_exists('customFooter')) {
        customFooter();
    } else {
        echo "<p>Errore: funzione customFooter non definita.</p>";
    }

    include('public/cookie_banner.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="script/cart_controller.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginSystem = document.getElementById('loginSystem');

        // Supponiamo che lo stato di autenticazione sia memorizzato in un cookie o in localStorage
        const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;

        if (isLoggedIn) {
            loginSystem.innerHTML = '<a href="/dashboard.php" class="nav-link text-secondary">Dashboard</a>';
        } else {
            loginSystem.innerHTML = '<a href="/login" class="nav-link text-secondary">Login</a>';
        }
    });
</script>
</body>
</html>