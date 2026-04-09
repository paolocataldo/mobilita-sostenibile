<?php
include "../config.php";

$email = $_POST['email'];
$username = $_POST['username'];
$password = md5($_POST['password']);

<<<<<<< HEAD

=======
$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

/*
>>>>>>> 1575d80c80653a7b803a0cbc105f233c068255e3
if (strpos($email, '@') === false) { //strpos cerca un carattere dentro la stringa e restituisce la posizione
    echo "Email non valida";
    exit();
}

$parti = explode('@', $email);  //DA MIGLIORARE, POICHE QUALSIASI STUDENTE POTREBBE METTERE L'EMAIL DI UN PROFESSORE.
$dominio = strtolower(trim($parti[1]));

if ($dominio == "studenti.itisavogadro.it") {
    $ruolo = 's';
} elseif ($dominio == "itisavogadro.it") {
    $ruolo = 'p';
} else {
    echo "Dominio non valido";
    echo $dominio;
    exit();
<<<<<<< HEAD
}
=======
}*/
>>>>>>> 1575d80c80653a7b803a0cbc105f233c068255e3

$controllo = "SELECT SUM(email = '$email') AS email_esiste, 
            SUM(username = '$username') AS username_esiste 
            FROM UTENTI";

$risultato = mysqli_query($conn, $controllo);
$row = mysqli_fetch_assoc($risultato);

if($row['email_esiste'] || $row['username_esiste']){
    echo "Email o username già in uso.<br>";
    echo '<br><a href="registrazione.php">Torna al form di registrazione</a>';
} else{
<<<<<<< HEAD
    $inserimento = "INSERT INTO utenti (id, username, email, password, ruolo)
                    VALUES(NULL, '$username', '$email', '$password', '$ruolo')";
=======
    $inserimento = "INSERT INTO utenti (id, username, email, password, ruolo, account_activation_hash)
                    VALUES(NULL, '$username', '$email', '$password', NULL, '$activation_token_hash')";
>>>>>>> 1575d80c80653a7b803a0cbc105f233c068255e3
    $result = mysqli_query($conn, $inserimento);
    if($result) echo "Registrazione completata";
    else echo "Errore nell'inserimento: " . mysqli_error($conn);
}



