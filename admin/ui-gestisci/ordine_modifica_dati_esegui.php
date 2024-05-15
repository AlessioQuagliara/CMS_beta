<?php
require ('../../app.php');
loggato();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_ordine = $_POST['id_ordine'];
    $email = $_POST['email'];
    $data_ordine = $_POST['data_ordine'];
    $stato_ordine = $_POST['stato_ordine'];
    $totale_ordine = $_POST['totale_ordine'];
    $indirizzo_spedizione = $_POST['indirizzo_spedizione'];
    $paese = $_POST['paese'];
    $cap = $_POST['cap'];
    $citta = $_POST['citta'];
    $provincia = $_POST['provincia'];
    $telefono = $_POST['telefono'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $tipo_spedizione = $_POST['tipo_spedizione'];

    require ('../../conn.php');

    $query = ""; 

    header("Location: ordine_modifica_dati.php?id=$id_ordine");
    exit();
} else{
    echo 'Ordine non trovato';
}

?>