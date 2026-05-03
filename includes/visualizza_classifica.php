<?php
include "../config.php";
include "../includes/check_sessione.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login.php");
    exit();
}

/* FILTRI */
$mese = $_POST['mese'] ?? "";
$anno = $_POST['anno'] ?? "";
$mezzo = $_POST['mezzo'] ?? "";
$studente = $_POST['studente'] ?? "";
$classe = $_POST['classe'] ?? "";

/* QUERY BASE CORRETTA */
$query = "
SELECT 
    u.username,
    SUM(v.distanza_km * m.co2_per_km) AS co2_totale
FROM utenti u
LEFT JOIN studenti_viaggi sv ON sv.id_studente = u.id
LEFT JOIN viaggi v ON v.id = sv.id_viaggio
LEFT JOIN mezzi m ON m.id = v.id_mezzo
LEFT JOIN classi c ON c.id = u.id_classe
WHERE 1
";

if ($mese != "") {
    $query .= " AND MONTH(v.data) = $mese";
}

if ($anno != "") {
    $query .= " AND YEAR(v.data) = $anno";
}

if ($mezzo != "") {
    $query .= " AND v.id_mezzo = $mezzo";
}

if ($studente != "") {
    $query .= " AND u.id = $studente";
}

if ($classe != "") {
    $query .= " AND c.id = $classe";
}

/* GROUP BY + ORDER */
$query .= "
GROUP BY u.id
ORDER BY co2_totale ASC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Errore query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/pagina_privata.css">
</head>

<body class="private_page">

<div class="top_bar">
    <h1>Classifica CO₂</h1>
    <a href="../pages/pagina_privata.php" class="logout_btn">Indietro</a>
</div>

<div class="container">

    <div class="main_card">

        <h2>Risultati classifica</h2>

        <table>
            <tr>
                <th>Studente</th>
                <th>CO₂ totale (g)</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['username'] ?></td>
                    <td><?= round($row['co2_totale'], 2) ?></td>
                </tr>
            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>