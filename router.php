<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$cleaned = trim($uri, '/');

// Routing per estensioni statiche
if (preg_match('/\.(css|js|png|jpg|jpeg|svg|ico|ttf|woff|woff2|eot)$/', $cleaned)) {
    return false; // lascia servire direttamente i file
}

// Se URL è tipo it/home → routing delle pagine CMS dinamiche
if (preg_match('#^[a-z]{2}/[a-z0-9\-]+$#', $cleaned)) {
    require __DIR__ . '/index.php';
    exit;
}

// Se è una pagina interna come admin/home → redirect a file corrispondente
$target = __DIR__ . '/' . $cleaned . '.php';
if (file_exists($target)) {
    require $target;
    exit;
}

// Fallback 404
http_response_code(404);
echo "<h1>404 - Pagina non trovata</h1>";