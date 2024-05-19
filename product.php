<?php
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
  } else {
  require_once ('app.php'); require 'visita.php';
  $productTitle = isset($_GET['titolo']) ? $_GET['titolo'] : '';
  
  require ('conn.php');
  $stmt = $conn->prepare("SELECT * FROM prodotti WHERE titolo_seo = ?");
  $stmt->bind_param("s", $productTitle);
  
  $stmt->execute();
  
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
      $product = $result->fetch_assoc();
  } else {
      echo "Prodotto non trovato.";
      exit;
  }
  
  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="it">
<!-- TESTA -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO -->
    <title><?php echo htmlspecialchars($product['titolo']); ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="shortcut icon" href="src/media_system/favicon.ico" type="image/x-icon">
    <!-- LINK STILE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- GOOGLE & FACEBOOK -->
    <?php include ('marketing/market_integration.php');?>
    <!-- FINE TESTA -->
</head>
<body>    
<?php
$namePage = 'prodotto';
customPage($namePage); 
?>
<!-- SCRIPT BOOTSTRAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>