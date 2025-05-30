<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header('Location: login_info.php?error=' . urlencode('Tutti i campi sono obbligatori.'));
        exit();
    }

    $stmt = $conn->prepare("SELECT id_utente, nome, cognome, password FROM user_db WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id_utente'],
                'nome' => $user['nome'],
                'cognome' => $user['cognome']
            ];

            header('Location: dashboard.php');
            exit();
        } else {
            header('Location: login_info.php?error=' . urlencode('Password errata.'));
            exit();
        }
    } else {
        header('Location: login_info.php?error=' . urlencode('Utente non trovato.'));
        exit();
    }
}
?>