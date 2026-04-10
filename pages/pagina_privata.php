<?php 
include "../includes/check_sessione.php"; 
include "../config.php";



if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../css/pag_priv.css">
</head>
<body class="login_f">

<h1>Benvenuto <?= $_SESSION['username'] ?></h1>
<h1>Pagina privata</h1>
<a href="../includes/logout.php">Logout</a>
</body>
</html>
