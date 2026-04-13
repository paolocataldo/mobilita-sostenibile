<?php
include "../includes/check_sessione.php";
include "../config.php";



if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/pag_priv2.css">
</head>

<body class="private_page">

    <div class="top_bar">
        <h1>Benvenuto <?= $_SESSION['username'] ?></h1>
        <a href="../includes/logout.php" class="logout_btn">Logout</a>
    </div>

    <div class="container">

        <!-- BOX PRINCIPALE: INSERIMENTO SPOSTAMENTO -->
        <div class="main_card">

            <h2>Inserisci spostamento giornaliero</h2>

            <form action="../includes/insert_spostamento.php" method="POST">

                <label for="data">Data</label>
                <input type="date" name="data" id="data" required>

               <!-- <label for="scuola">Scuola</label>
                <input type="text" name="scuola" id="scuola" placeholder="Es: ITIS Avogadro" required>

                <label for="classe">Classe</label>
                <input type="text" name="classe" id="classe" placeholder="Es: 4A INF" required>
            --->
                <label for="mezzo">Mezzo di trasporto</label>
                <select name="mezzo" id="mezzo" required>
                    <option value="auto">Auto</option>
                    <option value="bici">Bici</option>
                    <option value="mezzi">Trasporto pubblico</option>
                    <option value="a piedi">A piedi</option>
                </select>

                <label for="tipo_veicolo">Tipo di veicolo</label>
                <select name="tipo_veicolo" id="tipo_veicolo" required>
                    <option value="benzina">Benzina</option>
                    <option value="diesel">Diesel</option>
                    <option value="ibrido">Ibrido</option>
                    <option value="elettrico">Elettrico</option>
                    <option value="nessuno">Nessuno</option>
                </select>

                <label for="km">Distanza (km)</label>
                <input type="number" name="km" id="km" min="0" step="0.1" required>

                <label for="passeggeri">Numero passeggeri</label>
                <input type="number" name="passeggeri" id="passeggeri" min="1" step="1" required>

                <button type="submit">Salva spostamento</button>

            </form>

        </div>

    </div>

</body>

</html>