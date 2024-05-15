<?php
require ('../../app.php');
loggato();

// Tabella = ordini

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_ordine = $_POST['id_ordine']; // INT 
    $email = $_POST['email']; // VARCHAR
    $data_ordine = $_POST['data_ordine'];  // DATE
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
    $selected = 'false';

    require ('../../conn.php');

    $query = "UPDATE ordini SET email = ?, data_ordine = ?, stato_ordine = ?, totale_ordine = ?, indirizzo_spedizione = ?, paese = ?, cap = ?, citta = ?, provincia = ?, telefono = ?, nome = ?, cognome = ?, tipo_spedizione = ?, selected = ? 
        WHERE id_ordine = ?";

    $stmt = $conn->prepare($query);

    if($stmt === false) {
        error_log("Errore nella preparazione della query: " . $conn->error, 3, "/var/log/php_errors.log");
        die("Errore nella preparazione della query: " . $conn->error);
    }

    $stmt->bind_param("ssssssssssssssi", $email, $data_ordine, $stato_ordine, $totale_ordine, $indirizzo_spedizione, $paese, $cap, $citta, $provincia, $telefono, $nome, $cognome, $tipo_spedizione, $selected, $id_ordine);

    if($stmt->execute()){
        header("Location: ordine_modifica.php?id=$id_ordine");
    } else {
        die("Errore nell'esecuzione" . $stmt->error);
    }

    $stmt->close();
    header("Location: ordine_modifica.php?id=$id_ordine");
    exit();
} else{
    error_log("Richiesta non valida: metodo diverso da POST", 3, "/var/log/php_errors.log");
    echo 'Ordine non trovato';
}



?>