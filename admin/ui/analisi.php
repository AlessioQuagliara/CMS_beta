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
    <title>LinkBay - Analisi</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'marketing'; 
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
                height: 100vh; /* Altezza del viewport */
            }
            /* Stile per l'icona */
            .icon {
                font-size: 5rem;
                margin-bottom: 1rem;
            }
        </style>
        <div class="container centered-div">
            <i class="fas fa-cogs icon"></i>
            <h1 class="display-4">Funzionalità in arrivo</h1>
            <p class="lead">Attendere l'aggiornamento di aprile</p>
        </div>

    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
