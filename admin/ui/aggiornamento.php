<?php 
require ('../../app.php');
loggato();
require '../../conn.php';
$localVersionFile = '../../version.txt';
$remoteVersionUrl = 'https://raw.githubusercontent.com/AlessioSpotex/CMS_beta/main/version.txt';

// Leggi la versione locale
$localVersion = file_get_contents($localVersionFile);
$localVersion = trim($localVersion);

// Leggi la versione remota
$remoteVersion = file_get_contents($remoteVersionUrl);
$remoteVersion = trim($remoteVersion);
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
        <h1>Aggiornamento CMS</h1>
        <?php if ($localVersion !== $remoteVersion): ?>
            <div class="alert alert-info">
                È disponibile una nuova versione: <?php echo htmlspecialchars($remoteVersion); ?>.
            </div>
            <form action="aggiornamento_software.php" method="post">
                <button type="submit" class="btn btn-primary">Aggiorna alla versione <?php echo htmlspecialchars($remoteVersion); ?></button>
            </form>
        <?php else: ?>
            <div class="alert alert-success">
                Non ci sono aggiornamenti. La tua versione è la più recente: <?php echo htmlspecialchars($localVersion); ?>.
            </div>
        <?php endif; ?>
    </div>
    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
