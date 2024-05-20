<?php     
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
  } else {
    require_once ('app.php'); require 'visita.php'; require 'conn.php';
    if (isset($_GET['slug'])) {
      $slug = $_GET['slug'];
      $stmt = $conn->prepare("SELECT * FROM seo WHERE slug = ?");
      $stmt->bind_param('s', $slug);
      $stmt->execute();
      $result = $stmt->get_result();
      $page = $result->fetch_assoc();
  
      if (!$page) {
          echo "Pagina non trovata.";
          exit();
      }
  } else {
      echo "Nessun slug specificato.";
      exit();
  }
  }
?>
<!DOCTYPE html>
<html lang="it">
<!-- TESTA -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO -->
    <title><?php echo htmlspecialchars($page['title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page['keywords']); ?>">
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
$namePage = 'home';
customPage($namePage); 
?>
<!-- SCRIPT BOOTSTRAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>