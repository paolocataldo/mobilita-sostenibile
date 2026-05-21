<!DOCTYPE html>
<html>
<head>
    <title>Password Dimenticata</title>
    <link rel="stylesheet" href="../css/password_dimenticata.css">
</head>

<body class="forgot_page">

    <h1>Password Dimenticata</h1>

    <p class="subtitle">
        Inserisci l’indirizzo email associato al tuo account per reimpostare la password.
    </p>

    <form action="../includes/manda_password_reset.php" method="POST">
        
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <button type="submit">Invia</button>

    </form>

</body>
</html>