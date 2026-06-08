<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* FILTRI */
$mezzi = mysqli_query($conn, "SELECT id, nome FROM mezzi");
$studenti = mysqli_query($conn, "SELECT id, username FROM utenti WHERE ruolo='s'");

$classi = mysqli_query($conn, "
SELECT c.id,
       c.anno,
       s.nome AS sezione,
       i.nome AS indirizzo
FROM classi c
JOIN sezioni s ON c.id_sezione = s.id
JOIN indirizzi i ON c.id_indirizzo = i.id
");

$indirizzi = mysqli_query($conn, "SELECT id, nome FROM indirizzi");
$sezioni   = mysqli_query($conn, "SELECT id, nome FROM sezioni");
$scuole    = mysqli_query($conn, "SELECT id, nome FROM scuole");
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/pagina_privata.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/grafici.js" defer></script>
</head>

<body class="private_page">

<div class="top_bar">
    <h1>Dashboard di <?= $_SESSION['username'] ?></h1>
    <a href="../includes/logout.php" class="logout_btn">Logout</a>
</div>

<div class="container">

    <div class="main_card">

        <h2>Classifica impatto ambientale</h2>

        <div class="classification_select">

            <form action="../includes/visualizza_classifica.php" method="POST">

                <!-- RAGGRUPPA PER -->
                <div class="field">
                    <label>Raggruppa per</label>
                    <select name="raggruppa">
                        <option value="studente">Studente</option>
                        <option value="classe">Classe</option>
                        <option value="indirizzo">Indirizzo</option>
                        <option value="sezione">Sezione</option>
                        <option value="anno">Anno scolastico</option>
                        <option value="scuola">Scuola</option>
                        <option value="mezzo">Mezzo di trasporto</option>
                    </select>
                </div>

                <hr>

                <!-- FILTRI TEMPORALI -->
                <div class="field">
                    <label>Mese</label>
                    <select name="mese">
                        <option value="">Tutti</option>
                        <option value="1">Gennaio</option>
                        <option value="2">Febbraio</option>
                        <option value="3">Marzo</option>
                        <option value="4">Aprile</option>
                        <option value="5">Maggio</option>
                        <option value="6">Giugno</option>
                        <option value="7">Luglio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Settembre</option>
                        <option value="10">Ottobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Dicembre</option>
                    </select>
                </div>

                <div class="field">
                    <label>Anno</label>
                    <select name="anno">
                        <option value="">Tutti</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>

                <hr>

                <!-- FILTRI SPECIFICI -->
                <div class="field">
                    <label>Mezzo</label>
                    <select name="mezzo">
                        <option value="">Tutti</option>
                        <?php while($m = mysqli_fetch_assoc($mezzi)): ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Studente</label>
                    <select name="studente">
                        <option value="">Tutti</option>
                        <?php while($s = mysqli_fetch_assoc($studenti)): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['username']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Classe</label>
                    <select name="classe">
                        <option value="">Tutte</option>
                        <?php while($c = mysqli_fetch_assoc($classi)): ?>
                            <option value="<?= $c['id'] ?>">
                                <?= $c['anno'] . $c['sezione'] . ' ' . htmlspecialchars($c['indirizzo']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Indirizzo</label>
                    <select name="indirizzo">
                        <option value="">Tutti</option>
                        <?php while($i = mysqli_fetch_assoc($indirizzi)): ?>
                            <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['nome']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Sezione</label>
                    <select name="sezione">
                        <option value="">Tutte</option>
                        <?php while($sez = mysqli_fetch_assoc($sezioni)): ?>
                            <option value="<?= $sez['id'] ?>"><?= htmlspecialchars($sez['nome']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Anno di corso</label>
                    <select name="anno_corso">
                        <option value="">Tutti</option>
                        <option value="1">1°</option>
                        <option value="2">2°</option>
                        <option value="3">3°</option>
                        <option value="4">4°</option>
                        <option value="5">5°</option>
                    </select>
                </div>

                <div class="field">
                    <label>Scuola</label>
                    <select name="scuola">
                        <option value="">Tutte</option>
                        <?php while($sc = mysqli_fetch_assoc($scuole)): ?>
                            <option value="<?= $sc['id'] ?>"><?= htmlspecialchars($sc['nome']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <hr>

                <!-- ORDINAMENTO -->
                <div class="field">
                    <label>Ordina per</label>
                    <select name="ordina">
                        <option value="co2_asc">CO₂ crescente (più virtuosi)</option>
                        <option value="co2_desc">CO₂ decrescente (più inquinanti)</option>
                        <option value="km_desc">Km percorsi (più alto)</option>
                        <option value="km_asc">Km percorsi (più basso)</option>
                        <option value="viaggi_desc">N° viaggi (più alto)</option>
                    </select>
                </div>

                <div class="field">
                    <label>Mostra top</label>
                    <select name="limite">
                        <option value="">Tutti</option>
                        <option value="5">Top 5</option>
                        <option value="10">Top 10</option>
                        <option value="20">Top 20</option>
                    </select>
                </div>

                <button type="submit">Visualizza Classifica</button>

            </form>

            <div class="grafici_section">

                <h2>Statistiche ambientali</h2>

                <div class="grafici_buttons">

                    <button type="button" onclick="caricaGrafico('mezzi')">
                        Mezzi più usati
                    </button>

                    <button type="button" onclick="caricaGrafico('impatto')">
                        Impatto ambientale
                    </button>

                </div>

                <div class="chart_container">
                    <canvas id="myChart"></canvas>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>