<?php
require ('../../app.php');
loggato();

if ($_SESSION['ruolo'] !== 'Amministratore') {
    header('Location: ../ui/editor_negozio?warning=Utente+non+autorizzato');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Recupera il nome della pagina dal database prima di cancellarla
    $stmt = $conn->prepare("SELECT page_name FROM seo WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($page_name);
    $stmt->fetch();
    $stmt->close();

    // Percorso del file PHP da cancellare
    $file_path = "../../" . htmlspecialchars($page_name) . ".php";

    // Cancella la pagina dal database
    $stmt = $conn->prepare("DELETE FROM seo WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Cancella il file PHP associato se esiste
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        header('Location: ../ui/editor_negozio?success=Pagina+cancellata+con+successo');
    } else {
        header('Location: ../ui/editor_negozio?warning=Errore+nella+cancellazione+della+pagina');
    }

    $stmt->close();
} else {
    header('Location: ../ui/editor_negozio?warning=ID+pagina+non+fornito');
}

$conn->close();
?>