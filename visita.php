<?php
session_start();

// Connetti al database
require 'conn.php'; // Modifica con il percorso corretto

if (!isset($_SESSION['visitatore_id'])) {
    // Genera un nuovo ID visitatore unico
    $_SESSION['visitatore_id'] = uniqid('visitatore_');

    // Registra il nuovo visitatore nel database
    $query = "INSERT INTO visitatori (id_visitatore, data_visita) VALUES (?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['visitatore_id']);
    $stmt->execute();
    $stmt->close();
} else {
    // Opzionalmente, aggiorna la data di visita dell'utente esistente
    $query = "UPDATE visitatori SET data_visita = NOW() WHERE id_visitatore = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['visitatore_id']);
    $stmt->execute();
    $stmt->close();
}

// Chiudi la connessione al database
$conn->close();




//Includere questo script nelle pagine:
// require 'visita.php';

?>


