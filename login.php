<?php
session_start();
$conn = new mysqli("localhost", "root", "", "proiect_db");

$eroare = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $parola = $_POST['parola'];

    $result = $conn->query("SELECT * FROM utilizatori WHERE username='$username' AND parola='$parola'");

    if ($result && $result->num_rows == 1) {
        $_SESSION['admin_logat'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $eroare = "Utilizator sau parolă incorectă!";
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-login">

    <div class="page-bg" aria-hidden="true"></div>

    <div style="position: absolute; top: 20px; right: 24px; z-index: 10;">
        <?php include __DIR__ . '/includes/nav_public.php'; ?>
    </div>

    <div class="login-wrapper">
        <aside class="login-visual">
            <img src="assets/images/login-admin.svg" alt="Administrator">
            <h3>Panou de control</h3>
            <p>Autentifică-te pentru a gestiona produsele magazinului.</p>
        </aside>

        <div class="login-card">
            <h2>Conectare Admin</h2>

            <?php if ($eroare != ""): ?>
                <div class="error-msg"><?php echo $eroare; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <label>Utilizator</label>
                    <input type="text" name="username" required placeholder="ex: admin">
                </div>
                <div class="input-group">
                    <label>Parolă</label>
                    <input type="password" name="parola" required placeholder="••••••••">
                </div>
                <button name="login" class="btn-login">Conectare</button>
            </form>

            <a href="index.php" class="back-link">← Înapoi la site</a>
        </div>
    </div>

</body>
</html>
