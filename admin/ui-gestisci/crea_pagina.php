<?php
include('../../app.php');
include('../../conn.php');

// Dati da inserire
$editor_page = "nuova_pagina";
$page_name = "nuova_pagina";
$slug = "nuova_pagina";
$title = "nuova_pagina";
$description = "nuova_descrizione";
$keywords = "nuova_keyword";

// Prepara e esegue la query SQL
$sql = "INSERT INTO seo (editor_page, page_name, slug, title, description, keywords) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $editor_page, $page_name, $slug, $title, $description, $keywords);

if ($stmt->execute()) {
    echo "Nuovo record creato con successo<br>";
} else {
    header("Location: ../ui/editor_negozio?error=Errore+durante+la+creazione+della+pagina");
}

$stmt->close();
$conn->close();

// Contenuto HTML/PHP che desideri inserire in page1.php
$pageContent = <<<'EOD'
<?php
if (!file_exists('conn.php')) {
    header("Location: error.php");
    exit();
} else {
    require_once 'app.php';
    require 'visita.php';
    require 'conn.php';

    if (isset($_GET['slug'])) {
        $slug = htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8');
        $stmt = $conn->prepare("SELECT * FROM seo WHERE slug = ?");
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $page = $result->fetch_assoc();

        if (!$page) {
            header("Location: error.php");
            exit();
        }
    } else {
        $page = [
            'title' => 'Nuova Pagina',
            'description' => 'Questa è una nuova pagina',
            'keywords' => 'nuova, pagina'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page['keywords']); ?>">
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page['description']); ?>">
    <meta property="og:image" content="src/media_system/logo_site.png">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">

    <link rel="shortcut icon" href="src/media_system/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <?php include 'marketing/market_integration.php'; ?>
</head>
<body>  
<?php
$namePage = isset($_GET['slug']) ? $_GET['slug'] : 'nuova_pagina';
customPage($namePage); 
?>
<!-- SCRIPT BOOTSTRAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
EOD;

// Percorso e nome del file
$file = '../../page1.php';

// Crea e scrive il contenuto nel file
file_put_contents($file, $pageContent);

header("Location: ../ui/editor_negozio?success=La+pagina+page1.php+è+stata+creata+con+successo.");
?>