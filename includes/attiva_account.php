<?php
include "../config.php";

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM utenti
        WHERE account_activation_hash = '$token_hash'";

$query = mysqli_query($conn, $sql);

$result = mysqli_fetch_assoc($query);

if(!$result){
    die("Token non trovato");
}

$sql = "UPDATE utenti
        SET account_activation_hash = NULL
        WHERE account_activation_hash = '$token_hash'";

$query = mysqli_query($conn, $sql);
if (!$query) {
    die("Errore UPDATE: " . mysqli_error($conn));
}

echo "Account attivato.";
?>