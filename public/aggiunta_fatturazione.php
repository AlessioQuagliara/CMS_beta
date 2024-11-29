<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['fatturazione'] = [
        'nome' => $_POST['nome'],
        'cognome' => $_POST['cognome'],
        'email' => $_POST['email'],
        'indirizzo' => $_POST['indirizzo'],
        'provincia' => $_POST['provincia'],
        'paese' => $_POST['paese'],
        'cap' => $_POST['cap'],
        'citta' => $_POST['citta']
    ];
    
    // Reindirizzamento alla pagina di spedizione
    header("Location: ../payments/spedizione.php");
    exit();
}
?>