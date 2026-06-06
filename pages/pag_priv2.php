<?php
include "../includes/check_sessione.php";
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* MEZZI */
$mezzi = mysqli_query($conn, "SELECT id, nome FROM mezzi");

/* UTENTI per ricerca */
$utenti = mysqli_query($conn, "SELECT username FROM utenti");
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
            <label>Data</label>
            <input type="date" name="data" required>
        </div>

        <!-- MEZZO -->
        <div class="field">
            <label>Mezzo</label>
            <select name="mezzo" id="mezzo" required>
                <option value="" disabled selected>Seleziona mezzo</option>

                <?php while ($row = mysqli_fetch_assoc($mezzi)): ?>
                    <option value="<?= $row['id'] ?>">
                        <?= $row['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- KM -->
        <div class="field">
            <label>Km</label>
            <input type="number" name="km" min="0" step="0.1" required>
        </div>

        <!-- CONDIVISO -->
        <div class="field">
            <label>
                <input type="checkbox" id="viaggio_condiviso" name="viaggio_condiviso">
                Viaggio condiviso
            </label>
        </div>

        <div class="field" id="utenteCondivisoField" style="display:none;">
            <label>Compagno</label>
            <input type="text" name="utente_condiviso">
        </div>

        <!-- PASSEGGERI -->
        <div class="field">
            <label>Passeggeri</label>
            <input type="number" name="passeggeri" id="passeggeri" min="1" value="1">
        </div>

        <!-- AUTOBUS -->
        <div class="field" id="riempimentoBusField" style="display:none;">
            <label>Riempimento autobus</label>

            <div class="radio-group">

                <label class="radio-option">
                    <input type="radio" name="riempimento_bus" value="vuoto">
                    Vuoto
                </label>

                <label class="radio-option">
                    <input type="radio" name="riempimento_bus" value="poco">
                    Poco
                </label>

                <label class="radio-option">
                    <input type="radio" name="riempimento_bus" value="medio">
                    Medio
                </label>

                <label class="radio-option">
                    <input type="radio" name="riempimento_bus" value="tanto">
                    Molto
                </label>

            </div>
        </div>

        <!-- TRENO -->
        <div class="field" id="riempimentoTrenoField" style="display:none;">
            <label>Riempimento treno</label>

            <div class="radio-group">

                <label class="radio-option">
                    <input type="radio" name="riempimento_treno" value="vuoto">
                    Vuoto
                </label>

                <label class="radio-option">
                    <input type="radio" name="riempimento_treno" value="medio">
                    Medio
                </label>

                <label class="radio-option">
                    <input type="radio" name="riempimento_treno" value="pieno">
                    Pieno
                </label>

            </div>
        </div>

        <button type="submit">Salva</button>


            <!-- MESSAGGI -->
            <?php if (isset($_GET['success'])): ?>
                <p class="msg success">Spostamento salvato con successo!</p>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'already'): ?>
                <p class="msg error">Hai già inserito uno spostamento per oggi.</p>
            <?php elseif (isset($_GET['error'])): ?>
                <p class="msg error">Errore nel salvataggio dello spostamento.</p>
            <?php endif; ?>

        </form>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const mezzo = document.getElementById("mezzo");
    const viaggio = document.getElementById("viaggio_condiviso");

    const utenteField = document.getElementById("utenteCondivisoField");
    const busField = document.getElementById("riempimentoBusField");
    const trenoField = document.getElementById("riempimentoTrenoField");
    const passeggeriField = document.getElementById("passeggeri").parentElement;

    function aggiornaUI() {

        const v = mezzo.value;

        // RESET TUTTO
        busField.style.display = "none";
        trenoField.style.display = "none";
        passeggeriField.style.display = "block";

        // 🚌 AUTOBUS
        if (v == "15") {
            busField.style.display = "block";
            passeggeriField.style.display = "none";
        }

        // 🚆 TRENO
        if (v == "16") {
            trenoField.style.display = "block";
            passeggeriField.style.display = "none";
        }
    }

    mezzo.addEventListener("change", aggiornaUI);

    viaggio.addEventListener("change", function () {
        utenteField.style.display = this.checked ? "block" : "none";
    });

    aggiornaUI();
});
</script>

</body>
</html>