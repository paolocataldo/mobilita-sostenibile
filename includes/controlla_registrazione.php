<?php

include "../config.php";

$response = [
    "username" => "",
    "email" => ""
];

if(isset($_POST['username'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $sql = "SELECT id FROM utenti WHERE username = '$username'";

    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) > 0) {
        $response['username'] = "Username già utilizzato";
    }
}

if(isset($_POST['email'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT id FROM utenti WHERE email = '$email'";

    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) > 0) {
        $response['email'] = "Email già registrata";
    }
}

echo json_encode($response);
?>