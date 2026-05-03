<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* MEZZI */
$mezzi = mysqli_query($conn, "SELECT id, nome FROM mezzi");
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

    <div class="main_card">

        <h2>Inserisci spostamento giornaliero</h2>

        <form action="../includes/insert_spostamento.php" method="POST">

            <!-- DATA -->
            <div class="field">
                <label for="data">Data</label>
                <input type="date" name="data" id="data" required>
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

            <!-- MESSAGGI -->
            <?php if (isset($_GET['success'])): ?>
                <p class="msg success">
                    Spostamento salvato con successo!
                </p>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'already'): ?>
                <p class="msg error">
                    Hai già inserito uno spostamento per oggi.
                </p>
            <?php elseif (isset($_GET['error'])): ?>
                <p class="msg error">
                    Errore nel salvataggio dello spostamento.
                </p>
            <?php endif; ?>

        </form>

    </div>

</div>

</body>
</html>