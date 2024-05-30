<?php
require '../../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_ordine = $_POST['id_ordine'];
    $id_prodotti = $_POST['id_prodotto'];
    $quantita = $_POST['quantita'];
    $prezzi = $_POST['prezzo'];

    // Log dei dati ricevuti
    error_log("ID Ordine: " . $id_ordine);
    error_log("ID Prodotti: " . print_r($id_prodotti, true));
    error_log("Quantità: " . print_r($quantita, true));
    error_log("Prezzi: " . print_r($prezzi, true));

    $totale_ordine = 0;

    foreach ($id_prodotti as $index => $id_prodotto) {
        $quantita_prodotto = $quantita[$index];
        $prezzo_prodotto = $prezzi[$index];
        $totale_prodotto = $quantita_prodotto * $prezzo_prodotto;
        
        $sql = "INSERT INTO dettagli_ordini (id_ordine, id_prodotto, quantita, prezzo) VALUES ('$id_ordine', '$id_prodotto', '$quantita_prodotto', '$totale_prodotto')";
        
        if (!mysqli_query($conn, $sql)) {
            error_log("Errore nell'inserimento del prodotto: " . mysqli_error($conn));
        } else {
            $totale_ordine += $totale_prodotto;
        }
    }

    // Aggiorna il totale dell'ordine
    $sql_update_totale = "UPDATE ordini SET totale_ordine = totale_ordine + $totale_ordine WHERE id_ordine = '$id_ordine'";
    
    if (!mysqli_query($conn, $sql_update_totale)) {
        error_log("Errore nell'aggiornamento del totale ordine: " . mysqli_error($conn));
    }

    echo 'Ordine salvato con successo!';
}
?>
