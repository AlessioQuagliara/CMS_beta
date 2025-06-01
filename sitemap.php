<?php
header('Content-Type: application/xml');

$db = new SQLite3(__DIR__ . '/db/database.db');

echo '<?xml version="1.0" encoding="UTF-8"?>';

$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
$result = $db->query('SELECT slug, language, updated_at FROM pages');

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $loc = htmlspecialchars("{$baseUrl}/{$row['language']}/{$row['slug']}");
    $lastmod = $row['updated_at'] ?: date('c');
    echo "
    <url>
        <loc>$loc</loc>
        <lastmod>$lastmod</lastmod>
    </url>";
}
?>
</urlset>
