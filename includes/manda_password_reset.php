<?php
include "../config.php";
$email = $_POST['email'];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token); //ritorna stringa di 64

$scadenza = date("Y-m-d H:i:s", time() + 60 * 30);

$sql = "UPDATE utenti
        SET reset_token_hash = '$token_hash',
            reset_token_expires_at = '$scadenza'
        WHERE email = '$email'";
$query = mysqli_query($conn, $sql);

if(mysqli_affected_rows($conn)){
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("paolo.cataldo0722@gmail.com", "Paolo Cataldo");
    $mail->addAddress($email);
    $mail->Subject = "Reset Password";
    $mail->Body = <<<END

    Clicca <a href="http://localhost/Cataldo/mobilita_sostenibile/pages/reset_password.php?token=$token">qui</a> 
    per resettare la tua password.

    END;

    try{
        $mail->send();
    } catch(Exception $e){
        echo "Il messaggio non è stato inviato. Errore mailer: {$mail->ErrorInfo}";
    }
}

echo "Messaggio inviato, perfavore controlla la tua email.";
?>