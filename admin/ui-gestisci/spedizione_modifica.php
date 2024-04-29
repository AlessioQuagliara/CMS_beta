<?php 
require '../../app.php'; // Include le funzioni, assicurati che il percorso sia corretto

// Verifica se l'ID della collezione è stato fornito
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_spedizione = $_GET['id'];

    // Se è stato inviato un form di modifica, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifica'])) {
        $messaggio = modificaSpedizione($id_spedizione);
        echo "<script>window.opener.location.href = '../ui/spedizioni.php';</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }
    // Se è stato inviato un form di Cancellazione, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $messaggio = modificaSpedizione($id_spedizione);
        echo "<script>window.opener.location.href = '../ui/spedizioni.php'; window.close();</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }

    // Ora puoi recuperare i dettagli correnti della collezione per mostrarli nella pagina
    $dettagliSpedizione = ottieniDettagliSpedizione($id_spedizione); 
} else {
    header("Location: spedizioni.php"); // Reindirizza se l'ID della collezione non è valido o mancante
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Modifica <?php echo $dettagliSpedizione['tipo_spedizione']; ?></title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<form id="deleteSpedizioneForm" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_spedizione; ?>" method="POST">
    <input type="hidden" name="action" value="delete">
</form>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_spedizione; ?>" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Modifica "<?php echo $dettagliSpedizione['tipo_spedizione']; ?>"</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        &nbsp;&nbsp;
            <div class="btn-group me-2">
                <button type="submit" name="modifica" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
                <button type="button" class="btn btn-sm btn-outline-light" onclick="confirmDeleteCodice()"><i class="fa-solid fa-trash"></i>&nbsp; Elimina Spedizione</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Tipologia Spedizione</h5>
            <?php $tipoSpedizione = $dettagliSpedizione['tipo_spedizione']; ?>
            <select class="form-select" id="tipo_spedizione" name="tipo_spedizione" required>
                <option selected>Scegli Modalità</option>
                <option value="Contrassegno" <?php echo isset($tipoSpedizione) && $tipoSpedizione == 'Contrassegno' ? 'selected' : ''; ?>>Contrassegno</option>
                <option value="Consegna a Domicilio" <?php echo isset($tipoSpedizione) && $tipoSpedizione == 'Consegna a Domicilio' ? 'selected' : ''; ?>>Consegna a Domicilio</option>
                <option value="Ritiro in Negozio" <?php echo isset($tipoSpedizione) && $tipoSpedizione == 'Ritiro in Negozio' ? 'selected' : ''; ?>>Ritiro in Negozio</option>
                <option value="Express" <?php echo isset($tipoSpedizione) && $tipoSpedizione == 'Express' ? 'selected' : ''; ?>>Express</option>
                <option value="Standard" <?php echo isset($tipoSpedizione) && $tipoSpedizione == 'Standard' ? 'selected' : ''; ?>>Standard</option>
            </select>
        </div>
        <div class="card-body">
            <h5 class="card-title">Prezzo Spedizione</h5>
            <input type="text" class="form-control" id="prezzo_spedizione" name="prezzo_spedizione" value="<?php echo $dettagliSpedizione['prezzo_spedizione']; ?>" required>
        </div>
        <div class="card-body">
            <h5 class="card-title">Peso Max Spedizione</h5>
            <input type="text" class="form-control" id="peso_spedizione" name="peso_spedizione" value="<?php echo $dettagliSpedizione['peso_spedizione']; ?>" required>
        </div>
    </div>
</form>

<script>
function exit() {
    swal({
        title: "Attenzione!",
        text: "Uscire senza salvare?",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then((willExit) => {
        if (willExit) {
            window.close(); // Chiude la finestra corrente
        }
    });
}
function confirmDeleteCodice() {
    swal({
        title: "Conferma Eliminazione",
        text: "Sei sicuro di voler eliminare questa Spedizione?",
        icon: "warning",
        buttons: ["Annulla", "Elimina"],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            document.getElementById('deleteSpedizioneForm').submit();
        }
    });
}

function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/spedizioni.php'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }
</script>


<?php include '../materials/script.php'; ?>
</body>
</html>
