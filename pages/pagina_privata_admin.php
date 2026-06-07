<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['ruolo'] != 'a') {
    header("Location: ../index.php");
    exit();
}

/* ==========================
   QUERY STATISTICHE
========================== */

$studenti = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS totale FROM utenti WHERE ruolo='s'
"));

$docenti = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS totale FROM utenti WHERE ruolo='d'
"));

$admin = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS totale FROM utenti WHERE ruolo='a'
"));

$classi_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS totale FROM classi
"));

$viaggi_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS totale FROM viaggi
"));

// CO2 totale ora viene da tratte, non da viaggi
$co2_totale = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(co2) AS totale FROM tratte
"));

/* ==========================
   UTENTI
========================== */

$utenti = mysqli_query($conn, "
SELECT
    u.id,
    u.username,
    u.email,
    u.ruolo,
    c.anno,
    s.nome AS sezione
FROM utenti u
LEFT JOIN classi c ON u.id_classe = c.id
LEFT JOIN sezioni s ON c.id_sezione = s.id
ORDER BY u.username
");

/* ==========================
   CLASSI
========================== */

$classi = mysqli_query($conn, "
SELECT
    c.id,
    c.anno,
    s.nome AS sezione,
    i.nome AS indirizzo
FROM classi c
JOIN sezioni s ON c.id_sezione = s.id
JOIN indirizzi i ON c.id_indirizzo = i.id
ORDER BY i.nome, c.anno, s.nome
");

/* ==========================
   MEZZI
========================== */

$mezzi = mysqli_query($conn, "
SELECT * FROM mezzi ORDER BY nome
");

/* ==========================
   SPOSTAMENTI
   ora ogni viaggio ha più tratte,
   mostriamo una riga per tratta
========================== */

$spostamenti = mysqli_query($conn, "
SELECT
    v.id AS id_viaggio,
    v.data,
    t.id AS id_tratta,
    t.distanza_km,
    t.passeggeri,
    t.co2,
    m.nome AS mezzo,
    u.username
FROM viaggi v
JOIN studenti_viaggi sv ON v.id = sv.id_viaggio
JOIN utenti u ON sv.id_studente = u.id
JOIN tratte t ON t.id_viaggio = v.id
JOIN mezzi m ON t.id_mezzo = m.id
ORDER BY v.data DESC, v.id, t.id
");
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/pagina_privata_admin.css">
</head>

<body class="private_page">

<div class="top_bar">
    <h1>Dashboard Admin - <?= $_SESSION['username'] ?></h1>
    <a href="../includes/logout.php" class="logout_btn">Logout</a>
</div>

<div class="container">

    <!-- STATISTICHE -->
    <div class="stats">
        <div class="card">
            <h3>Studenti</h3>
            <p><?= $studenti['totale'] ?></p>
        </div>
        <div class="card">
            <h3>Docenti</h3>
            <p><?= $docenti['totale'] ?></p>
        </div>
        <div class="card">
            <h3>Admin</h3>
            <p><?= $admin['totale'] ?></p>
        </div>
        <div class="card">
            <h3>Classi</h3>
            <p><?= $classi_count['totale'] ?></p>
        </div>
        <div class="card">
            <h3>Viaggi</h3>
            <p><?= $viaggi_count['totale'] ?></p>
        </div>
        <div class="card">
            <h3>CO₂ Totale</h3>
            <p><?= round($co2_totale['totale'] ?? 0, 2) ?></p>
        </div>
    </div>

    <!-- CREA UTENTE -->
    <div class="main_card">

        <h2>Crea nuovo utente</h2>

        <form action="../includes/crea_utente.php" method="POST">

            <div class="field">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="field">
                <label>Ruolo</label>
                <select name="ruolo" required>
                    <option value="s">Studente</option>
                    <option value="d">Docente</option>
                    <option value="a">Admin</option>
                </select>
            </div>

            <div class="field">
                <label>Classe</label>
                <select name="classe">
                    <option value="">Nessuna</option>
                    <?php
                    mysqli_data_seek($classi, 0);
                    while ($c = mysqli_fetch_assoc($classi)): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= $c['anno'] . $c['sezione'] . " - " . $c['indirizzo'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit">Crea utente</button>

        </form>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'user'): ?>
            <p class="msg success">Utente creato con successo!</p>
        <?php endif; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] == 'update_user'): ?>
            <p class="msg success">Utente modificato con successo!</p>
        <?php endif; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] == 'delete_user'): ?>
            <p class="msg success">Utente eliminato con successo!</p>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'username'): ?>
            <p class="msg error">Username già esistente.</p>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'email'): ?>
            <p class="msg error">Email già registrata.</p>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'db'): ?>
            <p class="msg error">Errore database.</p>
        <?php endif; ?>

    </div>

    <!-- GESTIONE UTENTI -->
    <div class="main_card">

        <h2>Gestione utenti</h2>

        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Ruolo</th>
                <th>Classe</th>
                <th>Azioni</th>
            </tr>
            <?php while ($u = mysqli_fetch_assoc($utenti)): ?>
                <tr>
                    <td><?= $u['username'] ?></td>
                    <td><?= $u['email'] ?></td>
                    <td>
                        <?= $u['ruolo'] == 's' ? 'Studente'
                            : ($u['ruolo'] == 'd' ? 'Docente' : 'Admin') ?>
                    </td>
                    <td><?= $u['anno'] ? $u['anno'] . $u['sezione'] : '-' ?></td>
                    <td>
                        <a href="../includes/modifica_utente.php?id=<?= $u['id'] ?>">Modifica</a>
                        |
                        <a href="../includes/elimina_utente.php?id=<?= $u['id'] ?>"
                           onclick="return confirm('Eliminare utente?')">Elimina</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

    </div>

    <!-- MEZZI -->
    <div class="main_card">

        <h2>Mezzi di trasporto</h2>

        <table>
            <tr>
                <th>Nome</th>
                <th>CO₂/km</th>
            </tr>
            <?php while ($m = mysqli_fetch_assoc($mezzi)): ?>
                <tr>
                    <td><?= $m['nome'] ?></td>
                    <td><?= $m['co2_per_km'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

    </div>

    <!-- CLASSI -->
    <div class="main_card">

        <h2>Classi</h2>

        <table>
            <tr>
                <th>Classe</th>
                <th>Indirizzo</th>
            </tr>
            <?php
            mysqli_data_seek($classi, 0);
            while ($c = mysqli_fetch_assoc($classi)): ?>
                <tr>
                    <td><?= $c['anno'] . $c['sezione'] ?></td>
                    <td><?= $c['indirizzo'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

    </div>

    <!-- SPOSTAMENTI -->
    <div class="main_card">

        <h2>Tutti gli spostamenti</h2>

        <table>
            <tr>
                <th>Studente</th>
                <th>Data</th>
                <th>Mezzo</th>
                <th>Km</th>
                <th>Passeggeri</th>
                <th>CO₂</th>
                <th>Azioni</th>
            </tr>
            <?php while ($s = mysqli_fetch_assoc($spostamenti)): ?>
                <tr>
                    <td><?= $s['username'] ?></td>
                    <td><?= $s['data'] ?></td>
                    <td><?= $s['mezzo'] ?></td>
                    <td><?= $s['distanza_km'] ?></td>
                    <td><?= $s['passeggeri'] ?></td>
                    <td><?= round($s['co2'], 2) ?></td>
                    <td>
                        <a href="../includes/elimina_spostamento.php?id=<?= $s['id_tratta'] ?>"
                           onclick="return confirm('Eliminare questa tratta?')">
                            Elimina
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

    </div>

</div>

</body>
</html>