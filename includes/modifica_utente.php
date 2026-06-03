<?php

include "../config.php";
include "check_sessione.php";

/* SOLO ADMIN */
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] != 'a') {
    header("Location: ../index.php");
    exit();
}

/* ID */
if (!isset($_GET['id'])) {
    header("Location: ../pages/pagina_privata_admin.php?error=id");
    exit();
}

$id = (int) $_GET['id'];

/* ==========================
   UPDATE UTENTE
========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $ruolo = $_POST['ruolo'];
    $id_classe = !empty($_POST['classe']) ? (int)$_POST['classe'] : NULL;

    $password_sql = "";

    /* se password inserita → aggiorna */
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $password_sql = ", password = '$password'";
    }

    $sql = "
        UPDATE utenti
        SET
            username = '$username',
            email = '$email',
            ruolo = '$ruolo',
            id_classe = " . ($id_classe ? $id_classe : "NULL") . "
            $password_sql
        WHERE id = $id
    ";

    mysqli_query($conn, $sql);

    header("Location: ../pages/pagina_privata_admin.php?success=update_user");
    exit();
}

/* ==========================
   PRELEVA DATI UTENTE
========================== */

$utente = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT *
        FROM utenti
        WHERE id = $id
    ")
);

/* CLASSI */
$classi = mysqli_query($conn, "
SELECT c.id, c.anno, s.nome AS sezione, i.nome AS indirizzo
FROM classi c
JOIN sezioni s ON c.id_sezione = s.id
JOIN indirizzi i ON c.id_indirizzo = i.id
");
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Modifica Utente</title>
    <link rel="stylesheet" href="../css/pagina_privata_admin.css">
</head>

<body class="private_page">

<div class="top_bar">
    <h1>Modifica utente</h1>

    <a href="../pages/pagina_privata_admin.php" class="logout_btn">
        Indietro
    </a>
</div>

<div class="container">

    <div class="main_card">

        <form method="POST">

            <div class="field">
                <label>Username</label>
                <input type="text" name="username"
                       value="<?= $utente['username'] ?>" required>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="email" name="email"
                       value="<?= $utente['email'] ?>" required>
            </div>

            <div class="field">
                <label>Nuova Password (opzionale)</label>
                <input type="password" name="password">
            </div>

            <div class="field">
                <label>Ruolo</label>
                <select name="ruolo">

                    <option value="s" <?= $utente['ruolo']=='s'?'selected':'' ?>>
                        Studente
                    </option>

                    <option value="d" <?= $utente['ruolo']=='d'?'selected':'' ?>>
                        Docente
                    </option>

                    <option value="a" <?= $utente['ruolo']=='a'?'selected':'' ?>>
                        Admin
                    </option>

                </select>
            </div>

            <div class="field">
                <label>Classe</label>

                <select name="classe">
                    <option value="">Nessuna</option>

                    <?php while($c = mysqli_fetch_assoc($classi)): ?>

                        <option value="<?= $c['id'] ?>"
                            <?= $utente['id_classe'] == $c['id'] ? 'selected' : '' ?>>

                            <?= $c['anno'] . $c['sezione'] . " - " . $c['indirizzo'] ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <button type="submit">
                Salva modifiche
            </button>

        </form>

    </div>

</div>

</body>
</html>