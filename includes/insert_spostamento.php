<?php
include "../config.php";
session_start();

/* CONTROLLO LOGIN */
if (!isset($_SESSION['id_utente'])) {
    die("Errore: utente non loggato");
}

$id_utente = $_SESSION['id_utente'];

/* DATI FORM */
$data = $_POST['data'];
$id_mezzo = intval($_POST['mezzo']);
$km = floatval($_POST['km']);
$passeggeri = intval($_POST['passeggeri']);

/*CONTROLLO: 1 spostamento al giorno */
$check = "
SELECT v.id
FROM viaggi v
JOIN studenti_viaggi sv ON v.id = sv.id_viaggio
WHERE sv.id_studente = $id_utente
AND v.data = '$data'
";

$res_check = mysqli_query($conn, $check);

if (mysqli_num_rows($res_check) > 0) {
    header("Location: ../pages/pag_priv2.php?error=already");
    exit();
}

/* MEZZO */
$res = mysqli_query($conn, "SELECT nome FROM mezzi WHERE id = $id_mezzo");
$row = mysqli_fetch_assoc($res);

if (!$row) {
    die("Mezzo non valido");
}

$mezzo = strtolower($row['nome']);

/* CO2 */
function getCO2($mezzo) {
    switch ($mezzo) {
        case "auto benzina": return 120;
        case "auto diesel": return 110;
        case "auto ibrida": return 80;
        case "auto elettrica": return 0;
        case "autobus": return 70;
        case "treno": return 40;
        case "scooter": return 90;
        case "bici":
        case "a piedi": return 0;
        default: return 0;
    }
}

$co2 = $km * getCO2($mezzo);

if ($passeggeri > 0) {
    $co2 = $co2 / $passeggeri;
}

/* INSERIMENTO VIAGGIO */
$sql = "
INSERT INTO viaggi (data, distanza_km, passeggeri, co2, id_mezzo)
VALUES ('$data', $km, $passeggeri, $co2, $id_mezzo)
";

if (!mysqli_query($conn, $sql)) {
    die("Errore viaggi: " . mysqli_error($conn));
}

$id_viaggio = mysqli_insert_id($conn);

/* COLLEGAMENTO STUDENTE - VIAGGIO */
$sql2 = "
INSERT INTO studenti_viaggi (id_studente, id_viaggio)
VALUES ($id_utente, $id_viaggio)
";

if (!mysqli_query($conn, $sql2)) {
    die("Errore studenti_viaggi: " . mysqli_error($conn));
}

/* SUCCESSO */
header("Location: ../pages/pag_priv2.php?success=1");
exit();
?>