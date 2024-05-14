<?php
require ('../../app.php');
loggato();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_ordine = $_POST['id_ordine'];
    require ('../../conn.php');
    $query = ""; 
    header("Location: ordine_modifica_dati.php?id=$id_ordine");
    exit();
} else{
    echo 'ordine non trovato';
}



?>