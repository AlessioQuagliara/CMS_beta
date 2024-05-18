<?php 
require ('../../app.php');
loggato();

require ('../../conn.php');

$selected = 'true';

$query = "DELETE FROM prodotti WHERE selected = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $selected);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: ../ui/prodotti?success=Prodotti+cancellati+con+successo");
    exit();
} else {
    header("Location: ../ui/prodotti?warning=Errore:+Nessun+prodotto+selezionato");
    exit();
}

$stmt->close();
$conn->close();
?>
