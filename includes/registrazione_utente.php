<?php

include "../config.php";

$email = $_POST['email'];
$username = $_POST['username'];
$password = md5($_POST['password']);


$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);


if (strpos($email, '@') === false) { //strpos cerca un carattere dentro la stringa e restituisce la posizione
    echo "Email non valida";
    exit();
}

$parti = explode('@', $email);  //DA MIGLIORARE, POICHE QUALSIASI STUDENTE POTREBBE METTERE L'EMAIL DI UN PROFESSORE.
$dominio = strtolower(trim($parti[1]));

if ($dominio == "studenti.itisavogadro.it") {
    $ruolo = 's';
} elseif ($dominio == "itisavogadro.it") {
    $ruolo = 'd';
} else {
    echo "Dominio non valido";
    echo $dominio;
    exit();
}

$controllo = "SELECT SUM(email = '$email') AS email_esiste, 
            SUM(username = '$username') AS username_esiste 
            FROM UTENTI";

$risultato = mysqli_query($conn, $controllo);
$row = mysqli_fetch_assoc($risultato);

if($row['email_esiste'] || $row['username_esiste']){
    echo "Email o username già in uso.<br>";
    echo '<br><a href="registrazione.php">Torna al form di registrazione</a>';
} else{
    $inserimento = "INSERT INTO utenti (id, username, email, password, ruolo, account_activation_hash)
                    VALUES(NULL, '$username', '$email', '$password', '$ruolo', '$activation_token_hash')";
    $result = mysqli_query($conn, $inserimento);
    if($result){
        echo "Registrazione completata. Perfavore controlla l'email per attivare l'account.";
        //manda email attivazione
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom($_ENV['SMTP_USER'], "Paolo Cataldo");
        $mail->addAddress($_POST["email"]);
        $mail->Subject = "Attivazione Account";
        $mail->Body = <<<END

        Clicca <a href="http://localhost/Cataldo/mobilita_sostenibile/includes/attiva_account.php?token=$activation_token">qui</a> 
        per attivare il tuo account.

        END;

        try{
            $mail->send();
        } catch(Exception $e){
            echo "Il messaggio non è stato inviato. Errore mailer: {$mail->ErrorInfo}";
            exit;
        }
    }
    else{
        echo "Errore nell'inserimento: " . mysqli_error($conn);
    } 
}



