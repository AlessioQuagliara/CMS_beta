<?php
header('Content-Type: application/json');

require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email'], $data['code'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtps.aruba.it';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@spotexsrl.it';
    $mail->Password   = 'Spotexsrl@juanealessio2023';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('info@spotexsrl.it', 'CMS Spotex');
    $mail->addAddress($data['email']);

    $mail->isHTML(true);
    $mail->Subject = 'Codice di conferma registrazione';
    $mail->Body    = '<p>Ciao!<br><br>Il tuo codice di conferma è: <strong>' . $data['code'] . '</strong><br><br>Inseriscilo per completare la registrazione.<br><br>Grazie!</p>';

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Mailer Error: ' . $mail->ErrorInfo]);
}