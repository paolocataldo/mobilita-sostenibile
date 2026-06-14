<?php
include "../config.php";

$tipo = $_GET['tipo'] ?? '';
$studente = $_GET['studente'] ?? '';
$classe = $_GET['classe'] ?? '';


$labels = [];
$data = [];

switch ($tipo) {

    case "mezzi":
        $sql = "
            SELECT mezzi.nome,
                   COUNT(*) AS totale
            FROM tratte
            JOIN mezzi ON tratte.id_mezzo = mezzi.id
            GROUP BY mezzi.nome
        ";
        break;

    case "impatto":
        $sql = "
            SELECT mezzi.nome,
                   SUM(tratte.co2) AS totale
            FROM tratte
            JOIN mezzi ON tratte.id_mezzo = mezzi.id
            GROUP BY mezzi.nome
        ";
        break;

    case "classi":
        $sql = "
            SELECT CONCAT(c.anno, s.nome, ' ', i.nome) AS classe,
                   SUM(t.co2) AS totale
            FROM tratte t
            JOIN viaggi v ON t.id_viaggio = v.id
            JOIN studenti_viaggi sv ON sv.id_viaggio = v.id
            JOIN utenti u ON u.id = sv.id_studente
            JOIN classi c ON u.id_classe = c.id
            JOIN sezioni s ON c.id_sezione = s.id
            JOIN indirizzi i ON c.id_indirizzo = i.id
            GROUP BY c.id
        ";
        break;

    case "studenti":
        $sql = "
            SELECT u.username,
                   SUM(t.co2) AS totale
            FROM tratte t
            JOIN viaggi v ON t.id_viaggio = v.id
            JOIN studenti_viaggi sv ON sv.id_viaggio = v.id
            JOIN utenti u ON u.id = sv.id_studente
            GROUP BY u.id
        ";
        break;

    default:
        echo json_encode(["labels" => [], "data" => []]);
        exit;
}

$query = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row[array_keys($row)[0]];
    $data[] = $row['totale'];
}

echo json_encode([
    "labels" => $labels,
    "data" => $data
]);
