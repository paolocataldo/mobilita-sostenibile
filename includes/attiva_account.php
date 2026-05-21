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
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Attivazione account</title>
    <link rel="stylesheet" href="../css/attiva_account.css">
</head>
<body class="activation_page">

    <h1>Account Attivato</h1>

    <div class="activation_box">

        <p>
            Il tuo account è stato attivato correttamente.
        </p>

        <a href="../pages/login.php" id="login">
            Torna al login
        </a>

    </div>

</body>
</html>