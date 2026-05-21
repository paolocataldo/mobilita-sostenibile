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
    <title>Registrazione</title>
    <link rel="stylesheet" href="../css/registrazione.css">
    <script src="../js/registrazione_script.js" defer></script>
</head>

<body>

    <div class="registrazione_form">
        
         <h1 class="title">Registrazione</h1>

        <form action="../includes/registrazione_utente.php" method="POST" onsubmit="return controllaForm()">

            <div class="campo">
                <label for="username">Username</label>

                <input type="text" name="username" id="username" required>

                <div class="input_message" id="username_message"></div>
            </div>

            <div class="campo">
                <label for="email">Email</label>

                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
                    required
                >

                <div class="input_message" id="email_message"></div>
            </div>

            <div class="campo">
                <label for="conferma_email">Conferma Email</label>
                <input 
                    type="email" 
                    name="conferma_email" 
                    id="conferma_email"
                    pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
                    required
                >
            </div>

            <div class="campo">
                <label for="password">Password</label>

                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    required
                >

                <div class="input_message" id="password_message"></div>
            </div>

            <div class="campo">
                <label for="conferma_password">Conferma Password</label>
                <input 
                    type="password" 
                    name="conferma_password" 
                    id="conferma_password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                >
            </div>

            <div class="campo">
                <label for="scuola">Scuola</label>

                <select name="scuola" id="scuola" onchange="caricaClassi()">

                    <option value="">Seleziona scuola</option>

                    <?php while($row = mysqli_fetch_assoc($query_scuole)): ?>

                        <option value="<?= $row['id']; ?>">
                            <?= $row['nome']; ?>
                        </option>

                    <?php endwhile; ?>

                </select>
            </div>

            <div class="campo full-width">
                <label for="classe">Classe</label>

                <select name="classe" id="classe">
                    <option value="">Seleziona prima una scuola</option>
                </select>
            </div>

            <div class="full-width">
                <input type="submit" value="Registrati">
            </div>

            <div class="full-width link-container">
                <a href="login.php" class="links">Torna al login</a>
            </div>

        </form>

    </div>

</body>

</html>