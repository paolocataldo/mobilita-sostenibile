<?php

include "../config.php";
include "check_sessione.php";

/* SOLO ADMIN */
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] != 'a') {
    header("Location: ../index.php");
    exit();
}

/* ID UTENTE */
if (!isset($_GET['id'])) {
    header("Location: ../pages/pagina_privata_admin.php?error=id");
    exit();
}

$id = (int) $_GET['id'];

/* NON PERMETTERE DI CANCELLARE SE STESSO */
if ($_SESSION['id'] == $id) {
    header("Location: ../pages/pagina_privata_admin.php?error=self");
    exit();
}

/* 1. ELIMINA RELAZIONI CON VIAGGI */
mysqli_query(
    $conn,
    "DELETE FROM studenti_viaggi
     WHERE id_studente = $id"
);

/* 2. ELIMINA UTENTE */
$result = mysqli_query(
    $conn,
    "DELETE FROM utenti
     WHERE id = $id"
);

/* RISULTATO */
if ($result) {
    header("Location: ../pages/pagina_privata_admin.php?success=delete_user");
} else {
    header("Location: ../pages/pagina_privata_admin.php?error=db");
}

exit();

?>