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
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/pagina_privata.css">
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

                <div class="field">
                    <label>Mezzo</label>
                    <select name="mezzo">
                        <option value="">Tutti</option>
                        <?php while($m = mysqli_fetch_assoc($mezzi)): ?>
                            <option value="<?= $m['id'] ?>"><?= $m['nome'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Studente</label>
                    <select name="studente">
                        <option value="">Tutti</option>
                        <?php while($s = mysqli_fetch_assoc($studenti)): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['username'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="field">
                    <label>Classe</label>
                    <select name="classe">
                        <option value="">Tutte</option>
                        <?php while($c = mysqli_fetch_assoc($classi)): ?>
                            <option value="<?= $c['id'] ?>">
                                <?= $c['anno'] . $c['sezione'] . ' ' . $c['indirizzo'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit">Visualizza Classifica</button>

            </form>

        </div>

    </div>

</div>

</body>
</html>