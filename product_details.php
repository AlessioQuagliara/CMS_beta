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

    // Aggiunta al carrello (gestito in sessione)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
        $product_id = $product['id'];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!in_array($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $product_id;
        }

        header("Location: cart.php");
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
    <div class="card shadow-lg">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="src/media_system/placeholder.jpg" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($product['nome']); ?>">
            </div>
            <div class="col-md-6 d-flex flex-column">
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($product['nome']); ?></h3>
                    <p class="text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Mezzo Pubblicitario:</strong> <?php echo htmlspecialchars($product['mezzo_pubblicitario']); ?></li>
                        <li class="list-group-item"><strong>Genere:</strong> <?php echo htmlspecialchars($product['genere']); ?></li>
                        <li class="list-group-item"><strong>Età Target:</strong> <?php echo htmlspecialchars($product['eta']); ?></li>
                        <li class="list-group-item"><strong>Concessionaria:</strong> <?php echo htmlspecialchars($product['concessionaria']); ?></li>
                        <li class="list-group-item"><strong>Tipo Periodo:</strong> <?php echo htmlspecialchars($product['tipo_periodo']); ?></li>
                    </ul>

                    <form method="POST">
                        <button type="submit" name="add_to_cart" class="btn btn-primary mt-3 w-100">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>