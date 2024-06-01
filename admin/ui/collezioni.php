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
    <title>LinkBay - Collections</title>

    <?php include '../materials/head_content.php'; ?>
</head>

<body style="background-color: #f1f1f1;">

    <?php
    $sidebar_cate = 'prodotti';
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php';
    ?>



    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <!-- BARRA STRUMENTI -->

        <!--         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="input-group">
                <input class="form-control" id="searchInput" type="text" placeholder="Cerca..." aria-label="Cerca">
                <button class="btn btn-sm btn-outline-secondary" type="button" onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i>&nbsp; Esporta Tabella</button>&nbsp;
                <form action="../ui-gestisci/aggiunta_collezione.php" method="POST" style="display: inline;">&nbsp;
                    <input type="hidden" name="action" value="addColl"> Campo nascosto per controllare l'azione nel backend
                    <button type="submit" class="btn btn-sm btn-outline-dark">
                        <i class="fa-solid fa-plus"></i>&nbsp; Aggiungi Collezione
                    </button>
                </form>
            </div>
        </div> -->
        <!-- TABELLA CONTENUTI -->

        <?php echo listaCollezioni(); ?>

        <!-- MESSAGGIO ------------------------------->

        <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 999;"></div>

        <!-- PROMETHEUS --> 

        <?php include "prometheus.php" ?>   

    </main>

    <?php include '../materials/script.php'; ?>
    <script src="../materials/main_collezioni.js"></script>
</body>

</html>