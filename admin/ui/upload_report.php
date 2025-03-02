<?php
require('../../app.php');
loggato();

// Verifica se è stato ricevuto un file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['report_file']) && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $upload_dir = "../../uploads/reports/$order_id/";

    // Crea la cartella se non esiste
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['report_file'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Verifica il formato
    $allowed_extensions = ['pdf', 'png'];
    if (!in_array($file_ext, $allowed_extensions)) {
        echo json_encode(['success' => false, 'message' => 'Formato non valido. Carica solo file PDF o PNG.']);
        exit();
    }

    // Determina il percorso di destinazione
    $file_path = $upload_dir . "report." . $file_ext;

    // Sposta il file nella cartella dell'ordine
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        echo json_encode(['success' => true, 'message' => 'File caricato con successo!', 'file_url' => $file_path]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante il caricamento del file.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta non valida.']);
}
?>