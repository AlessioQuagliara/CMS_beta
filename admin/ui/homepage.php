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
    <title>LinkBay - HomePage</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <br><br>
    <!-- STATISTICHE RAPIDE -->
    <div class="p-3 mb-2 bg-light rounded-3">

        <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link" id="nav-visite-tab" data-bs-toggle="tab" data-bs-target="#nav-visite" type="button" role="tab" aria-controls="nav-visite" aria-selected="true">Visite</button>

          <button class="nav-link active" id="nav-vendite-tab" data-bs-toggle="tab" data-bs-target="#nav-vendite" type="button" role="tab" aria-controls="nav-vendite" aria-selected="false">Vendite</button>

          <button class="nav-link" id="nav-ordini-tab" data-bs-toggle="tab" data-bs-target="#nav-ordini" type="button" role="tab" aria-controls="nav-ordini" aria-selected="false">Ordini</button>
          
          <button class="nav-link" id="nav-clienti-tab" data-bs-toggle="tab" data-bs-target="#nav-clienti" type="button" role="tab" aria-controls="nav-clienti" aria-selected="false">Clienti</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <!-- TAB PER LE VISITE ECOMMERCE -->
        <div class="tab-pane fade" id="nav-visite" role="tabpanel" aria-labelledby="nav-visite-tab" tabindex="0">
            <?php echo visite();?>
        </div>
        <div class="tab-pane fade show active" id="nav-vendite" role="tabpanel" aria-labelledby="nav-vendite-tab" tabindex="0">
            <?php echo vendite();?>
        </div>
        <div class="tab-pane fade" id="nav-ordini" role="tabpanel" aria-labelledby="nav-ordini-tab" tabindex="0">
            <?php echo ordini();?>
        </div>
        <div class="tab-pane fade" id="nav-clienti" role="tabpanel" aria-labelledby="nav-clienti-tab" tabindex="0">
            <?php echo visualizzaClientiELeads();?>
        </div>
      </div>

    </div>

    <div class="p-3 mb-2 bg-light rounded-3">
        <?php echo dettagli_negozio();?>
    </div>

    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
