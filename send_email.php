<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    
    $to = "info@congrazia.it";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    $email_subject = "Nuovo messaggio da $name";
    $email_body = "Nome: $name\n";
    $email_body .= "Telefono: $phone\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Oggetto: $subject\n\n";
    $email_body .= "Messaggio:\n$message";
    
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    http_response_code(403);
    echo json_encode(["success" => false]);
}
?>
