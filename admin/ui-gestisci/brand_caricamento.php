<?php
$faviconTargetDir = "../../src/media_system/";
$logoTargetDir = "../../src/media_system/";

$faviconFileName = "favicon_site.ico";
$logoFileName = "logo_site.png";

// Funzione per mostrare errori con SweetAlert2
function swalError($message) {
    echo "<script>Swal.fire({ icon: 'error', title: 'Errore', text: '" . addslashes($message) . "' });</script>";
}

function uploadFile($file, $targetDir, $fileName) {
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $targetFilePath = $targetDir . $fileName;

        if (file_exists($targetFilePath)) {
            unlink($targetFilePath);
        }

        // Sposta il file caricato alla posizione finale
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            echo "Il file " . htmlspecialchars(basename($file["name"])) . " è stato caricato con successo come " . $fileName . ".<br>";
            header("Location: ../ui/brand_identity.php");
        } else {
            swalError("Errore durante il caricamento del file " . htmlspecialchars(basename($file["name"])) . ".");
        }
    } else {
        swalError("Errore: nessun file caricato o errore nel caricamento.");
    }
}

// Carica i file favicon e logo se sono presenti
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['favicon'])) {
        uploadFile($_FILES['favicon'], $faviconTargetDir, $faviconFileName);
    }

    if (!empty($_FILES['logo'])) {
        uploadFile($_FILES['logo'], $logoTargetDir, $logoFileName);
    }
}
?>