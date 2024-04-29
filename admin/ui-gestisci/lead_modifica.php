<?php 
require '../../app.php'; // Include le funzioni, assicurati che il percorso sia corretto

// Verifica se l'ID della collezione è stato fornito
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $lead = $_GET['id'];

    // Se è stato inviato un form di modifica, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifica'])) {
        $messaggio = modificaLead($lead);
        echo "<script>window.opener.location.href = '../ui/leads.php';</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }
    // Se è stato inviato un form di Cancellazione, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $messaggio = modificaLead($lead);
        echo "<script>window.opener.location.href = '../ui/leads.php'; window.close();</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }

    // Ora puoi recuperare i dettagli correnti per mostrarli nella pagina
    $dettagliLead = ottieniDettagliLead($lead);
} else {
    header("Location: leads.php"); // Reindirizza se l'ID  non è valido o mancante
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Dettagli Lead</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<form id="deleteLeadForm" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $lead; ?>" method="POST">
    <input type="hidden" name="action" value="delete">
</form>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $lead; ?>" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Visualizza Dettagli Lead</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        &nbsp;&nbsp;
            <div class="btn-group me-2">
                <button type="submit" name="modifica" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
                <button type="button" class="btn btn-sm btn-outline-light" onclick="confirmDeleteLead()"><i class="fa-solid fa-trash"></i>&nbsp; Elimina Lead</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Nome</h5>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $dettagliLead['nome']; ?>" required>
        </div>
        <div class="card-body">
            <h5 class="card-title">Email</h5>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $dettagliLead['email']; ?>" required>
        </div>
        <div class="card-body">
            <h5 class="card-title">Telefono</h5>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $dettagliLead['telefono']; ?>" required>
        </div>
        <div class="card-body">
            <h5 class="card-title">Messaggio</h5>
            <input type="text" class="form-control" id="messaggio" name="messaggio" value="<?php echo $dettagliLead['messaggio']; ?>" required>
        </div>
        <div class="card-body">
    <h5 class="card-title">Data Registro</h5>
    <input type="datetime-local" class="form-control" id="data_rec" name="data_rec" value="<?php echo date('Y-m-d\TH:i', strtotime($dettagliLead['data_rec'])); ?>" required>
</div>

    </div>
</form>

<script>
function exit() {
    swal({
        title: "Uscire senza salvare?",
        text: "Se esci ora, tutte le modifiche non salvate andranno perse.",
        icon: "warning",
        buttons: ["Annulla", "Uscire"],
        dangerMode: true
    }).then((willExit) => {
        if (willExit) {
            window.close(); // Chiude la finestra corrente
        }
    });
}
function confirmDeleteLead() {
    swal({
        title: "Sei sicuro di voler eliminare questo Lead?",
        text: "Questa azione è irreversibile e eliminerà tutte le informazioni associate a questo Lead.",
        icon: "warning",
        buttons: ["Annulla", "Elimina"],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            document.getElementById('deleteLeadForm').submit();
        }
    });
}
function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/leads.php'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }
</script>


<?php include '../materials/script.php'; ?>
</body>
</html>
