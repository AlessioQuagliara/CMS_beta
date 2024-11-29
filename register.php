<?php
require 'conn.php'; // Connessione al database

// Controlla se il modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Raccogli i dati inviati dal form
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $password = $_POST['password'];

    // Validazione dei dati
    if (empty($nome) || empty($cognome) || empty($email) || empty($telefono) || empty($password)) {
        header('Location: registrazione_fallita.php?errore=campi_obbligatori');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: registrazione_fallita.php?errore=email_non_valida');
        exit();
    }

    if (!preg_match('/^\d{10,15}$/', $telefono)) {
        header('Location: registrazione_fallita.php?errore=telefono_non_valido');
        exit();
    }

    // Hash della password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Inserimento nel database
        $stmt = $conn->prepare("
            INSERT INTO user_db (nome, cognome, email, telefono, password, data_registrazione, ultimo_accesso)
            VALUES (?, ?, ?, ?, ?, NOW(), NULL)
        ");
        $stmt->bind_param('sssss', $nome, $cognome, $email, $telefono, $passwordHash);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Reindirizza alla pagina di successo
            header('Location: login');
            exit();
        } else {
            header('Location: registrazione_fallita.php?errore=errore_generico');
            exit();
        }

        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        if ($conn->errno === 1062) { // Errore di duplicato
            header('Location: registrazione_fallita.php?errore=duplicato');
        } else {
            header('Location: registrazione_fallita.php?errore=' . urlencode($e->getMessage()));
        }
        exit();
    }
} else {
    // Accesso non autorizzato
    header('Location: registrati.php');
    exit();
}
?>