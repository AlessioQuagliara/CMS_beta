<?php 
require ('../../app.php');
loggato();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $selected = $data['selected'];

    // Connessione al database
    require('../../conn.php');

    // Prepara e esegui la query di aggiornamento
    $query = "UPDATE ordini SET selected = ? WHERE id_ordine = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'si', $selected, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Restituisci una risposta JSON
        echo json_encode(['success' => true]);
    } else {
        // Restituisci un errore se la query non può essere preparata
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }

    // Chiudi la connessione al database
    mysqli_close($conn);
}

?>
