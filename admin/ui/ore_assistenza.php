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
    <title>LinkBay - Ore Assistenza</title>
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
            <h4>Il Tuo Pacchetto Ore</h4>
        </div>
    </div>

    <div class="container mt-2">
        <div class="p-3 mb-2 bg-light rounded-3 border">
            <div class="progress">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-number fw-bold">&nbsp; 53 ore disponibili</div>
            </div>
        </div>
    </div>
    
    <div class="container mt-2">
        <div class="p-3 mb-2 bg-light rounded-3 border d-flex justify-content-center">
            <a href="https://billing.stripe.com/p/login/28obLQcUtdo27Ys144" class="btn btn-warning mx-2"><i class="fa-solid fa-dice"></i> Cambia piano H/assistenza</a>
            <a href="phone:393899657115" class="btn btn-primary mx-2"><i class="fa-solid fa-headphones"></i> Parla con un consulente</a>
            <a href="https://api.whatsapp.com/send/?phone=3899657115&text=Ciao%21+Ho+bisogno+di+aiuto+su+questo..&type=phone_number&app_absent=0" class="btn btn-success mx-2"><i class="fa-brands fa-whatsapp"></i> Scrivici su Whatsapp</a>
        </div>
    </div>

    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
