<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id_utente = intval($_SESSION['id_utente']);

// CO2 totale dello studente
$co2_totale = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(t.co2) AS totale
    FROM tratte t
    JOIN viaggi v ON t.id_viaggio = v.id
    JOIN studenti_viaggi sv ON sv.id_viaggio = v.id
    WHERE sv.id_studente = $id_utente
"));

// Spostamenti raggruppati per viaggio
$viaggi = mysqli_query($conn, "
    SELECT
        v.id,
        v.data,
        SUM(t.co2) AS co2_viaggio,
        SUM(t.distanza_km) AS km_totali
    FROM viaggi v
    JOIN studenti_viaggi sv ON sv.id_viaggio = v.id
    JOIN tratte t ON t.id_viaggio = v.id
    WHERE sv.id_studente = $id_utente
    GROUP BY v.id, v.data
    ORDER BY v.data DESC
");

// Tratte per ogni viaggio
$tratte_query = mysqli_query($conn, "
    SELECT
        t.id,
        t.id_viaggio,
        t.distanza_km,
        t.passeggeri,
        t.co2,
        m.nome AS mezzo
    FROM tratte t
    JOIN viaggi v ON t.id_viaggio = v.id
    JOIN studenti_viaggi sv ON sv.id_viaggio = v.id
    JOIN mezzi m ON t.id_mezzo = m.id
    WHERE sv.id_studente = $id_utente
    ORDER BY t.id_viaggio, t.id
");

// Raggruppa le tratte per id_viaggio in un array PHP
$tratte_per_viaggio = [];
while ($t = mysqli_fetch_assoc($tratte_query)) {
    $tratte_per_viaggio[$t['id_viaggio']][] = $t;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Il mio profilo</title>
    <link rel="stylesheet" href="../css/profilo.css">
</head>

<body class="private_page">

<div class="top_bar">
    <h1>Profilo di <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <a href="pag_priv2.php" class="logout_btn">Indietro</a>
</div>

<div class="container">

    <!-- CO2 TOTALE -->
    <div class="stat_card">
        <h2>La tua CO₂ totale</h2>
        <p class="co2_big"><?= round($co2_totale['totale'] ?? 0, 2) ?> g</p>
    </div>

    <!-- SPOSTAMENTI -->
    <div class="main_card">

        <h2>I tuoi spostamenti</h2>

        <?php if (mysqli_num_rows($viaggi) == 0): ?>
            <p>Nessuno spostamento inserito.</p>
        <?php endif; ?>

        <?php while ($v = mysqli_fetch_assoc($viaggi)): ?>

            <div class="viaggio_card">

                <div class="viaggio_header">
                    <span class="viaggio_data">
                        <?= date('d/m/Y', strtotime($v['data'])) ?>
                    </span>
                    <span class="viaggio_co2">
                        CO₂: <?= round($v['co2_viaggio'], 2) ?> g
                    </span>
                    <span class="viaggio_km">
                        Totale: <?= round($v['km_totali'], 1) ?> km
                    </span>
                </div>

                <table>
                    <tr>
                        <th>Mezzo</th>
                        <th>Km</th>
                        <th>Passeggeri</th>
                        <th>CO₂</th>
                    </tr>
                    <?php foreach ($tratte_per_viaggio[$v['id']] as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['mezzo']) ?></td>
                            <td><?= $t['distanza_km'] ?></td>
                            <td><?= $t['passeggeri'] ?></td>
                            <td><?= round($t['co2'], 2) ?> g</td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </div>

        <?php endwhile; ?>

    </div>

</div>

</body>
</html>