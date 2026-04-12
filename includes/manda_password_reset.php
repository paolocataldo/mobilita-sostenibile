<?php
include "../config.php";

$email = $_POST['email'];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);

$scadenza = date("Y-m-d H:i:s", time() + 60 * 30);

$sql = "UPDATE utenti
        SET reset_token_hash = '$token_hash',
            reset_token_expires_at = '$scadenza'
        WHERE email = '$email'";
$query = mysqli_query($conn, $sql);

$messaggio = "Se l'email esiste, riceverai un link per il reset."; // più sicuro

if(mysqli_affected_rows($conn)){
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom($_ENV['SMTP_USER'], "Paolo Cataldo");
    $mail->addAddress($email);
    $mail->Subject = "Reset Password";

    $mail->Body = <<<END
Clicca <a href="http://localhost/Cataldo/mobilita_sostenibile/pages/reset_password.php?token=$token">qui</a> 
per resettare la tua password.
END;

    try{
        $mail->send();
        $messaggio = "Messaggio inviato, controlla la tua email.";
    } catch(Exception $e){
        $messaggio = "Errore invio email.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/manda_password_reset.css">
</head>
<body class="reset_page">

<p><?php echo $messaggio; ?></p>

<a href="../pages/login.php" class="btn">Torna al login</a>

</body>
</html>