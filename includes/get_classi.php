<?php
include "../config.php";

if (isset($_GET['scuola_id'])) {

    $scuola_id = intval($_GET['scuola_id']);

    $sql = "SELECT 
                classi.id,
                sezioni.nome AS sezione,
                indirizzi.nome AS indirizzo
            FROM classi
            JOIN sezioni ON classi.id_sezione = sezioni.id
            JOIN indirizzi ON classi.id_indirizzo = indirizzi.id
            WHERE classi.id_scuola = $scuola_id";

    $result = mysqli_query($conn, $sql);

    echo "<option value=''>Seleziona classe</option>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['id']}'>
                {$row['indirizzo']} {$row['sezione']}
              </option>";
    }
}
?>  