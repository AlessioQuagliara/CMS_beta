<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php'; // Configurazione
require 'models/user.php'; // Importa il modello

// Recupera l'ID dell'utente dal POST, con fallback alla sessione
$userId = isset($_POST['id_utente']) ? intval($_POST['id_utente']) : (isset($_SESSION['user']['id_utente']) ? $_SESSION['user']['id_utente'] : null);

// Se l'ID utente non è valido, mostra errore
if (!$userId) {
    die("❌ ERRORE: ID utente non valido.");
}

// Recupera i dati dal form
$data = [
    'codice_fiscale'   => trim($_POST['codice_fiscale']),
    'partita_iva'      => trim($_POST['partita_iva']),
    'ragione_sociale'  => trim($_POST['ragione_sociale']),
    'indirizzo'        => trim($_POST['indirizzo']),
    'cap'              => trim($_POST['cap']),
    'citta'            => trim($_POST['citta']),
    'provincia'        => trim($_POST['provincia']),
    'nazione'          => trim($_POST['nazione'])
];

// Validazione dei dati obbligatori
if (empty($data['codice_fiscale']) || empty($data['indirizzo']) || empty($data['cap']) || empty($data['citta']) || empty($data['provincia']) || empty($data['nazione'])) {
    header("Location: completa_dati_utente.php?error=Campi obbligatori mancanti&user_id=" . urlencode($userId));
    exit();
}

try {
    // Inizializza il modello
    $userModel = new UserModel($pdo);

    // Aggiorna i dati nel database
    $success = $userModel->aggiornaDatiUtente($userId, $data);

    if ($success) {
        header("Location: login_info.php?success=Dati aggiornati con successo!");
    } else {
        header("Location: completa_dati_utente.php?error=Errore durante il salvataggio.&user_id=" . urlencode($userId));
    }
    exit();

} catch (Exception $e) {
    header("Location: completa_dati_utente.php?error=" . urlencode($e->getMessage()) . "&user_id=" . urlencode($userId));
    exit();
}
?>