<?php 
require ('../../app.php');
loggato();

if (!isset($_GET['id'])) {
    header("Location: aggiunta_prodotti.php");
    exit;
}

require_once '../../config.php';
require_once '../../models/prodotti_pubblicitari.php';

$id = intval($_GET['id']);
$model = new ProdottiPubblicitariModel($pdo);
$product = $model->getProductById($id);

if (!$product) {
    echo "Prodotto non trovato.";
    exit;
}

$errors = [];
$successMsg = "";

// Gestione della modifica in POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera e pulisci i dati inviati
    $nome               = trim($_POST['nome'] ?? '');
    $slug               = trim($_POST['slug'] ?? '');
    $description        = trim($_POST['description'] ?? '');
    $mezzo_pubblicitario= trim($_POST['mezzo_pubblicitario'] ?? '');
    $dimensione         = trim($_POST['dimensione'] ?? '');
    $concessionaria     = trim($_POST['concessionaria'] ?? '');
    $genere             = trim($_POST['genere'] ?? '');
    $eta                = trim($_POST['eta'] ?? '');

    // Puoi aggiungere ulteriori controlli di validazione qui

    $data = [
        'nome'                => $nome,
        'slug'                => $slug,
        'description'         => $description,
        'mezzo_pubblicitario' => $mezzo_pubblicitario,
        'dimensione'          => $dimensione,
        'concessionaria'      => $concessionaria,
        'genere'              => $genere,
        'eta'                 => $eta
    ];

    if ($model->updateProduct($id, $data)) {
        $successMsg = "Prodotto aggiornato con successo.";
        // Ricarica il prodotto aggiornato
        $product = $model->getProductById($id);
    } else {
        $errors[] = "Errore durante l'aggiornamento del prodotto.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Prodotto - LinkBay CMS</title>
    <?php include '../materials/head_content.php'; ?>
    <!-- Bootstrap Icons (se necessario) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body style="background-color: #f1f1f1;">
    
    <?php 
    $sidebar_cate = 'App'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h1 class="mt-4">Modifica Prodotto</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($successMsg): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($successMsg); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="modifica_prodotto.php?id=<?php echo $id; ?>">
        <!-- Row 1: Nome e Slug in linea -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       value="<?php echo htmlspecialchars($product['nome']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" 
                       value="<?php echo htmlspecialchars($product['slug']); ?>" required>
            </div>
        </div>

        <!-- Row 2: Descrizione a tutta larghezza -->
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <!-- Row 3: Mezzo Pubblicitario, Dimensione, Concessionaria -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="mezzo_pubblicitario" class="form-label">Mezzo Pubblicitario</label>
                <select class="form-select" id="mezzo_pubblicitario" name="mezzo_pubblicitario" required>
                    <?php 
                    $mezzi = ['Tv','Radio','Quotidiani','Periodici','Digital','OOH'];
                    foreach ($mezzi as $m): ?>
                        <option value="<?php echo $m; ?>" <?php if($product['mezzo_pubblicitario'] == $m) echo 'selected'; ?>>
                            <?php echo $m; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="dimensione" class="form-label">Dimensione</label>
                <select class="form-select" id="dimensione" name="dimensione" required>
                    <?php 
                    $dimensioni = ['Locale','Regionale','Nazionale'];
                    foreach ($dimensioni as $d): ?>
                        <option value="<?php echo $d; ?>" <?php if($product['dimensione'] == $d) echo 'selected'; ?>>
                            <?php echo $d; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="concessionaria" class="form-label">Concessionaria</label>
                <select class="form-select" id="concessionaria" name="concessionaria" required>
                    <?php 
                    $concessionarie = ['Sipra','Publitalia 80','Mediamond','Manzoni','Piemme','Speed','CairoRCS','Pubbliesse','IGPDecaux','Digitalia 08','RDS adv','Open Space','Wayap','Carminati','Salina','Publiadige'];
                    foreach ($concessionarie as $c): ?>
                        <option value="<?php echo $c; ?>" <?php if($product['concessionaria'] == $c) echo 'selected'; ?>>
                            <?php echo $c; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Row 4: Genere e Età in linea -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="genere" class="form-label">Genere</label>
                <select class="form-select" id="genere" name="genere" required>
                    <?php 
                    $generi = ['Uomini','Donne','Entrambi'];
                    foreach ($generi as $g): ?>
                        <option value="<?php echo $g; ?>" <?php if($product['genere'] == $g) echo 'selected'; ?>>
                            <?php echo $g; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="eta" class="form-label">Età</label>
                <select class="form-select" id="eta" name="eta" required>
                    <?php 
                    $eta_options = ['Meno di 30 anni','Tra i 30 ed i 50 anni','Oltre i 50 anni'];
                    foreach ($eta_options as $e): ?>
                        <option value="<?php echo $e; ?>" <?php if($product['eta'] == $e) echo 'selected'; ?>>
                            <?php echo $e; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Salva Modifiche</button>
        <a href="aggiunta_prodotti.php" class="btn btn-secondary">Indietro</a>
    </form>
</main>
    
    <?php include '../materials/script.php'; ?>
</body>
</html>