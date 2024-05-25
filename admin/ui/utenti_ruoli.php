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
    <title>LinkBay - Utenti e Ruoli</title>
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
            <div class="p-3 mb-2 bg-light rounded-3 d-flex justify-content-between align-items-center border">
                <div class="input-group">
                    <h4 class="mb-0">Ruoli Gestione Contenuti</h4>
                </div>
                <button id="aggiungi-collaboratore" type="submit" class="btn btn-sm btn-outline-dark">
                    Aggiungi/Modifica
                </button>
             </div>
            <div class="p-3 mb-2 bg-light rounded-3 border">
                <h6>Amministratori</h6>
                <?php echo estraiDatiAmministratori();?>
            </div>
            <div class="p-3 mb-2 bg-light rounded-3 border">
                <h6>Sviluppatori</h6>
                <?php echo estraiDatiSviluppatori();?>
            </div>

        </div>
    </main>
    <script>
        document.getElementById('aggiungi-collaboratore').addEventListener('click', function(event) {
            // Previene il comportamento predefinito del pulsante se necessario
            event.preventDefault();
            // Apri una nuova finestra con le dimensioni desiderate
            var nuovaFinestra = window.open('../ui-gestisci/aggiunta_administrator.php', 'AggiungiCollaboratore', <?php echo $resolution;?>);
            // Puoi impostare il focus sulla nuova finestra se necessario
            nuovaFinestra.focus();
        });
    </script>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
