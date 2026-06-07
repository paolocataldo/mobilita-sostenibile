<?php
include "../config.php";
session_start();

if (!isset($_SESSION['id_utente'])) {
    die("Non loggato");
}

$id_utente = intval($_SESSION['id_utente']);

$data = $_POST['data'] ?? null;

// Aggiungi subito dopo
if ($data !== date('Y-m-d')) {
    header("Location: ../pages/pag_priv2.php?error=data");
    exit();
}
$tratte = $_POST['tratte'] ?? [];

if (!$data || empty($tratte)) {
    die("Dati mancanti");
}

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
        case "a piedi":
            return 0;
        default:
            return 0;
    }
}

$conn->begin_transaction();

try {

    // 1. CREA VIAGGIO
    mysqli_query($conn, "INSERT INTO viaggi (data) VALUES ('$data')");
    $id_viaggio = mysqli_insert_id($conn);

    // 2. STUDENTI
    mysqli_query($conn,
        "INSERT INTO studenti_viaggi VALUES ($id_utente, $id_viaggio)"
    );


    // 3. TRATTE
    foreach ($tratte as $t) {

        $id_mezzo = intval($t['mezzo']);
        $km = floatval($t['km']);
        $passeggeri = intval($t['passeggeri'] ?? 1);

        $res = mysqli_query($conn, "SELECT nome FROM mezzi WHERE id=$id_mezzo");
        $row = mysqli_fetch_assoc($res);

        if (!$row) continue;

        $mezzo = strtolower($row['nome']);
        $co2 = $km * getCO2($mezzo);

        if ($passeggeri > 1 && !in_array($id_mezzo, [15,16])) {
            $co2 = $co2 / $passeggeri;
        }

        mysqli_query($conn, "
            INSERT INTO tratte
            (data, distanza_km, passeggeri, co2, id_mezzo, id_viaggio)
            VALUES
            ('$data', $km, $passeggeri, $co2, $id_mezzo, $id_viaggio)
        ");
    }

    $conn->commit();

    header("Location: ../pages/pag_priv2.php?success=1");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    die("Errore: " . $e->getMessage());
}
?>

