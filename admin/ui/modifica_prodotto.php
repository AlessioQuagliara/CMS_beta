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
$imageModel = new ProductImagesModel($pdo);
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

// Recupero immagini esistenti
$images = $imageModel->getImagesByProductId($id);
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
    <br>
<!-- Card: Modifica Prodotto -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Modifica Prodotto</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="modifica_prodotto.php?id=<?php echo $id; ?>">
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

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

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

            <!-- Nuova riga per Genere ed Età -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="genere" class="form-label">Genere</label>
                    <select class="form-select" id="genere" name="genere" required>
                        <?php 
                        $generi = ['Uomini', 'Donne', 'Entrambi'];
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
                        $eta_options = ['Meno di 30 anni', 'Tra i 30 ed i 50 anni', 'Oltre i 50 anni'];
                        foreach ($eta_options as $e): ?>
                            <option value="<?php echo $e; ?>" <?php if($product['eta'] == $e) echo 'selected'; ?>>
                                <?php echo $e; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Salva Modifiche</button>
        </form>
    </div>
</div>



<!-- Card: Gestione Immagini -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Gestione Immagini</h5>
    </div>
    <div class="card-body">
        <form id="image-upload-form" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <input type="file" class="form-control" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Carica Immagine</button>
        </form>

        <!-- Galleria immagini -->
        <div class="row mt-4" id="image-gallery">
            <?php foreach ($images as $image): ?>
                <div class="col-md-3 text-center">
                    <img src="../../<?php echo $image['image_url']; ?>" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    <button class="btn btn-danger btn-sm mt-2 delete-image" data-id="<?php echo $image['id']; ?>">Elimina</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Card: Gestione Periodi -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Gestione Periodi</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Periodi associati</h5>
            <button class="btn btn-success btn-sm" id="add-periodo">
                <i class="bi bi-plus"></i> Aggiungi Periodo
            </button>
        </div>
        <ul class="list-group mt-3" id="periodo-list">
            <?php
            $periodoModel = new ProdottiPeriodiModel($pdo);
            $periodi = $periodoModel->getPeriodiByProductId($id);
            foreach ($periodi as $periodo):
                // Converte la data in un formato esteso in italiano usando IntlDateFormatter
                $dateObj = new DateTime($periodo['tipo_periodo']);
                $formatter = new IntlDateFormatter(
                    'it_IT',
                    IntlDateFormatter::LONG,
                    IntlDateFormatter::NONE,
                    'Europe/Rome',
                    IntlDateFormatter::GREGORIAN
                );
                $extendedDate = $formatter->format($dateObj);
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?php echo ucfirst($extendedDate) . " - " . htmlspecialchars($periodo['valore_periodo']); ?>€</span>
                <button class="btn btn-danger btn-sm delete-periodo" data-id="<?php echo $periodo['id']; ?>">
                    <i class="bi bi-trash"></i>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- Card: Gestione Spot -->
<div class="card mb-4">
    <div class="card-header bg-dark text-light">
        <h5 class="mb-0">Gestione Spot</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Spot associati</h5>
            <button class="btn btn-success btn-sm" id="add-spot">
                <i class="bi bi-plus"></i> Aggiungi Spot
            </button>
        </div>
        <ul class="list-group mt-3" id="spot-list">
            <?php
            $spotModel = new ProductSpotModel($pdo);
            $spots = $spotModel->getSpotsByProductId($id);
            foreach ($spots as $spot):
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?php echo htmlspecialchars($spot['spot']); ?> - <?php echo htmlspecialchars($spot['valore_spot']); ?>€</span>
                <button class="btn btn-danger btn-sm delete-spot" data-id="<?php echo $spot['id']; ?>">
                    <i class="bi bi-trash"></i>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- Card: Gestione Slot -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Gestione Slot</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Slot associati</h5>
            <button class="btn btn-success btn-sm" id="add-slot">
                <i class="bi bi-plus"></i> Aggiungi Slot
            </button>
        </div>
        <ul class="list-group mt-3" id="slot-list">
            <?php
            $slotModel = new ProductSlotModel($pdo);
            $slots = $slotModel->getSlotsByProductId($id);
            foreach ($slots as $slot):
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?php echo htmlspecialchars($slot['slot']); ?> - <?php echo htmlspecialchars($slot['valore_slot']); ?>€</span>
                <button class="btn btn-danger btn-sm delete-slot" data-id="<?php echo $slot['id']; ?>">
                    <i class="bi bi-trash"></i>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</main>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let nomeInput = document.getElementById("nome");
    let slugInput = document.getElementById("slug");

    function generateSlug(text) {
        return text
            .toLowerCase()                          // Converti tutto in minuscolo
            .trim()                                 // Rimuovi spazi all'inizio e alla fine
            .replace(/[^a-z0-9\s-]/g, '')          // Rimuove caratteri speciali eccetto spazi e trattini
            .replace(/\s+/g, '-')                  // Sostituisce spazi con trattini
            .replace(/-+/g, '-');                  // Evita trattini multipli consecutivi
    }

    // Auto-generazione dello slug in base al nome
    nomeInput.addEventListener("input", function() {
        if (!slugInput.getAttribute("data-user-modified")) {
            slugInput.value = generateSlug(nomeInput.value);
        }
    });

    // Permetti la modifica manuale dello slug
    slugInput.addEventListener("input", function() {
        slugInput.setAttribute("data-user-modified", "true");
        slugInput.value = generateSlug(slugInput.value);
    });
});
</script>
<script>
    document.getElementById('image-upload-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        let formData = new FormData(this);
        fetch('../../function/ajax_upload_image.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Errore nel caricamento dell\'immagine');
            }
        })
        .catch(error => console.error('Errore:', error));
    });

    document.querySelectorAll('.delete-image').forEach(button => {
    button.addEventListener('click', function() {
        let imageId = this.getAttribute('data-id');

        fetch('../../function/ajax_delete_image.php', { 
            method: 'POST',  // Assicurati che sia POST
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: imageId })  // Passa l'ID come JSON
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Errore: ' + data.message);
            }
        })
        .catch(error => console.error('Errore:', error));
    });
});
</script>
<script>
document.getElementById('add-spot').addEventListener('click', function() {
    Swal.fire({
        title: "Aggiungi Spot",
        html: `
            <input type="text" id="spot-name" class="swal2-input" placeholder="Nome dello Spot" value="1° Posizione" required>
            <input type="number" id="valore-spot" class="swal2-input" placeholder="Inserisci un Prezzo" min="1" required>
        `,
        showCancelButton: true,
        confirmButtonText: "Aggiungi",
        cancelButtonText: "Annulla",
        preConfirm: () => {
            const spotName = document.getElementById('spot-name').value.trim();
            const valoreSpot = document.getElementById('valore-spot').value;

            if (!spotName || !valoreSpot || valoreSpot < 1) {
                Swal.showValidationMessage("Inserisci un nome e un valore valido!");
            }
            return { spotName, valoreSpot };
        }
    }).then((result) => {
        if (result.value) {
            fetch('../../function/ajax_add_spot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    product_id: <?php echo $id; ?>, 
                    spot: result.value.spotName,
                    valore_spot: result.value.valoreSpot
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    Swal.fire("Errore!", data.message, "error");
                }
            })
            .catch(error => console.error('Errore:', error));
        }
    });
});
</script>
<script>
// Aggiunta di un nuovo slot
document.getElementById('add-slot').addEventListener('click', function() {
    Swal.fire({
        title: "Aggiungi Slot",
        html: `
            <input type="time" id="slot-name" class="swal2-input" placeholder="Seleziona l'ora" required>
            <input type="number" id="valore-slot" class="swal2-input" placeholder="Inserisci un Prezzo" min="1" required>
        `,
        showCancelButton: true,
        confirmButtonText: "Aggiungi",
        cancelButtonText: "Annulla",
        preConfirm: () => {
            const slotName = document.getElementById('slot-name').value.trim();
            const valoreSlot = document.getElementById('valore-slot').value;

            if (!slotName || !valoreSlot || valoreSlot < 1) {
                Swal.showValidationMessage("Inserisci un nome e un valore valido!");
            }
            return { slotName, valoreSlot };
        }
    }).then((result) => {
        if (result.value) {
            fetch('../../function/ajax_add_slot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    product_id: <?php echo $id; ?>, 
                    slot: result.value.slotName,
                    valore_slot: result.value.valoreSlot
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    Swal.fire("Errore!", data.message, "error");
                }
            })
            .catch(error => console.error('Errore:', error));
        }
    });
});
</script>
<script>
    document.getElementById('add-periodo').addEventListener('click', function() {
    Swal.fire({
        title: "Aggiungi Periodo",
        html: `
            <input type="date" id="tipo-periodo" class="swal2-input">
            <input type="number" id="valore-periodo" class="swal2-input" placeholder="Inserisci un Prezzo" min="1" required>
        `,
        showCancelButton: true,
        confirmButtonText: "Aggiungi",
        cancelButtonText: "Annulla",
        preConfirm: () => {
            const tipoPeriodo = document.getElementById('tipo-periodo').value;
            const valorePeriodo = document.getElementById('valore-periodo').value;
            if (!valorePeriodo || valorePeriodo < 1) {
                Swal.showValidationMessage("Inserisci un valore valido!");
            }
            return { tipoPeriodo, valorePeriodo };
        }
    }).then((result) => {
        if (result.value) {
            fetch('../../function/ajax_add_periodo.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    product_id: <?php echo $id; ?>, 
                    tipo_periodo: result.value.tipoPeriodo,
                    valore_periodo: result.value.valorePeriodo
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    Swal.fire("Errore!", data.message, "error");
                }
            })
            .catch(error => console.error('Errore:', error));
        }
    });
});
</script>
<script>
    document.querySelectorAll('.delete-spot').forEach(button => {
    button.addEventListener('click', function() {
        let spotId = this.getAttribute('data-id');
        fetch('../../function/ajax_delete_spot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: spotId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                Swal.fire("Errore!", data.message, "error");
            }
        })
        .catch(error => console.error('Errore:', error));
    });
});

document.querySelectorAll('.delete-slot').forEach(button => {
    button.addEventListener('click', function() {
        let slotId = this.getAttribute('data-id');
        fetch('../../function/ajax_delete_slot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: slotId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                Swal.fire("Errore!", data.message, "error");
            }
        })
        .catch(error => console.error('Errore:', error));
    });
});

document.querySelectorAll('.delete-periodo').forEach(button => {
    button.addEventListener('click', function() {
        let periodoId = this.getAttribute('data-id');
        fetch('../../function/ajax_delete_periodo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: periodoId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                Swal.fire("Errore!", data.message, "error");
            }
        })
        .catch(error => console.error('Errore:', error));
    });
});
</script>

    <?php include '../materials/script.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>