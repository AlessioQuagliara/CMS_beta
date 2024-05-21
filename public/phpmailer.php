<?php

// Funzione di Email Plugin ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../admin/phpmailer/src/Exception.php';
require '../admin/phpmailer/src/PHPMailer.php';
require '../admin/phpmailer/src/SMTP.php';

function send_mail($email, $oggetto, $messaggio, $path_allegato = null){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "smtps.aruba.it"; //indirizzo del server di posta in uscita
    $mail->SMTPDebug = 0;
    $mail->Port = 465; //porta del server di posta in uscita
    $mail->SMTPAuth = true;
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure = 'ssl'; //tls o ssl informarsi presso il provider del vostro server di posta
    $mail->Username = "info@linkbay.it"; //la vostra mail
    $mail->Password = "Spotexsrl@juanealessio2024"; //password per accedere alla vostra mail
    $mail->Priority    = 3; //(1 = High, 3 = Normal, 5 = low)
    $mail->setFrom('info@linkbay.it', 'LinkBay'); //impostazione del mittente
    $mail->AddAddress($email);
    $mail->IsHTML(true); 
    $mail->CharSet = 'UTF-8'; // Imposta la codifica dei caratteri su UTF-8
    $mail->Subject = $oggetto;
    $mail->Body    = $messaggio;
    $mail->AltBody = "";
    $mail->AddAttachment($path_allegato);  
    if(!$mail->Send()){
        echo "Errore nell'invio della email: ".$mail->ErrorInfo;
        return false;
    } else {
        echo "Email inviata correttamente";
        return true;
    }
    //echo !extension_loaded('openssl')?"Not Available":"Available";
}

?>
