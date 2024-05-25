<?php 
require ('../../app.php');
loggato()
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Carrelli Abbandonati</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

    <?php
    $sidebar_cate = 'ordini'; 
    $currentViews = 'Abbandonati';
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>
?>
<script>
    var whichPage = "abbandonato"; // Definisci la variabile globalmente
</script>

<!---------------------------------------------------------------------- CONTENUTO PAGINA ------------------------------------------------------------------------------------------>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<?php
        $whichPage = "abbandonato"; 
        echo stampaTabellaOrdini($whichPage); 
    ?>
</main>

<!---------------------------------------------------------------------- MAGIC ITEMS BAR ------------------------------------------------------------------------------------------>
<?php include 'prometheus.php'; ?>
<!---------------------------------------------------------------------- MAGIC ITEMS BAR ------------------------------------------------------------------------------------------>

<?php include '../materials/script.php'; ?>
<script src="../materials/main_ordini.js"></script>

</body>
</html>