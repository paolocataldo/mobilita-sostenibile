<?php
<<<<<<< HEAD

=======
>>>>>>> 1575d80c80653a7b803a0cbc105f233c068255e3
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
    } 

    $result = mysqli_fetch_assoc($query);

    if($result){
<<<<<<< HEAD
        echo "Login effettuato con successo!";
        header("Location: ../pages/pagina_privata.php");
=======
        header("Location: ../pages/pagina_privata.php");
        exit(); // Ferma lo script dopo il redirect
>>>>>>> 1575d80c80653a7b803a0cbc105f233c068255e3
    } else{
        echo "Credenziali errate!";
        echo '<br><a href="../pages/login.php">Riprova login</a>';
    }
} else {
    echo "Compila tutti i campi!";
    echo '<br><a href="../pages/login.php">Torna al login</a>';
}
