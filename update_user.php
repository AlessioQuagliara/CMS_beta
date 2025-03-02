<?php
session_start();
require_once 'app.php'; // Connessione al database
require_once 'config.php';
require_once 'models/user.php';

// Verifica se l'utente è loggato
if (!isset($_SESSION['user'])) {
    header('Location: Login');
    exit();
}

// Recupera l'ID dell'utente dalla sessione
$userId = intval($_SESSION['user']['id_utente']);

// Se il metodo di richiesta non è POST, reindirizza alla dashboard
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit();
}

// Recupera i dati dal form
$nome = trim($_POST['nome']);
$cognome = trim($_POST['cognome']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$codiceFiscale = trim($_POST['codice_fiscale']);
$partitaIva = trim($_POST['partita_iva']);
$ragioneSociale = trim($_POST['ragione_sociale']);
$indirizzo = trim($_POST['indirizzo']);
$cap = trim($_POST['cap']);
$citta = trim($_POST['citta']);
$provincia = trim($_POST['provincia']);
$nazione = trim($_POST['nazione']);
$password = $_POST['password']; // Password non viene trim() per evitare problemi di hashing

// Validazione di base
if (empty($nome) || empty($cognome) || empty($email)) {
    header('Location: impostazioni.php?error=campi_obbligatori');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: impostazioni.php?error=email_non_valida');
    exit();
}

// Inizializza il modello utente
$userModel = new UserModel($pdo);

// Aggiorna i dati utente (eccetto password)
$updateSuccess = $userModel->updateUser($userId, [
    'nome' => $nome,
    'cognome' => $cognome,
    'email' => $email,
    'telefono' => $telefono,
    'codice_fiscale' => $codiceFiscale,
    'partita_iva' => $partitaIva,
    'ragione_sociale' => $ragioneSociale,
    'indirizzo' => $indirizzo,
    'cap' => $cap,
    'citta' => $citta,
    'provincia' => $provincia,
    'nazione' => $nazione
]);

// Se è stata inserita una nuova password, aggiorna anche quella
if (!empty($password)) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $passwordUpdateSuccess = $userModel->updateUserPassword($userId, $passwordHash);
}

// Aggiorna la sessione con i nuovi dati
$_SESSION['user'] = $userModel->getUserById($userId);

// Reindirizza con un messaggio di successo
header('Location: impostazioni.php?success=update_completo');
exit();