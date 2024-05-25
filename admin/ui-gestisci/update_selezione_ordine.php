<?php 
require ('../../app.php');
loggato();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nuovoStato = $_POST['nuovoStato'];

    // Assumi di avere una connessione al database già configurata ($conn)
    $query = "UPDATE ordini SET selected = ? WHERE id_ordine = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuovoStato, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Stato aggiornato.";
    } else {
        echo "Errore nell'aggiornamento.";
    }

    $stmt->close();
    $conn->close();
}

?>
