<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/login_script.js"></script>
</head>

<body>
    <div class="login_form">

        <form action="../includes/check_login.php" method="POST">

            <label for="username">Username</label><br>
            <input type="text" name="username" required><br><br>

            <label for="password">Password</label><br>
            <input type="password" name="password" required><br><br>

            <input type="submit" value="Login">

        </form>
        <div class = "links">
            <a href="password_dimenticata.php" id="password_dimenticata">Password dimenticata?</a>
            <a href="registrazione.php" id="link_registrati">Non hai un account? Registrati</a>
        </div>
        

    </div>
</body>

</html>