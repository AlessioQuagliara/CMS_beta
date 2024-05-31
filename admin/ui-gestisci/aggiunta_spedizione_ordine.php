<?php
require '../../app.php';
loggato();
require '../../conn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_ordine = $_GET['id'];
} else {
    $result = 'Id ordine non trovato';
    exit;
}

// Recupera i dati esistenti per l'ordine
$sql_select = "SELECT corriere, stato_spedizione, tracking FROM tracking WHERE id_ordine = ?";
$stmt_select = $conn->prepare($sql_select);

if ($stmt_select === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt_select->bind_param('i', $id_ordine);
$stmt_select->execute();
$stmt_select->store_result();
$stmt_select->bind_result($corriere, $stato_spedizione, $tracking);
$stmt_select->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $corriere = $_POST['corriere'];
    $stato_spedizione = $_POST['stato_spedizione'];
    $tracking = $_POST['tracking'];

    // Query per inserire o aggiornare i dati nella tabella 'tracking'
    $sql = "INSERT INTO tracking (id_ordine, corriere, stato_spedizione, tracking) 
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            corriere = VALUES(corriere),
            stato_spedizione = VALUES(stato_spedizione),
            tracking = VALUES(tracking)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('isss', $id_ordine, $corriere, $stato_spedizione, $tracking);

    if ($stmt->execute()) {
        $result = 'Dati salvati con successo';
    } else {
        $result = 'Errore durante il salvataggio dei dati';
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Aggiungi Tracking</title>
    <?php include '../materials/head_content.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body style="background-color: #f1f1f1;">
    <form action="" method="POST" style="padding: 10px;">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
            <h1 class="h2">&nbsp;&nbsp;Aggiunta Tracking ID</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="submit" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva </button>
                    <a href="ordine_modifica?id=<?php echo $id_ordine; ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-chevron-left"></i>&nbsp; Torna Indietro</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Modifica Tracking</h5>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Corriere</label>
                            <div class="col-sm-10">
                                <input type="text" name="corriere" class="form-control" value="<?php echo htmlspecialchars($corriere); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Stato Spedizione</label>
                            <div class="col-sm-10">
                                <input type="text" name="stato_spedizione" class="form-control" value="<?php echo htmlspecialchars($stato_spedizione); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Tracking</label>
                            <div class="col-sm-10">
                                <input type="text" name="tracking" class="form-control" value="<?php echo htmlspecialchars($tracking); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function exit() {
            swal({
                    title: "Uscire senza salvare?",
                    text: "Se esci ora, le modifiche non verranno salvate.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.close(); // Chiude la finestra corrente
                    }
                });
        }

        function saveAndRefresh() {
            if (window.opener && !window.opener.closed) {
                window.location.href = 'ordine_modifica?id=<?php echo $id_ordine; ?>';
            }
        }
    </script>

    <?php include '../materials/script.php'; ?>
</body>

</html>