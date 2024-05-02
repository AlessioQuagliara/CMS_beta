<?php 
require '../../app.php'; // Inclusione Principale
loggato();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Ordine </title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
<form id="deleteOrderForm" action="" method="POST">
    <input type="hidden" name="action" value="delete">
</form>

<form action="" method="POST" style="padding: 10px;">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom bg-dark text-light rounded-2">
            <h1 class="h2">&nbsp;&nbsp;Ordine ""</h1> <!-- Modificato per usare il titolo dal database -->
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="submit" name="modifica" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Salva Modifiche</button>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="confirmDeleteOrder();"><i class="fa-solid fa-trash"></i>&nbsp; Elimina Ordine</a>
                <a href="#" class="btn btn-sm btn-outline-light" onclick="exit();"><i class="fa-solid fa-rectangle-xmark"></i>&nbsp; Chiudi Scheda</a>
            </div>
        </div>
    </div>

<?php echo $result;?>


    <div class="row">

        <!-- Colonna di sinistra -->
        <div class="col-md-6">
            <!-- DETTAGLI ORDINE, mettere lista articoli -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettagli Ordine</h5>
                </div>
            </div>

            <!-- DETTAGLI SPEDIZIONE, inserire dettagli della spedizione -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettagli Spedizione</h5>
                </div>
            </div>

            <!-- TRACK NUMBER, inserisci qui il tracking -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tracciabilità Pacco</h5>
                </div>
            </div>

            <!-- ANALISI CONSUMATORE, inserisci l'analisi di quanti ordini ha fatto il cliente -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Analisi Cliente</h5>
                </div>
            </div>
        </div>

        <!-- Colonna di destra -->
        <div class="col-md-6">
            <!-- DETTAGLI CLIENTE, inserire i dettagli del cliente -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettagli Cliente</h5>
                </div>
            </div>

    </div>
</form>




<!-- FUNZIONI DI USCITA ---------------------------------------------------------------------------------------------------------------------------------------------------------->
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
function confirmDeleteOrder() {
    swal({
        title: "Sei sicuro?",
        text: "Vuoi abbandonare questo ordine? Verrà notificato il cliente ma non rimborsato, per rimborsare il cliente dovrai accedere alla sezione 'rimborsi'.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            document.getElementById('deleteOrderForm').submit();
        }
    });
}

function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/ordini_inevasi'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }



</script>




<?php include '../materials/script.php'; ?>
</body>
</html>
