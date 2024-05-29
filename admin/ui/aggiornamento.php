<?php 
require ('../../app.php');
loggato();
require '../../conn.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Dettagli Negozio</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'impostazioni'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5">
            <h1>Aggiorna CMS</h1>
            <form action="../ui-gestisci/aggiornamento_software.php" method="post">
                <button type="submit" class="btn btn-primary">Aggiorna alla versione più recente</button>
            </form>
        </div>
    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
