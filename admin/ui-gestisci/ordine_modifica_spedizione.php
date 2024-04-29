<?php 
require ('../../app.php');
loggato();
$idOrdine = isset($_GET['id']) ? $_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Spedisci Ordine</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

    <?php echo mostraDettagliOrdineSpedizione($idOrdine); ?>

        <br><br><br><br>
        <div class="d-flex justify-content-center">
    <div class="btn-group no-print" role="group" aria-label="Basic example">
        <button type="button" onclick="printPage()" class="btn btn-md btn-outline-secondary">Stampa <i class="fa-solid fa-print"></i></button>
        <button type="button" onclick="closeAndRefresh()" class="btn btn-md btn-outline-secondary">Chiudi <i class="fa-solid fa-xmark"></i></button>
    </div>
</div>

<style>
    @media print {
        .no-print, .no-print * {
            display: none !important;
        }
    }
</style>

<script>
    function printPage() {
        window.print(); // Utilizza la funzione di stampa del browser
    }

    function closeAndRefresh() {
        if (window.opener && !window.opener.closed) {
            window.opener.location.href = '../ui/ordini_spedire.php'; // Aggiorna la pagina genitore
        }
        window.close(); // Chiude la finestra corrente
    }
</script>





<?php include '../materials/script.php'; ?>
</body>
</html>
