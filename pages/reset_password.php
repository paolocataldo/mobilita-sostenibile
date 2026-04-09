<?php
include "../config.php";

$token = $_GET["token"];
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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
        <script src="../js/nuova_password.js"></script>
    </head>
    <body>
        <h1>Reset Password</h1>

        <form method="POST" action="../includes/process_reset_password.php" onsubmit="return nuovaPassword()">
            <input type="hidden" name="token" value="<?=  htmlspecialchars($token) ?>">
            <label for="password">Nuova password</label>
            <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>

            <label for="conferma_password">Conferma password</label>
            <input type="password" id="conferma_password" name="conferma_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
            
            <button>Invia</button>
        </form>
    </body>
</html>