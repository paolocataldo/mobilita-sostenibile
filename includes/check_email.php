<?php
include "../config.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);

$sql = "SELECT id FROM utenti WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "exists";
} else {
    echo "ok";
}