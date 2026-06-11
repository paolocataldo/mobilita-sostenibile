<?php
include "../config.php";
session_start();

if (!isset($_SESSION['id_utente'])) {
    die("Non loggato");
}

$id_utente = intval($_SESSION['id_utente']);

$data = $_POST['data'] ?? null;

if ($data !== date('Y-m-d')) {
    header("Location: ../pages/pag_priv2.php?error=data");
    exit();
}

$tratte = $_POST['tratte'] ?? [];

if (!$data || empty($tratte)) {
    die("Dati mancanti");
}

// Controlla se l'utente ha già inserito un viaggio oggi
$check = mysqli_query($conn, "
    SELECT v.id 
    FROM viaggi v
    JOIN studenti_viaggi sv ON sv.id_viaggio = v.id
    WHERE sv.id_studente = $id_utente 
    AND v.data = '$data'
    LIMIT 1
");

if (mysqli_num_rows($check) > 0) {
    header("Location: ../pages/pag_priv2.php?error=already");
    exit();
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
        case "moto": return 100;
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

        $res = mysqli_query($conn, "SELECT nome FROM mezzi WHERE id=$id_mezzo");
        $row = mysqli_fetch_assoc($res);
        if (!$row) continue;

        $mezzo = strtolower($row['nome']);
        $co2_per_km = getCO2($mezzo);

        $riempimento_bus   = null;
        $riempimento_treno = null;
        $passeggeri        = 1;

        if ($id_mezzo === 15) { // Autobus
            $riempimento_bus = $t['riempimento'] ?? 'medio';
            // Passeggeri stimati per divisione CO2
            $passeggeri = match($riempimento_bus) {
                'vuoto' => 5,
                'poco'  => 15,
                'medio' => 30,
                'tanto' => 60,
                default => 30,
            };
            $riempimento_bus = mysqli_real_escape_string($conn, $riempimento_bus);

        } elseif ($id_mezzo === 16) { // Treno
            $riempimento_treno = $t['riempimento'] ?? 'medio';
            $passeggeri = match($riempimento_treno) {
                'vuoto' => 50,
                'medio' => 300,
                'pieno' => 600,
                default => 300,
            };
            $riempimento_treno = mysqli_real_escape_string($conn, $riempimento_treno);

        } else {
            $passeggeri = intval($t['passeggeri'] ?? 1);
        }

        // CO2 totale divisa per i passeggeri stimati
        $co2 = ($km * $co2_per_km) / max(1, $passeggeri);

        $col_riemp_bus   = $riempimento_bus   ? "'$riempimento_bus'"   : 'NULL';
        $col_riemp_treno = $riempimento_treno ? "'$riempimento_treno'" : 'NULL';

        mysqli_query($conn, "
            INSERT INTO tratte
                (data, distanza_km, passeggeri, co2, id_mezzo, riempimento_bus, riempimento_treno, id_viaggio)
            VALUES
                ('$data', $km, $passeggeri, $co2, $id_mezzo, $col_riemp_bus, $col_riemp_treno, $id_viaggio)
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