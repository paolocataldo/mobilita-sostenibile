<?php
include "../config.php";

$tipo = $_GET['tipo'];

if ($tipo == "mezzi") {

    $sql = "
        SELECT mezzi.nome,
               COUNT(*) AS totale
        FROM tratte
        JOIN mezzi ON tratte.id_mezzo = mezzi.id
        GROUP BY mezzi.nome
    ";

    $query = mysqli_query($conn, $sql);

    $labels = [];
    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $labels[] = $row['nome'];
        $data[] = $row['totale'];
    }

    echo json_encode([
        "labels" => $labels,
        "data" => $data
    ]);

} elseif ($tipo == "impatto") {

    $sql = "
        SELECT mezzi.nome,
               SUM(tratte.co2) AS totale
        FROM tratte
        JOIN mezzi ON tratte.id_mezzo = mezzi.id
        GROUP BY mezzi.nome
    ";

    $query = mysqli_query($conn, $sql);

    $labels = [];
    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $labels[] = $row['nome'];
        $data[] = $row['totale'];
    }

    echo json_encode([
        "labels" => $labels,
        "data" => $data
    ]);
}
?>