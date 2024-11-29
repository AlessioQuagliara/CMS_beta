<?php 
require ('../../app.php');
loggato();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Pagina Non trovata</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- CANCELLA CONTENUTO DOPO AGGIORNAMENTO-->
                <style>
            /* Stile per centrare il div */
            .centered-div {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 80vh; /* Altezza del viewport */
            }
        </style>
        <div class="container centered-div">
            <h1 class="display-4">404 <i class="fa-solid fa-ban"></i></h1>
            <p class="lead">Pagina non trovata.</p>
        </div>

    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>

