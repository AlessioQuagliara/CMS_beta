<?php
require '../../app.php'; // o il tuo file di connessione al database
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idProdottoOriginale = $_GET['id'];
    // Logica per duplicare il prodotto...
    $nuovoIdProdotto = duplicaProdotto($idProdottoOriginale);
    
    // Reindirizzamento alla pagina di modifica per il nuovo prodotto
    if ($nuovoIdProdotto) {
        header('Location: prodotto_modifica.php?id=' . $nuovoIdProdotto);
        exit;
    } else {
        echo "Errore durante la duplicazione del prodotto.";
        // Gestire l'errore come preferisci
    }
} else {
    header('Location: pagina_errore.php'); // Reindirizza se l'ID prodotto non è valido
    exit;
}
?>
