<?php 
include "../includes/check_sessione.php"; 
include "../config.php";


$username = $_SESSION['username'];
?>
<h1>Benvenuto <?= $_SESSION['username'] ?></h1>
<h1>Pagina privata</h1>
<a href="logout.php">Logout</a>