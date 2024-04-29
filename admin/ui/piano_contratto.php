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
    <title>LinkBay - Piano & Contratto</title>
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
        <div class="p-3 mb-2 bg-light rounded-3 d-flex justify-content-between align-items-center">
            <h4>Modifica il tuo piano</h4>
            <a href="https://billing.stripe.com/p/login/28obLQcUtdo27Ys144" class="btn btn-outline-secondary">Modifica Piano</a>
        </div>
        <?php 
            if($licenza == 'valida'){echo  '<div class="alert alert-success" role="alert">Licenza Valida, rinnovare entro il </div>';}
            else if ($licenza == 'in scadenza'){echo  '<div class="alert alert-warning" role="alert">Licenza in Scadenza, rinnovare entro il </div>';}
            else{echo  '<div class="alert alert-danger" role="alert">Licenza Scaduta, rinnova ora.</div>';}
        ?>        
        <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
        <stripe-pricing-table pricing-table-id="prctbl_1OvK41DLzaeBHrX0ZnBTIHLx"
        publishable-key="pk_live_51MijPqDLzaeBHrX0rui4jtJnGx1kTSKVNbVy6hbQQYUfoMhVTMVEFoN6U7jfYh2tyRgLhvSgOSM5wpSmi55nS3PH00XUmvoSY0">
        </stripe-pricing-table>
        
    </div>
    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
