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
    <title>LinkBay - Brand Identity</title>
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
        <div class="p-3 mb-2 bg-light rounded-3 border d-flex justify-content-center align-items-center">
            <h4>Informazioni Grafiche della tua Attività</h4>
        </div>
    </div>
    <div class="container mt-5">
        <h5>Carica le immagini</h5>
        <form action="../ui-gestisci/brand_caricamento.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="favicon" class="form-label">Carica Favicon (.ico)</label>
                <input class="form-control" type="file" name="favicon" id="favicon" accept=".ico">
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Carica Logo (.png)</label>
                <input class="form-control" type="file" name="logo" id="logo" accept=".png">
            </div>
            <button type="submit" class="btn btn-primary">Carica Immagini</button>
        </form>
    </div>

    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
