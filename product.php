<?php
require('conn.php');
require_once('app.php');


$productTitle = isset($_GET['titolo']) ? $_GET['titolo'] : '';

$product = mostraProdotto($productTitle);
if (!$product) {
    header("Location: error");
    exit();
}

$namePage = 'prodotto';
$savedContent = '';

// Funzione per sostituire i placeholder del prodotto ------------------------------------------------------------------------------------------
function replacePlaceholders($content, $product) {
    $placeholders = [
        '{{ProductTitle}}' => htmlspecialchars($product['titolo']),
        '{{ProductCollection}}' => htmlspecialchars($product['collezione']),
        '{{ProductPrice}}' => htmlspecialchars($product['prezzo']),
        '{{ProductDescription}}' => htmlspecialchars($product['descrizione']),
        '{{ProductVariant}}' => htmlspecialchars($product['varianti'])
    ];
    
    return str_replace(array_keys($placeholders), array_values($placeholders), $content);
}

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

// Query per ottenere il contenuto salvato
$stmt = $conn->prepare("SELECT content FROM editor_contents WHERE name_page = ?");
$stmt->bind_param("s", $namePage);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $savedContent = $row['content'];
}


$savedContent = replacePlaceholders($savedContent, $product);
?>

<!DOCTYPE html>
<html lang="it">
<!-- TESTA -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['titolo']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($product['descrizione']); ?>">
    <meta name="keywords" content="">
    <link rel="shortcut icon" href="../src/media_system/favicon_site.ico" type="image/x-icon">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($product['titolo']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($product['descrizione']); ?>">
    <meta property="og:image" content="src/media_system/logo_site.png">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="Il Tuo Sito">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($product['titolo']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($product['descrizione']); ?>">
    <meta name="twitter:image" content="path/to/image.jpg">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "<?php echo htmlspecialchars($product['titolo']); ?>",
        "description": "<?php echo htmlspecialchars($product['descrizione']); ?>",
        "image": "path/to/image.jpg",
        "sku": "<?php echo htmlspecialchars($product['sku']); ?>",
        "brand": {
            "@type": "Brand",
            "name": "<?php echo htmlspecialchars($product['marca']); ?>"
        },
        "offers": {
            "@type": "Offer",
            "url": "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
            "priceCurrency": "EUR",
            "price": "<?php echo htmlspecialchars($product['prezzo']); ?>",
            "itemCondition": "https://schema.org/NewCondition",
            "availability": "https://schema.org/InStock"
        }
    }
    </script>

    <!-- LINK STILE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- GOOGLE & FACEBOOK -->
    <?php include 'marketing/market_integration.php'; ?>
    <!-- FINE TESTA -->
</head>
<body>    
<?php
customNav();
echo $savedContent;
customFooter();
?>
<!-- SCRIPT BOOTSTRAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<?php require_once('visita.php'); 
$stmt->close();
$conn->close();
?>
</body>
</html>
