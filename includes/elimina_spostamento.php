<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username']) || $_SESSION['ruolo'] != 'a') {
    header("Location: ../index.php");
    exit();
}

$id_tratta = intval($_GET['id'] ?? 0);

if ($id_tratta > 0) {

    // Recupera l'id_viaggio della tratta
    $res = mysqli_query($conn, "SELECT id_viaggio FROM tratte WHERE id = $id_tratta");
    $tratta = mysqli_fetch_assoc($res);

    if ($tratta) {
        $id_viaggio = intval($tratta['id_viaggio']);

        // Elimina la tratta
        mysqli_query($conn, "DELETE FROM tratte WHERE id = $id_tratta");

        // Controlla se il viaggio ha ancora tratte
        $res2 = mysqli_query($conn, "SELECT COUNT(*) AS n FROM tratte WHERE id_viaggio = $id_viaggio");
        $rimaste = mysqli_fetch_assoc($res2);

        if ($rimaste['n'] == 0) {
            // Elimina il viaggio (CASCADE elimina automaticamente studenti_viaggi e tratte rimaste)
            mysqli_query($conn, "DELETE FROM viaggi WHERE id = $id_viaggio");
        }
    }
}

header("Location: ../pages/pagina_privata_admin.php?success=delete_trip");
exit();