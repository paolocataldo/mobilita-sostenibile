<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/registrazione.css">
    <script src="../js/registrazione_script.js"></script>
</head>

<body>
    <div class="registrazione_form">
        <form action="registrazione_utente.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required><br><br>
            <label for="email">Email</label>
            <input type="email" name="email" pattern="[a-z0-9._%+\-]+@studenti\.itisavogadro\.it$" required><br><br> <!-- Sono valide solo le email istituzionali -->
            <label for="conferma_email">Conferma Email</label>
            <input type="email" name="email" pattern="[a-z0-9._%+\-]+@studenti\.itisavogadro\.it$" required><br><br>
            <label for="password">Password</label>
            <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required><br><br>
            <label for="conferma_password">Conferma Password</label>
            <input type="password" name="conferma_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br><br>
            <input type="submit" value="Registrati">
        </form>
    </div>
</body>

</html>