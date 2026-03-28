<?php

include "../config.php";
//fare le funzioni principali: sessione, logout, registrazione
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    $sql = "SELECT id, username, email, password, ruolo";
    $sql .= " FROM utenti";
    $sql .= " WHERE username = '$username' AND password = '$password'";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Errore query: " . mysqli_error($conn));
    } difhoighiso

    $result = mysqli_fetch_assoc($query);

    if($result){
        echo "Login effettuato con successo!";
    } else{
        echo "Credenziali errate!";
        echo '<br><a href="../pages/login.php">Riprova login</a>';
    }
} else {
    echo "Compila tutti i campi!";
    echo '<br><a href="../pages/login.php">Torna al login</a>';
}
