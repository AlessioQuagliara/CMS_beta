<?php 
require ('../../app.php');
loggato();

require ('../../conn.php');

$selected = 'true';

$query = "DELETE FROM collezioni WHERE selected = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $selected);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: ../ui/collezioni?success=Collezioni+cancellate+con+successo");
    exit();
} else {
    header("Location: ../ui/collezioni?warning=Errore:+Nessuna+collezione+selezionata");
    exit();
}

$stmt->close();
$conn->close();
?>
