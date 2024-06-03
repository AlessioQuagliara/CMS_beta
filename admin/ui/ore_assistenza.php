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
    <title>LinkBay - Assistenza & Supporto</title>
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
            <h4>Il tuo Pacchetto Ore</h4>
        </div>
    </div>

    <div class="container mt-2">
        <div class="p-3 mb-2 bg-light rounded-3 border">
            <?php stampaOreAssistenza();?>
        </div>
    </div>
    
    <div class="container mt-2">
        <div class="p-3 mb-2 bg-light rounded-3 border d-flex justify-content-center">
            <a href="https://billing.stripe.com/p/login/28obLQcUtdo27Ys144" class="btn btn-warning mx-2"><i class="fa-solid fa-dice"></i> Change H/support plan</a>
            <a href="phone:393899657115" class="btn btn-primary mx-2"><i class="fa-solid fa-headphones"></i> Speak with a consultant</a>
            <a href="https://api.whatsapp.com/send/?phone=3899657115&text=Ciao%21+Ho+bisogno+di+aiuto+su+questo..&type=phone_number&app_absent=0" class="btn btn-success mx-2"><i class="fa-brands fa-whatsapp"></i> Message us on WhatsApp</a>
        </div>
    </div>

    <div class="container mt-2">
            <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
            <stripe-pricing-table pricing-table-id="prctbl_1PKKSsDLzaeBHrX0NHsDCSvM"
            publishable-key="pk_live_51MijPqDLzaeBHrX0rui4jtJnGx1kTSKVNbVy6hbQQYUfoMhVTMVEFoN6U7jfYh2tyRgLhvSgOSM5wpSmi55nS3PH00XUmvoSY0">
            </stripe-pricing-table>
    </div>

    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
