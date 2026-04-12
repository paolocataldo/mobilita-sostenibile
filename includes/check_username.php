<?php
include "../config.php";

$username = mysqli_real_escape_string($conn, $_POST['username']);

$sql = "SELECT id FROM utenti WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "exists";
} else {
    echo "ok";
}