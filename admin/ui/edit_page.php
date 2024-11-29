<?php 
require ('../../app.php');
loggato();

if (isset($_GET['pagename']) && isset($_GET['slug'])) {
    // Recupera i valori dei parametri e li assegna a variabili
    $namePage = htmlspecialchars($_GET['pagename'], ENT_QUOTES, 'UTF-8');
    $visualizzaPagina = htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8');
} else {
    echo "I parametri non sono stati forniti nella URL.";
    exit();
}

// Prepara la query SQL per selezionare il contenuto della pagina specificata
$stmt = $conn->prepare("SELECT * FROM editor_contents WHERE name_page = ? LIMIT 1");
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
    <link rel="stylesheet" href="../../style.css">
</head>
<body style="background-color: #f1f1f1;">
    


    <?php include_once ('editor.php'); ?>
      

    
<?php include '../materials/script.php'; ?>
</body>
</html>
