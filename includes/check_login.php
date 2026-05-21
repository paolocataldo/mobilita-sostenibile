<?php
session_start();
include "../config.php";

if (!isset($_POST['username']) || !isset($_POST['password'])) {

    $_SESSION['errore_login'] = "Compila tutti i campi!";
    header("Location: ../pages/login.php");
    exit();
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = md5($_POST['password']);

$sql = "SELECT id, username, ruolo 
        FROM utenti 
        WHERE username = '$username' 
        AND password = '$password' 
        AND (account_activation_hash IS NULL OR account_activation_hash = '')";

$query = mysqli_query($conn, $sql);

if (!$query) {

    $_SESSION['errore_login'] = "Errore durante il login.";
    header("Location: ../pages/login.php");
    exit();
}

$result = mysqli_fetch_assoc($query);

if ($result) {

    $_SESSION['username'] = $result['username'];
    $_SESSION['id_utente'] = $result['id'];
    $_SESSION['ruolo'] = $result['ruolo'];
    $_SESSION['LOGGED'] = true;

    if ($result['ruolo'] == 'd') {

        header("Location: ../pages/pagina_privata.php");
        exit();

    } 
    else if ($result['ruolo'] == 's') {

        header("Location: ../pages/pag_priv2.php");
        exit();

    } 
    else {

        $_SESSION['errore_login'] = "Ruolo non valido.";
        header("Location: ../pages/login.php");
        exit();
    }

} else {

    $_SESSION['errore_login'] = "Credenziali errate o account non attivato.";
    header("Location: ../pages/login.php");
    exit();
}
?>