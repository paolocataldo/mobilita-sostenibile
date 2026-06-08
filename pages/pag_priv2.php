<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$mezzi = mysqli_query($conn, "SELECT id, nome FROM mezzi");

$mezzi_arr = [];
while ($row = mysqli_fetch_assoc($mezzi)) {
    $mezzi_arr[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/pag_priv2.css">
    <script>
        const mezziOptions = <?= json_encode($mezzi_arr) ?>;
    </script>
</head>

<body class="private_page">

<div class="top_bar">
    <h1>Benvenuto <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <div style="display:flex; gap:12px;">
        <a href="profilo.php" class="logout_btn">Il mio profilo</a>
        <a href="../includes/logout.php" class="logout_btn">Logout</a>
    </div>
</div>

<div class="container">
    <div class="main_card">

        <h2>Inserisci spostamento giornaliero</h2>

        <form action="../includes/insert_spostamento.php" method="POST">

    <div class="field">
        <label>Data</label>
        <input type="date" name="data" required
            min="<?= date('Y-m-d') ?>"
            max="<?= date('Y-m-d') ?>"
            value="<?= date('Y-m-d') ?>">
    </div>

    <h3>Tratte</h3>

    <div id="tratteContainer">
        <div class="tratta">
            <div class="field">
                <label>Mezzo</label>
                <select name="tratte[0][mezzo]" class="mezzo-select" required onchange="aggiornaCampiTratta(this)">
                    <?php foreach ($mezzi_arr as $row): ?>
                        <option value="<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row-2">
                <div class="field">
                    <label>Km</label>
                    <input type="number" name="tratte[0][km]" step="0.1" min="0.1" required>
                </div>
                <div class="field passeggeri-field">
                    <label>Passeggeri</label>
                    <input type="number" name="tratte[0][passeggeri]" min="1" value="1">
                </div>
                <div class="field riempimento-field" style="display:none">
                    <label>Riempimento</label>
                    <select name="tratte[0][riempimento]">
                        <option value="vuoto">Vuoto</option>
                        <option value="poco">Poco</option>
                        <option value="medio" selected>Medio</option>
                        <option value="tanto">Tanto</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="addTratta">+ Aggiungi tratta</button>
    <button type="submit">Salva</button>

</form>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'data'): ?>
            <p class="msg error">Puoi inserire solo spostamenti di oggi.</p>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <p class="msg success">Spostamento salvato con successo!</p>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'already'): ?>
            <p class="msg error">Hai già inserito uno spostamento per oggi.</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="msg error">Errore nel salvataggio dello spostamento.</p>
        <?php endif; ?>
        

    </div>
</div>

<script src="../js/tratte.js"></script>
</body>
</html>