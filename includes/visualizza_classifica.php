<?php
include "../config.php";
include "../includes/check_sessione.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login.php");
    exit();
}

/* FILTRI */
$mese       = $_POST['mese']       ?? "";
$anno       = $_POST['anno']       ?? "";
$mezzo      = $_POST['mezzo']      ?? "";
$studente   = $_POST['studente']   ?? "";
$classe     = $_POST['classe']     ?? "";
$indirizzo  = $_POST['indirizzo']  ?? "";
$sezione    = $_POST['sezione']    ?? "";
$anno_corso = $_POST['anno_corso'] ?? "";
$scuola     = $_POST['scuola']     ?? "";
$raggruppa  = $_POST['raggruppa']  ?? "studente";
$ordina     = $_POST['ordina']     ?? "co2_asc";
$limite     = $_POST['limite']     ?? "";

/* COLONNA E LABEL in base al raggruppamento */
switch ($raggruppa) {
    case "classe":
        $select_group  = "CONCAT(c.anno, s.nome, ' ', i.nome) AS etichetta";
        $group_by      = "c.id";
        $header        = "Classe";
        break;
    case "indirizzo":
        $select_group  = "i.nome AS etichetta";
        $group_by      = "i.id";
        $header        = "Indirizzo";
        break;
    case "sezione":
        $select_group  = "s.nome AS etichetta";
        $group_by      = "s.id";
        $header        = "Sezione";
        break;
    case "anno":
        $select_group  = "c.anno AS etichetta";
        $group_by      = "c.anno";
        $header        = "Anno di corso";
        break;
    case "scuola":
        $select_group  = "sc.nome AS etichetta";
        $group_by      = "sc.id";
        $header        = "Scuola";
        break;
    case "mezzo":
        $select_group  = "m.nome AS etichetta";
        $group_by      = "m.id";
        $header        = "Mezzo";
        break;
    default: // studente
        $select_group  = "u.username AS etichetta";
        $group_by      = "u.id";
        $header        = "Studente";
        break;
}

/* ORDINAMENTO */
switch ($ordina) {
    case "co2_desc":   $order = "co2_totale DESC";  break;
    case "km_desc":    $order = "km_totali DESC";   break;
    case "km_asc":     $order = "km_totali ASC";    break;
    case "viaggi_desc":$order = "n_viaggi DESC";    break;
    default:           $order = "co2_totale ASC";   break;
}

/* QUERY */
$query = "
SELECT
    $select_group,
    ROUND(SUM(t.co2), 2)          AS co2_totale,
    ROUND(SUM(t.distanza_km), 2)  AS km_totali,
    COUNT(DISTINCT v.id)          AS n_viaggi
FROM utenti u
LEFT JOIN studenti_viaggi sv ON sv.id_studente = u.id
LEFT JOIN viaggi v           ON v.id = sv.id_viaggio
LEFT JOIN tratte t           ON t.id_viaggio = v.id
LEFT JOIN classi c           ON c.id = u.id_classe
LEFT JOIN sezioni s          ON s.id = c.id_sezione
LEFT JOIN indirizzi i        ON i.id = c.id_indirizzo
LEFT JOIN scuole sc          ON sc.id = c.id_scuola
LEFT JOIN mezzi m            ON m.id = t.id_mezzo
WHERE u.ruolo = 's'
";

if ($mese != "")       $query .= " AND MONTH(v.data) = " . intval($mese);
if ($anno != "")       $query .= " AND YEAR(v.data) = "  . intval($anno);
if ($mezzo != "")      $query .= " AND t.id_mezzo = "    . intval($mezzo);
if ($studente != "")   $query .= " AND u.id = "          . intval($studente);
if ($classe != "")     $query .= " AND c.id = "          . intval($classe);
if ($indirizzo != "")  $query .= " AND i.id = "          . intval($indirizzo);
if ($sezione != "")    $query .= " AND s.id = "          . intval($sezione);
if ($anno_corso != "") $query .= " AND c.anno = "        . intval($anno_corso);
if ($scuola != "")     $query .= " AND sc.id = "         . intval($scuola);

$query .= " GROUP BY $group_by ORDER BY $order";

if ($limite != "") $query .= " LIMIT " . intval($limite);

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Errore query: " . mysqli_error($conn));
}

/* LABEL ordinamento per la UI */
$ordina_label = match($ordina) {
    "co2_desc"    => "CO₂ decrescente",
    "km_desc"     => "Km percorsi (più alto)",
    "km_asc"      => "Km percorsi (più basso)",
    "viaggi_desc" => "N° viaggi",
    default       => "CO₂ crescente",
};
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
        <p style="color: #666; font-size: 14px; margin-bottom: 16px;">
            Raggruppato per: <strong><?= htmlspecialchars($header) ?></strong>
            &nbsp;·&nbsp; Ordinato per: <strong><?= $ordina_label ?></strong>
            <?= $limite ? " &nbsp;·&nbsp; Top <strong>$limite</strong>" : "" ?>
        </p>

        <table>
            <tr>
                <th>#</th>
                <th><?= $header ?></th>
                <th>CO₂ totale (g)</th>
                <th>Km totali</th>
                <th>N° viaggi</th>
            </tr>

            <?php $pos = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $pos++ ?></td>
                    <td><?= htmlspecialchars($row['etichetta'] ?? '—') ?></td>
                    <td><?= $row['co2_totale'] ?? 0 ?></td>
                    <td><?= $row['km_totali']  ?? 0 ?></td>
                    <td><?= $row['n_viaggi']   ?? 0 ?></td>
                </tr>
            <?php endwhile; ?>

        </table>

    </div>
</div>

</body>
</html>