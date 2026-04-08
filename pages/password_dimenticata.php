<!DOCTYPE html>
<html>
<head>
    <title>Password Dimenticata</title>
    <link rel="stylesheet" href="../css/password_dimenticata.css">
</head>
</html>
<body>
    <h1>Password Dimenticata</h1>
    <form action = "../includes/manda_password_reset.php" method="POST">
        <label for="email">email</label>
        <input type="email" name="email" id="email">
        <button>Manda</button>
    </form>
</body>