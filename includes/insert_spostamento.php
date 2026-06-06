<?php
include "../config.php";
session_start();

if (!isset($_SESSION['id_utente'])) {
    die("Non loggato");
}

$id_utente = intval($_SESSION['id_utente']);

/* INPUT */
$data = $_POST['data'] ?? null;
$id_mezzo = intval($_POST['mezzo'] ?? 0);
$km = floatval($_POST['km'] ?? 0);

$passeggeri = intval($_POST['passeggeri'] ?? 1);

$viaggio_condiviso = isset($_POST['viaggio_condiviso']);
$utente_condiviso = trim($_POST['utente_condiviso'] ?? '');

$riempimento_bus = $_POST['riempimento_bus'] ?? null;
$riempimento_treno = $_POST['riempimento_treno'] ?? null;

/* CHECK */
if (!$data) die("Data mancante");
if ($id_mezzo <= 0) die("Mezzo non valido");

/* MEZZO */
$res = mysqli_query($conn, "SELECT nome FROM mezzi WHERE id = $id_mezzo");
$row = mysqli_fetch_assoc($res);

if (!$row) die("Mezzo non trovato");

$mezzo = strtolower(trim($row['nome']));

/* COMPAGNO */
$id_compagno = null;

if ($viaggio_condiviso && $utente_condiviso != '') {

    $username = mysqli_real_escape_string($conn, $utente_condiviso);

    $resU = mysqli_query($conn,
        "SELECT id FROM utenti WHERE username='$username' AND ruolo='s'"
    );

    if (mysqli_num_rows($resU) == 0) {
        die("Utente non trovato");
    }

    $id_compagno = mysqli_fetch_assoc($resU)['id'];

    if ($id_compagno == $id_utente) {
        die("Non puoi condividere con te stesso");
    }
}

/* CO2 */
function getCO2($mezzo, $bus, $treno)
{
    switch ($mezzo) {

        case "auto benzina": return 120;
        case "auto diesel": return 110;
        case "auto ibrida": return 80;
        case "auto elettrica": return 0;

        case "autobus":
            if ($bus == "vuoto") return 120;
            if ($bus == "poco") return 90;
            if ($bus == "medio") return 60;
            if ($bus == "tanto") return 30;
            return 70;

        case "treno":
            if ($treno == "vuoto") return 60;
            if ($treno == "medio") return 40;
            if ($treno == "pieno") return 25;
            return 40;

        case "scooter": return 90;

        case "bici":
        case "a piedi":
            return 0;

        default:
            return 0;
    }
}

$co2 = $km * getCO2($mezzo, $riempimento_bus, $riempimento_treno);

/* PASSEGGERI SOLO PER AUTO/SCOOTER */
if ($id_mezzo != 15 && $id_mezzo != 16) {
    if ($passeggeri > 1) {
        $co2 = $co2 / $passeggeri;
    }
}

/* CONDIVISO */
if ($viaggio_condiviso) {
    $co2 = $co2 / 2;
}

/* FORZA COERENZA */
if ($id_mezzo == 15 || $id_mezzo == 16) {
    $passeggeri = 1;
}

/* INSERT */
$conn->begin_transaction();

try {

    $sql = "
    INSERT INTO viaggi
    (data, distanza_km, passeggeri, co2, id_mezzo, riempimento_bus, riempimento_treno)
    VALUES
    (
        '$data',
        $km,
        $passeggeri,
        $co2,
        $id_mezzo,
        " . ($riempimento_bus ? "'$riempimento_bus'" : "NULL") . ",
        " . ($riempimento_treno ? "'$riempimento_treno'" : "NULL") . "
    )";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception(mysqli_error($conn));
    }

    $id_viaggio = mysqli_insert_id($conn);

    mysqli_query($conn,
        "INSERT INTO studenti_viaggi VALUES ($id_utente, $id_viaggio)"
    );

    if ($id_compagno) {
        mysqli_query($conn,
            "INSERT INTO studenti_viaggi VALUES ($id_compagno, $id_viaggio)"
        );
    }

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    die("Errore: " . $e->getMessage());
}

header("Location: ../pages/pag_priv2.php?success=1");
exit();
?>