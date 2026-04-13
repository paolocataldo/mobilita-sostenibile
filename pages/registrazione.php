<?php
include "../config.php";
$sql = "SELECT 
            classi.id,
            sezioni.nome AS sezione,
            indirizzi.nome AS indirizzo
        FROM classi
        JOIN sezioni ON classi.id_sezione = sezioni.id
        JOIN indirizzi ON classi.id_indirizzo = indirizzi.id";

$query = mysqli_query($conn, $sql);

$sql_scuole = "SELECT id, nome FROM scuole";
$query_scuole = mysqli_query($conn, $sql_scuole);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/registrazione.css">
    <script src="../js/registrazione_script.js"></script>
</head>

<body>
    <div class="registrazione_form">
        <form action="../includes/registrazione_utente.php" method="POST" onsubmit="return controllaForm()">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required><br><br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required><br><br> <!-- Sono valide solo le email istituzionali -->
            <label for="conferma_email">Conferma Email</label>
            <input type="email" name="conferma_email" id="conferma_email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required><br><br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required><br><br>
            <label for="conferma_password">Conferma Password</label>
            <input type="password" name="conferma_password" id="conferma_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br><br>
            <label for="scuola">Scuola</label>
            <select name="scuola" id="scuola" required onchange="caricaClassi()">
                <option value="">Seleziona scuola</option>

                <?php while($row = mysqli_fetch_assoc($query_scuole)): ?>
                    <option value="<?= $row['id']; ?>">
                        <?= $row['nome']; ?>
                    </option>
                <?php endwhile; ?>
            </select> <br><br>
            <label for="classe">Classe</label>
            <select name="classe" id="classe" required>
                <option value="">Seleziona prima una scuola</option>
            </select> <br><br>
            <input type="submit" value="Registrati"><br><br>
            <!-- aggiungere anche l'opzione classe! -->
             <a href="login.php" class ="links">Torna al login</a>
        </form>
    </div>
</body>

</html>