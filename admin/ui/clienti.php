<?php
require('../../app.php');
loggato()
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Clienti</title>
    <?php include '../materials/head_content.php'; ?>
</head>

<body style="background-color: #f1f1f1;">

    <?php
    $sidebar_cate = 'clienti';
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php';
    ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <!-- TABELLA CONTENUTI -->

        <?php echo listaClienti(); ?>

        <!-- MESSAGGIO -->

        <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 999;"></div>

        <!-- PROMETHEUS -->

        <?php include "prometheus.php" ?>

    </main>
    <!--
    <script>
        // SCRIPT DI APERTURA MODIFICA 
        function apriModifica(idUtente) {
            // Apri una nuova finestra con l'URL desiderato e specifica le dimensioni
            window.open('../ui-gestisci/cliente_modifica.php?id=' + idUtente, 'ModificaClienti', <?php echo $resolution; ?>);
        }
    </script>
    -->
    <?php include '../materials/script.php'; ?>
    <script src="../materials/main_clienti.js"></script>
</body>

</html>