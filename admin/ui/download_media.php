<?php
session_start();
require ('../../app.php');
loggato();

// Controlla se è stato fornito un ID ordine valido
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("ID ordine non valido.");
}

$order_id = intval($_GET['order_id']);

// Percorsi delle cartelle dei media associati all'ordine
$orderMediaPath = '../../uploads/content/' . $order_id;
$imageFolder = $orderMediaPath . '/immagini';
$videoFolder = $orderMediaPath . '/video';

// Nome del file ZIP
$zipFileName = 'media_order_' . $order_id . '.zip';

// Crea un nuovo oggetto ZipArchive
$zip = new ZipArchive();

$tempZipPath = tempnam(sys_get_temp_dir(), 'zip');

if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    
    // Funzione per aggiungere i file al file ZIP
    function addFilesToZip($folderPath, $zip, $subfolder = '') {
        if (file_exists($folderPath)) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = $subfolder . '/' . basename($filePath);
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }
    }

    // Aggiungi i file delle immagini e dei video allo ZIP
    addFilesToZip($imageFolder, $zip, 'immagini');
    addFilesToZip($videoFolder, $zip, 'video');

    $zip->close();

    // Imposta gli header per il download del file ZIP
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
    header('Content-Length: ' . filesize($tempZipPath));

    // Leggi il file ZIP temporaneo e invialo al browser
    readfile($tempZipPath);

    // Rimuovi il file ZIP temporaneo
    unlink($tempZipPath);

    exit;
} else {
    die("Errore durante la creazione del file ZIP.");
}
?>