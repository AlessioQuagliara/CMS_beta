<?php
require('../../conn.php'); // Connessione al database

// Controlla se l'ID dell'immagine è stato passato
if(isset($_GET['id_immagine'], $_GET['id_prodotto']) && is_numeric($_GET['id_immagine']) && is_numeric($_GET['id_prodotto'])) {
    $id_immagine = $_GET['id_immagine'];
    $id_prodotto = $_GET['id_prodotto'];

    // Recupera il percorso dell'immagine dal database
    $query = "SELECT immagine FROM media WHERE id_media = $id_immagine";
    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($result)) {
        $file_path = '../../src/media/' . basename($row['immagine']);

        // Elimina il file immagine dal server
        if(file_exists($file_path)) {
            unlink($file_path);
        }

        // Elimina l'immagine dal database
        $delete_query = "DELETE FROM media WHERE id_media = $id_immagine";
        mysqli_query($conn, $delete_query);

        // Redireziona l'utente alla pagina precedente o mostra un messaggio
        echo 'Immagine eliminata con successo';
        header("Location: prodotto_modifica.php?id=$id_prodotto");
    } else {
        // L'immagine non è stata trovata nel database
        echo 'Immagine non trovata nel database';
    }
} else {
    // ID non valido o non fornito
    echo 'ID Fornito non valido';
}

// Chiudi la connessione al database
mysqli_close($conn);
?>
