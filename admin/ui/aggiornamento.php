<?php 
require ('../../app.php');
loggato();
require '../../conn.php';
$localVersionFile = '../../version.txt';
$remoteVersionUrl = 'https://raw.githubusercontent.com/AlessioSpotex/CMS_beta/main/version.txt';
$token = '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';

// Leggi la versione locale
$localVersion = file_get_contents($localVersionFile);
$localVersion = trim($localVersion);

// Funzione per ottenere il contenuto del file remoto
function getRemoteFileContent($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: token $token",
        "User-Agent: PHP-cURL"
    ));
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Errore cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    return $result;
}

// Leggi la versione remota
$remoteVersion = getRemoteFileContent($remoteVersionUrl, $token);
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
        <br>
    <div class="p-3 bg-light rounded-3 border">
        <h4>Aggiornamento Software CMS</h4>
    </div> 
    <br>
    <div class="p-3 bg-light rounded-3 border">
    <?php if ($localVersion !== $remoteVersion): ?>
            <div class="alert alert-info">
                È disponibile una nuova versione: <?php echo htmlspecialchars($remoteVersion); ?>.
            </div>
            <form action="../../install_linkbay/aggiornamento_software.php" method="post">
                <button type="submit" class="btn btn-primary">Aggiorna alla versione <?php echo htmlspecialchars($remoteVersion); ?></button>
            </form>
        <?php else: ?>
            <div>
                Non ci sono aggiornamenti. La tua versione è la più recente: <?php echo htmlspecialchars($localVersion); ?>.
            </div>
        <?php endif; ?>
    </div> 
    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
