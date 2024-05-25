<?php 
require '../../app.php'; 
loggato();

if(isset($_GET['id']) && is_numeric($_GET['id']) ){
    $id_order = $_GET['id'];
} else {
    echo 'Id Ordine non trovato';
    exit;
}

require '../../conn.php';

$query = "UPDATE ordini SET stato_ordine = 'abbandonato' WHERE id_ordine = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Errore nella preparazione della query: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $id_order);
$stmt->execute();

if($stmt->affected_rows > 0){
    echo 'Ordine Abbandonato';
    header("Location: ordine_modifica?id=$id_order");
    exit;
} else {
    echo 'Nessuna riga trovata';
}

$stmt->close();
$conn->close();
?>
