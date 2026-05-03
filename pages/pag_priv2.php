<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* SCUOLE */
$scuole = mysqli_query($conn, "SELECT id, nome FROM scuole");

/* MEZZI */
$mezzi = mysqli_query($conn, "SELECT id, nome FROM mezzi");

/* CLASSI */
$classi = mysqli_query($conn, "
    SELECT 
        classi.id,
        classi.anno,
        sezioni.nome AS sezione,
        indirizzi.nome AS indirizzo
    FROM classi
    JOIN sezioni ON classi.id_sezione = sezioni.id
    JOIN indirizzi ON classi.id_indirizzo = indirizzi.id
    ORDER BY classi.anno, sezioni.nome
");
?>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green; font-weight: bold;">
        Spostamento salvato con successo!
    </p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red; font-weight: bold;">
        Errore nel salvataggio dello spostamento.
    </p>
<?php endif; ?>

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

        <div class="main_card">

            <h2>Inserisci spostamento giornaliero</h2>

            <form action="../includes/insert_spostamento.php" method="POST">

                <!-- DATA -->
                <div class="field">
                    <label for="data">Data</label>
                    <input type="date" name="data" id="data" required>
                </div>

<<<<<<< HEAD
                <!-- SCUOLA -->
                <div class="field">
                    <label for="scuola">Scuola</label>
                    <select name="scuola" id="scuola" required>
                        <option value="">Seleziona scuola</option>
                        <?php while ($row = mysqli_fetch_assoc($scuole)): ?>
                            <option value="<?= $row['id'] ?>">
                                <?= $row['nome'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- CLASSE -->
                <div class="field">
                    <label for="classe">Classe</label>
                    <select name="classe" id="classe" required>
                        <option value="">Seleziona classe</option>
                        <?php while ($row = mysqli_fetch_assoc($classi)): ?>
                            <option value="<?= $row['id'] ?>">
                                <?= $row['anno'] . $row['sezione'] . ' ' . $row['indirizzo'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- MEZZO -->
                <div class="field">
                    <label for="mezzo">Mezzo di trasporto</label>
                    <select name="mezzo" id="mezzo" required>
                        <option value="">Seleziona mezzo</option>
                        <?php while ($row = mysqli_fetch_assoc($mezzi)): ?>
                            <option value="<?= $row['id'] ?>">
                                <?= $row['nome'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
=======
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
>>>>>>> f376ecc61d4049a945bcab48dacd2bdd319ee5b5

                <!-- KM -->
                <div class="field">
                    <label for="km">Distanza (km)</label>
                    <input type="number" name="km" id="km" min="0" step="0.1" required>
                </div>

                <!-- PASSEGGERI -->
                <div class="field">
                    <label for="passeggeri">Numero passeggeri</label>
                    <input type="number" name="passeggeri" id="passeggeri" min="1" step="1" required>
                </div>

                <button type="submit">Salva spostamento</button>

            </form>

        </div>

    </div>

</body>

</html>