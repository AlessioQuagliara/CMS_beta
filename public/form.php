<?php
require '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $telefono = $_POST['phone'];
    $messaggio = $_POST['message'];

    $feedback = "";

    $query = "INSERT INTO leads (nome, email, telefono, messaggio, data_rec) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ssss", $nome, $email, $telefono, $messaggio);
        $result = $stmt->execute();
        if ($result) {
            $feedback = "informazione aggiuta con sucesso";
            header("Location:../home?success=" . urlencode($feedback));
            exit;
        } else {
            $feedback = "errore durante l'inserimento dell'informazione " . $stmt->error;
            header("Location:../home?error=" . urlencode($feedback));
            exit;
        }
        $stmt->close();
    } else {
        $feedback = "errore durante la preparazione della query ";
        header("Location:../home?error=" . urlencode($feedback));
        exit;
    }
    $conn->close();
    header("Location:../home");
    exit;
}
