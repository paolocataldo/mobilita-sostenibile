<?php
$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = '';
$dbname = $_ENV['DB_NAME'];

$conn = mysqli_connect($host, $user, $pass, $dbname);

if(!$conn){
    die("Connessione fallita: " . mysqli_connect_error());
}
?>