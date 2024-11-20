<?php
session_start();
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
} else {
    require_once 'app.php';
    require 'visita.php';
    require 'conn.php';

    if (isset($_GET['slug'])) {
        $slug = htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8');

        $stmt = $conn->prepare("SELECT * FROM seo WHERE slug = ?");
        if ($stmt) {
            $stmt->bind_param('s', $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            $page = $result->fetch_assoc();

            if (!$page) {
                header("Location: error.php");
                exit();
            }
        } else {
            header("Location: error.php");
            exit();
        }
    } else {
        $slug = 'home';
        $stmt = $conn->prepare("SELECT * FROM seo WHERE slug = ?");
        if ($stmt) {
            $stmt->bind_param('s', $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            $page = $result->fetch_assoc();
        } else {
            header("Location: error.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title'] ?? 'Default Title'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['description'] ?? 'Default Description'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page['keywords'] ?? 'Default Keywords'); ?>">
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page['title'] ?? 'Default Title'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page['description'] ?? 'Default Description'); ?>">
    <meta property="og:image" content="src/media_system/logo_site.png">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <?php include 'marketing/market_integration.php'; ?>
</head>

<body>
    <?php
    if (function_exists('customNav')) {
        customNav();
    } else {
        echo "<p>Errore: funzione customNav non definita.</p>";
    }

    $namePage = $_GET['slug'] ?? 'home';

    if (function_exists('customPage')) {
        customPage($namePage);
    } else {
        echo "<p>Errore: funzione customPage non definita.</p>";
    }

    if (function_exists('customFooter')) {
        customFooter();
    } else {
        echo "<p>Errore: funzione customFooter non definita.</p>";
    }

    include('public/cookie_banner.php');
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>