<?php
include "../config.php";

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM utenti
        WHERE reset_token_hash = '$token_hash'";

$query = mysqli_query($conn, $sql);

$result = mysqli_fetch_assoc($query);

if(!$result){
    die("Token non trovato");
}

if (strtotime($result["reset_token_expires_at"]) <= time()){
    die("Token scaduto");
}

$password_hash = md5($_POST["password"]);

$sql = "UPDATE utenti
        SET password = '$password_hash',
        reset_token_hash = NULL,
        reset_token_expires_at = NULL
        WHERE reset_token_hash = '$token_hash'";
$query = mysqli_query($conn, $sql);
echo "Password aggiornata. Ora puoi loggarti."
?>