<?php 
require '../../app.php'; // Include le funzioni, assicurati che il percorso sia corretto

// Verifica se l'ID della collezione è stato fornito
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_codicesconto = $_GET['id'];

    // Se è stato inviato un form di modifica, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifica'])) {
        $messaggio = modificaCodicesconto($id_codicesconto);
        echo "<script>window.opener.location.href = '../ui/codicisconto.php';</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }
    // Se è stato inviato un form di Cancellazione, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $messaggio = modificaCodicesconto($id_codicesconto);
        echo "<script>window.opener.location.href = '../ui/codicisconto.php'; window.close();</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }

    // Ora puoi recuperare i dettagli correnti della collezione per mostrarli nella pagina
    $dettagliCodicesconto = ottieniDettagliCodicesconto($id_codicesconto); 
} else {
    header("Location: codicisconto.php"); // Reindirizza se l'ID della collezione non è valido o mancante
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Modifica <?php echo $dettagliCodicesconto['codicesconto']; ?></title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<form id="deleteCodiceForm" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_codicesconto; ?>" method="POST">
    <input type="hidden" name="action" value="delete">
</form>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_codicesconto; ?>" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Modifica "<?php echo $dettagliCodicesconto['codicesconto']; ?>"</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        &nbsp;&nbsp;
            <div class="btn-group me-2">
                <button type="submit" name="modifica" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
                <button type="button" class="btn btn-sm btn-outline-light" onclick="confirmDeleteCodice()"><i class="fa-solid fa-trash"></i>&nbsp; Elimina Codice</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Codice Sconto</h5>
            <input type="text" class="form-control" id="codicesconto" name="codicesconto" value="<?php echo $dettagliCodicesconto['codicesconto']; ?>" required>
        </div>
        <div class="card-body">
            <h5 class="card-title">Importo</h5>
            <input type="text" class="form-control" id="importo" name="importo" value="<?php echo $dettagliCodicesconto['importo']; ?>" required>
        </div>
        <div class="card-body">
            <h5 class="card-title">Validità</h5>
            <?php $codiceSconto = $dettagliCodicesconto['stato']; ?>
            <select class="form-select" id="stato" name="stato" required>
                <option value="Valido" <?php echo isset($codiceSconto) && $codiceSconto == 'Valido' ? 'selected' : ''; ?>>Valido</option>
                <option value="Non Valido" <?php echo isset($codiceSconto) && $codiceSconto == 'Non Valido' ? 'selected' : ''; ?>>Non Valido</option>
            </select>
        </div> 
    </div>
</form>

<script>
function exit() {
    swal({
        title: "Uscire senza salvare?",
        text: "Tutte le modifiche non salvate andranno perse.",
        icon: "warning",
        buttons: ["Annulla", "Uscire"],
        dangerMode: true
    }).then((willExit) => {
        if (willExit) {
            window.close(); // Chiude la finestra corrente
        }
    });
}
function confirmDeleteCodice() {
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler eliminare questo codice? Questa azione è irreversibile.",
        icon: "warning",
        buttons: ["Annulla", "Elimina"],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            document.getElementById('deleteCodiceForm').submit();
        }
    });
}
function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/codicisconto.php'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }
</script>


<?php include '../materials/script.php'; ?>
</body>
</html>
