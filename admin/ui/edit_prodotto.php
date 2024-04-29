<?php 
require ('../../app.php');
loggato();

$namePage = 'prodotto'; // Nome della pagina da caricare

// Prepara la query SQL per selezionare il contenuto della pagina specificata
$stmt = $conn->prepare("SELECT content FROM editor_contents WHERE name_page = ? LIMIT 1");
$stmt->bind_param("s", $namePage);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $savedContent = $row['content'];
} else {
    $savedContent = ''; // Imposta un contenuto predefinito o lascia vuoto se non viene trovato nulla
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Editor <?php echo $namePage;?></title>
    <?php include '../materials/head_content.php'; ?>
    <!-- Script JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- CSS di GrapesJS -->
    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet"/>
    <!-- Script JS di GrapesJS -->
    <script src="https://unpkg.com/grapesjs"></script>
    <!-- Plugin GrapesJS per i blocchi predefiniti -->
    <script src="https://unpkg.com/grapesjs-preset-webpage"></script>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'negozio'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <?php include_once ('editor.php'); ?>
      
    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
