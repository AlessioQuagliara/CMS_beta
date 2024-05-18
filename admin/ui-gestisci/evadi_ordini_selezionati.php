<?php 
require ('../../app.php');
loggato();

require ('../../conn.php');

$selected = 'true';
$query = "UPDATE ordini SET stato_ordine='Evaso' WHERE selected = ?";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    header("Location: ../ui/ordini_inevasi?warning=Errore+interno+del+server");
    exit();
}

$stmt->bind_param("s", $selected);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $updateSelectedQuery = "UPDATE ordini SET selected = 'false' WHERE selected = 'true'";
    $stmt2 = $conn->prepare($updateSelectedQuery);
    if ($stmt2 === false) {
        header("Location: ../ui/ordini_inevasi?warning=+Errore+interno+del+server");
        exit();
    }
    
    $stmt2->execute();
    if ($stmt2->affected_rows > 0) {
        header("Location: ../ui/ordini_inevasi?success=+Ordini+evasi+con+successo");
        exit();
    } else {
        header("Location: ../ui/ordini_inevasi?warning=+Ordini+evasi+ma+errore+nell'aggiornamento");
        exit();
    }
    
    $stmt2->close();
} else {
    header("Location: ../ui/ordini_inevasi?warning=+Errore:+Nessun+ordine+selezionato");
    exit();
}

$stmt->close();
$conn->close();
?>
