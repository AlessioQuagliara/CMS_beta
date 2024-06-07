<?php
// Imposta l'intestazione del contenuto XML
header('Content-Type: application/xml');

// Recupera il nome del dominio dinamicamente
$domain = $_SERVER['HTTP_HOST']; // o $_SERVER['SERVER_NAME']

// Funzione per creare una singola URL entry
function create_url_entry($url, $lastmod, $changefreq, $priority) {
    return "
    <url>
        <loc>$url</loc>
        <lastmod>$lastmod</lastmod>
        <changefreq>$changefreq</changefreq>
        <priority>$priority</priority>
    </url>";
}

// Inizia la costruzione della sitemap
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Aggiungi le URL statiche del sito usando il dominio dinamico
$sitemap .= create_url_entry('https://' . $domain . '/', date('Y-m-d'), 'weekly', '1.0');

// Connetti al database
require ('../conn.php');

// Esegui una query per ottenere gli slug delle pagine
$result = $conn->query("SELECT slug FROM SEO");

// Itera attraverso i risultati e aggiungi le URL dinamiche
while ($row = $result->fetch_assoc()) {
    $sitemap .= create_url_entry('https://' . $domain . '/' . $row['slug'], date('Y-m-d'), 'monthly', '0.8');
}

// Chiudi la connessione al database
$conn->close();

// Chiudi il tag urlset
$sitemap .= '</urlset>';

// Stampa la sitemap
echo $sitemap;
?>