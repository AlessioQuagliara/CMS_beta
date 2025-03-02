<?php
require 'conn.php'; // Connessione al database

// Avvia il buffer di output per evitare problemi con l'header
ob_start();

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
        header('Location: login-info.php?error=campi_obbligatori');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login-info.php?error=email_non_valida');
        exit();
    }

    if (!preg_match('/^\d{10,15}$/', $telefono)) {
        header('Location: login-info.php?error=telefono_non_valido');
        exit();
    }

    // Hash della password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Prepara l'inserimento nel database
        $stmt = $conn->prepare("
            INSERT INTO user_db (nome, cognome, email, telefono, password, data_registrazione, ultimo_accesso)
            VALUES (?, ?, ?, ?, ?, NOW(), NULL)
        ");
        if (!$stmt) {
            header('Location: login-info.php?error=' . urlencode($conn->error));
            exit();
        }

        // Esegui il bind e l'inserimento
        $stmt->bind_param('sssss', $nome, $cognome, $email, $telefono, $passwordHash);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Recupera l'ID dell'utente appena registrato
            $userId = $stmt->insert_id;
            $stmt->close();
            $conn->close();

            // Debug: Verifica se l'header funziona
            error_log("✅ Registrazione riuscita! Reindirizzamento a completa_dati_utente.php?user_id=$userId");

            // Reindirizza alla pagina per completare i dati
            header("Location: completa_dati_utente.php?user_id=$userId");
            exit();
        } else {
            header('Location: login-info.php?error=errore_generico');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        header('Location: login-info.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Accesso non autorizzato
    header('Location: registrati.php');
    exit();
}

// Assicura che non ci siano output indesiderati
ob_end_flush();
?>