<?php 
require '../../app.php'; // Include le funzioni, assicurati che il percorso sia corretto

// Verifica se l'ID della collezione è stato fornito
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_collezione = $_GET['id'];

    // Se è stato inviato un form di modifica, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifica'])) {
        $messaggio = modificaCollezione($id_collezione);
        echo "<script>window.opener.location.href = '../ui/collezioni.php';</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }
    // Se è stato inviato un form di Cancellazione, processa le modifiche
    $messaggio = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        $messaggio = modificaCollezione($id_collezione);
        echo "<script>window.opener.location.href = '../ui/collezioni.php'; window.close();</script>"; // Aggiorna la pagina genitore e chiude la finestra corrente
    }

    // Ora puoi recuperare i dettagli correnti della collezione per mostrarli nella pagina
    $dettagliCollezione = ottieniDettagliCollezione($id_collezione);
} else {
    header("Location: collezioni.php"); // Reindirizza se l'ID della collezione non è valido o mancante
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Modifica <?php echo $dettagliCollezione['nome_c']; ?></title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

<form id="deleteCollectionForm" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_collezione; ?>" method="POST">
    <input type="hidden" name="action" value="delete">
</form>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id_collezione; ?>" method="POST" style="padding: 10px;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
        <h1 class="h2">&nbsp;&nbsp;Modifica "<?php echo $dettagliCollezione['nome_c']; ?>"</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        &nbsp;&nbsp;
            <div class="btn-group me-2">
                <button type="submit" name="modifica" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
                <a href='crea_categoria.php?nome_c=<?php echo urlencode($dettagliCollezione['nome_c']); ?>&id_collezione=<?php echo $id_collezione; ?>' class="btn btn-sm btn-outline-light"><i class="fa-solid fa-plus"></i>&nbsp;Aggiungi Categoria</a>
                <button type="button" class="btn btn-sm btn-outline-light" onclick="confirmDeleteCollect()"><i class="fa-solid fa-trash"></i>&nbsp; Elimina Collezione</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Nome Collezione</h5>
            <input type="text" class="form-control" id="nome_c" name="nome_c" value="<?php echo $dettagliCollezione['nome_c']; ?>" required>
        </div>
        <div class="card-body">
            <h5 class="card-title">Descrizione Collezione</h5>
            <textarea class="form-control" id="descrizione_c" name="descrizione_c" rows="4" required><?php echo $dettagliCollezione['descrizione_c']; ?></textarea>
        </div>
    </div>
</form>

<div style="padding: 20px;">
<?php 
// Assicurati che $dettagliCollezione sia stato impostato e contenga 'nome_c'
if (isset($dettagliCollezione['nome_c'])) {
    echo visualizzaCategorie($dettagliCollezione['nome_c']);
}
?>
</div>

<script>
function exit() {
    swal({
        title: "Sei sicuro?",
        text: "Uscire senza salvare? Le modifiche non salvate andranno perse.",
        icon: "warning",
        buttons: ["Annulla", "Conferma"],
        dangerMode: true
    }).then((willExit) => {
        if (willExit) {
            window.close(); // Chiude la finestra corrente
        }
    });
}
function confirmDeleteCollect() {
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler eliminare questa collezione? Questa azione è irreversibile.",
        icon: "warning",
        buttons: ["Annulla", "Elimina"],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            document.getElementById('deleteCollectionForm').submit();
        }
    });
}
function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/collezioni.php'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }
function confermaEliminazione(idCategoria) {
    swal({
        title: "Sei sicuro?",
        text: "Vuoi davvero eliminare questa categoria? Questa azione non può essere annullata.",
        icon: "warning",
        buttons: ["Annulla", "Elimina"],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            fetch('elimina_categoria.php?id_categoria=' + idCategoria)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        swal("Categoria eliminata con successo", {
                            icon: "success",
                        });
                        // Aggiorna la pagina o rimuovi la riga della tabella
                        location.reload(); // Per semplicità, qui ricarichiamo la pagina
                    } else {
                        swal("Errore nell'eliminazione", 'Errore durante l\'eliminazione della categoria: ' + data.error, "error");
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    swal("Errore nell'eliminazione", 'Errore durante l\'eliminazione della categoria', "error");
                });
        }
    });
}

</script>


<?php include '../materials/script.php'; ?>
</body>
</html>
