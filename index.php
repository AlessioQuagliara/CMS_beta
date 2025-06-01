<?php
// Parse the URL
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $requestUri);

$language = $segments[0] ?? 'en';
$slug = $segments[1] ?? 'home';

$db = new SQLite3(__DIR__ . '/db/database.db');

// Fetch page content
$stmt = $db->prepare("SELECT * FROM pages WHERE slug = :slug AND language = :lang LIMIT 1");
$stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
$stmt->bindValue(':lang', $language, SQLITE3_TEXT);
$page = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$page) {
    http_response_code(404);
    echo "<h1>404 - Page Not Found</h1>";
    exit;
}

// Fetch marketing tools for the current user (user_id = 1)
$marketing = $db->querySingle("SELECT google_tag, facebook_pixel FROM marketing_tools WHERE user_id = 1", true);

// Fetch cookie policy (if any)
$cookieStmt = $db->prepare("SELECT * FROM cookie_policy_tools WHERE user_id = 1 AND status = 'enabled' LIMIT 1");
$cookieEmbed = $cookieStmt->execute()->fetchArray(SQLITE3_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($language) ?>">
<head>
    <?php if (!empty($marketing['google_tag'])): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($marketing['google_tag']) ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '<?= htmlspecialchars($marketing['google_tag']) ?>');
        </script>
    <?php endif; ?>

    <?php if (!empty($marketing['facebook_pixel'])): ?>
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '<?= htmlspecialchars($marketing['facebook_pixel']) ?>');
          fbq('track', 'PageView');
        </script>
        <noscript>
          <img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=<?= htmlspecialchars($marketing['facebook_pixel']) ?>&ev=PageView&noscript=1"/>
        </noscript>
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page['title']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page['description']) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($page['keywords']) ?>">
</head>
<body>
    <?= $page['content'] ?>
    <?php if ($cookieEmbed): ?>
        <?= $cookieEmbed['embed_code'] ?>
    <?php endif; ?>
</body>
</html>