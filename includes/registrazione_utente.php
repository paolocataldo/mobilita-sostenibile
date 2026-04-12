<?php
include "../config.php";

$email = $_POST['email'];
$username = $_POST['username'];
$password = md5($_POST['password']);

$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

$messaggio = "";
$link = "";

if (strpos($email, '@') === false) {
    $messaggio = "Email non valida";
} else {
    $parti = explode('@', $email);
    $dominio = strtolower(trim($parti[1]));

    if ($dominio == "studenti.itisavogadro.it") {
        $ruolo = 's';
    } elseif ($dominio == "itisavogadro.it") {
        $ruolo = 'd';
    } else {
        $messaggio = "Dominio non valido";
    }
}

if ($messaggio == "") {

    $controllo = "SELECT SUM(email = '$email') AS email_esiste, 
                  SUM(username = '$username') AS username_esiste 
                  FROM utenti";

    $risultato = mysqli_query($conn, $controllo);
    $row = mysqli_fetch_assoc($risultato);

    if ($row['email_esiste'] || $row['username_esiste']) {
        $messaggio = "Email o username già in uso.";
        $link = "../pages/registrazione.php";
    } else {

        $inserimento = "INSERT INTO utenti (id, username, email, password, ruolo, account_activation_hash)
                        VALUES(NULL, '$username', '$email', '$password', '$ruolo', '$activation_token_hash')";

        $result = mysqli_query($conn, $inserimento);

        if ($result) {
            $messaggio = "Registrazione completata. Controlla l'email per attivare l'account.";

            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom($_ENV['SMTP_USER'], "Paolo Cataldo");
            $mail->addAddress($_POST["email"]);
            $mail->Subject = "Attivazione Account";

            $mail->Body = <<<END
Clicca <a href="http://localhost/Cataldo/mobilita_sostenibile/includes/attiva_account.php?token=$activation_token">qui</a> 
per attivare il tuo account.
END;

            try {
                $mail->send();
            } catch (Exception $e) {
                $messaggio = "Errore invio email.";
            }
        } else {
            $messaggio = "Errore nell'inserimento.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
    <link rel="stylesheet" href="../css/registrazione_utente.css">
</head>

<body class="register_page">

    <p><?php echo $messaggio; ?></p>

    <?php if ($link != ""): ?>
        <a href="<?php echo $link; ?>" class="btn">Torna alla registrazione</a>
    <?php endif; ?>

</body>

</html>