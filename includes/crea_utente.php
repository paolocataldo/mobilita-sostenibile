<?php

include "../config.php";
include "check_sessione.php";

/* SOLO ADMIN */
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] != 'a') {
    header("Location: ../index.php");
    exit();
}

/* CONTROLLO INVIO FORM */
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../pages/pagina_privata_admin.php");
    exit();
}

/* DATI */
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$ruolo = $_POST['ruolo'];

$id_classe = !empty($_POST['classe'])
    ? (int)$_POST['classe']
    : NULL;

/* CONTROLLI */
if (
    empty($username) ||
    empty($email) ||
    empty($password) ||
    empty($ruolo)
) {
    header("Location: ../pages/pagina_privata_admin.php?error=dati");
    exit();
}

/* VERIFICA USERNAME */
$check_username = mysqli_query(
    $conn,
    "SELECT id
     FROM utenti
     WHERE username = '$username'"
);

if (mysqli_num_rows($check_username) > 0) {

    header("Location: ../pages/pagina_privata_admin.php?error=username");

    exit();
}

/* VERIFICA EMAIL */
$check_email = mysqli_query(
    $conn,
    "SELECT id
     FROM utenti
     WHERE email = '$email'"
);

if (mysqli_num_rows($check_email) > 0) {

    header("Location: ../pages/pagina_privata_admin.php?error=email");

    exit();
}

/* PASSWORD */
$password_md5 = md5($password);

/* QUERY */
if ($id_classe === NULL) {

    $sql = "
        INSERT INTO utenti
        (
            username,
            email,
            password,
            ruolo
        )
        VALUES
        (
            '$username',
            '$email',
            '$password_md5',
            '$ruolo'
        )
    ";

} else {

    $sql = "
        INSERT INTO utenti
        (
            username,
            email,
            password,
            ruolo,
            id_classe
        )
        VALUES
        (
            '$username',
            '$email',
            '$password_md5',
            '$ruolo',
            $id_classe
        )
    ";
}

$result = mysqli_query($conn, $sql);

/* RISULTATO */
if ($result) {

    header("Location: ../pages/pagina_privata_admin.php?success=user");

} else {

    header("Location: ../pages/pagina_privata_admin.php?error=db");

}

exit();

?>