<?php 
require '../../app.php'; 
loggato();

if(isset($_GET['id']) && is_numeric($_GET['id']) ){
    $id_order = $_GET['id'];
} else {
    $result = 'Id Ordine non trovato';
    exit;
}

require '../../conn.php';

if(isset($_GET['id']) && is_numeric($_GET['id']) ){

    $id_order = $_GET['id'];

    $query = "UPDATE ordini SET stato_ordine = 'Inevaso' WHERE id_ordine = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo 'Ordine Inevaso';
        header("Location: ordine_modifica?id=$id_order");
    } else {
        echo ' righe non trovate ';
    }

    $stmt->close();
} else {
    echo ' id non valido ';
}
$conn->close();


?>

