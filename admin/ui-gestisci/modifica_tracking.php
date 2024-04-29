<?php 
require ('../../app.php');
loggato();
$idOrdine = isset($_GET['id']) ? $_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Inserisci Tracking</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

    <?php echo aggiornaDettagliTracking($idOrdine); ?>

<?php include '../materials/script.php'; ?>
</body>
</html>
