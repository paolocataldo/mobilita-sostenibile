<?php
include "../config.php";

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM utenti
        WHERE reset_token_hash = '$token_hash'";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);

$messaggio = "";

if(!$result){
    $messaggio = "Token non trovato";
} elseif (strtotime($result["reset_token_expires_at"]) <= time()){
    $messaggio = "Token scaduto";
} else {

    $password_hash = md5($_POST["password"]);

    $sql = "UPDATE utenti
            SET password = '$password_hash',
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
            WHERE reset_token_hash = '$token_hash'";

    mysqli_query($conn, $sql);

    $messaggio = "Password aggiornata. Ora puoi accedere.";
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Password aggiornata</title>
    <link rel="stylesheet" href="../css/process_reset_password.css">
</head>

<body class="success_page">

    <h1>Password aggiornata</h1>

    <div class="success_box">

        <p><?php echo $messaggio; ?></p>

        <a href="../pages/login.php" class="btn">
            Vai al login
        </a>

    </div>

</body>

</html>