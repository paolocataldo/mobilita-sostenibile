<?php
session_start();
include "../config.php";
//fare le funzioni principali: sessione, logout, registrazione
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    $sql = "SELECT id, username, email, password, ruolo";
    $sql .= " FROM utenti";
    $sql .= " WHERE username = '$username' AND password = '$password' AND account_activation_hash IS NULL";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Errore query: " . mysqli_error($conn));
    } 

    $result = mysqli_fetch_assoc($query);
    /*var_dump($_SESSION);
exit();*/

    if($result){
        $_SESSION['username'] = $result['username'];
        $_SESSION['LOGGED'] = true;
        // CONTROLLO RUOLO
        if($result['ruolo'] == 'd'){
            header("Location: ../pages/pagina_privata.php"); // professore
            exit();
        } else if($result['ruolo'] == 's'){
            header("Location: ../pages/pag_priv2.php"); // studente
            exit();
        } else {
            echo "Ruolo non valido!";
        }
    } else{
        echo "Credenziali errate, o account non attivato";
        echo '<br><a href="../pages/login.php">Riprova login</a>';
    }
} else {
    echo "Compila tutti i campi!";
    echo '<br><a href="../pages/login.php">Torna al login</a>';
}
