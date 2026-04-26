<?php
include "../config.php";

$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$id_classe = isset($_POST['classe']) ? intval($_POST['classe']) : null;

$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

$messaggio = "";
$link = "";

/* VALIDAZIONE EMAIL */
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $messaggio = "Email non valida";
} else {

    $dominio = strtolower(substr(strrchr($email, "@"), 1));

    if ($dominio == "studenti.itisavogadro.it") {
        $ruolo = 's'; // studente
    } elseif ($dominio == "itisavogadro.it") {
        $ruolo = 'd'; // docente
    } else {
        $messaggio = "Dominio non valido";
    }
}

/* CONTROLLO + INSERIMENTO */
if ($messaggio == "") {

    $controllo = "SELECT id FROM utenti WHERE email='$email' OR username='$username'";
    $risultato = mysqli_query($conn, $controllo);

    if (mysqli_num_rows($risultato) > 0) {
        $messaggio = "Email o username già in uso.";
        $link = "../pages/registrazione.php";
    } else {

        /* 👉 SE DOCENTE IGNORA CLASSE */
        if ($ruolo == 'd') {
            $id_classe_db = "NULL";
            $extra_msg = "Account docente: classe non assegnata.";
        } else {
            $id_classe_db = $id_classe;
            $extra_msg = "Account studente: classe assegnata.";
        }

        $inserimento = "INSERT INTO utenti 
            (username, email, password, ruolo, id_classe, account_activation_hash)
            VALUES 
            ('$username', '$email', '$password', '$ruolo', $id_classe_db, '$activation_token_hash')";

        $result = mysqli_query($conn, $inserimento);

        if ($result) {
            $messaggio = "Registrazione completata. $extra_msg Controlla l'email per attivare l'account.";

            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom($_ENV['SMTP_USER'], "Sistema Scuola");
            $mail->addAddress($email);
            $mail->Subject = "Attivazione Account";

            $mail->Body = "
                Clicca qui per attivare il tuo account:<br>
                <a href='http://localhost/Cataldo/mobilita_sostenibile/includes/attiva_account.php?token=$activation_token'>
                Attiva account
                </a>
            ";

            try {
                $mail->send();
            } catch (Exception $e) {
                $messaggio = "Errore invio email.";
            }

        } else {
            $messaggio = "Errore inserimento nel database.";
        }
    }
}
?>