<?php
session_start();
include "../config.php";

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    die("Compila tutti i campi!");
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
    die("Errore query: " . mysqli_error($conn));
}

$result = mysqli_fetch_assoc($query);

if ($result) {

    $_SESSION['username'] = $result['username'];
    $_SESSION['id_utente'] = $result['id'];
    $_SESSION['ruolo'] = $result['ruolo'];
    $_SESSION['LOGGED'] = true;

    // CONTROLLO RUOLO
    if ($result['ruolo'] == 'd') {
        header("Location: ../pages/pagina_privata.php"); // docente
        exit();
    } 
    else if ($result['ruolo'] == 's') {
        header("Location: ../pages/pag_priv2.php"); // studente
        exit();
    } 
    else {
        echo "Ruolo non valido!";
    }

} else {
    echo "Credenziali errate o account non attivato";
    echo '<br><a href="../pages/login.php">Riprova login</a>';
}
?>