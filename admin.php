<?php
session_start();
if (!isset($_SESSION['admin_logat'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/includes/helpers.php';

$conn = new mysqli("localhost", "root", "", "proiect_db");

// Adăugare
if (isset($_POST['add'])) {
    $nume = $_POST['nume'];
    $pret = $_POST['pret'];
    $conn->query("INSERT INTO produse (nume, pret) VALUES ('$nume', '$pret')");
    header("Location: admin.php");
    exit();
}

// Ștergere
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM produse WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// Pregătire Modificare
$id_editare = ""; $nume_editare = ""; $pret_editare = ""; $mod_editare = false;
if (isset($_GET['edit'])) {
    $id_editare = $_GET['edit'];
    $mod_editare = true;
    $prod = $conn->query("SELECT * FROM produse WHERE id=$id_editare")->fetch_assoc();
    if ($prod) {
        $nume_editare = $prod['nume'];
        $pret_editare = $prod['pret'];
    }
}

// Salvare Modificare
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nume = $_POST['nume'];
    $pret = $_POST['pret'];
    $conn->query("UPDATE produse SET nume='$nume', pret='$pret' WHERE id=$id");
    header("Location: admin.php");
    exit();
}

$result = $conn->query("SELECT * FROM produse");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrare Produse</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-admin">

    <div class="page-bg" aria-hidden="true"></div>

    <div class="admin-container">
        <div class="header-panel">
            <div class="title-block">
                <img src="assets/images/admin-gear.svg" alt="">
                <h2>Gestiune Produse</h2>
            </div>
            <a href="logout.php" class="logout-btn">Deconectare (<?php echo htmlspecialchars($_SESSION['admin_logat']); ?>)</a>
        </div>

        <div class="form-box">
            <?php if ($mod_editare): ?>
                <h3>Modifică Produsul curent</h3>
                <form method="POST" class="form-row">
                    <input type="hidden" name="id" value="<?php echo $id_editare; ?>">
                    <input type="text" name="nume" value="<?php echo htmlspecialchars($nume_editare); ?>" required>
                    <input type="number" step="0.01" name="pret" value="<?php echo $pret_editare; ?>" required>
                    <button name="update" class="btn-action btn-update">Salvează</button>
                    <a href="admin.php" class="cancel-link">Anulează</a>
                </form>
            <?php else: ?>
                <h3>Adaugă un Produs Nou</h3>
                <form method="POST" class="form-row">
                    <input type="text" name="nume" placeholder="Nume produs" required>
                    <input type="number" step="0.01" name="pret" placeholder="Preț (RON)" required>
                    <button name="add" class="btn-action btn-add">Adaugă</button>
                </form>
            <?php endif; ?>
        </div>

        <table class="prod-table">
            <thead>
                <tr>
                    <th>Produs</th>
                    <th>Preț</th>
                    <th style="text-align: right;">Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div class="cell-product">
                            <img class="row-thumb" src="<?php echo htmlspecialchars(imagine_produs($row['nume'], (int) $row['id'])); ?>"
                                 alt="">
                            <?php echo htmlspecialchars($row['nume']); ?>
                        </div>
                    </td>
                    <td style="color: #2ecc71; font-weight: bold;"><?php echo number_format($row['pret'], 2); ?> RON</td>
                    <td class="action-links" style="text-align: right;">
                        <a href="?edit=<?php echo $row['id']; ?>" class="edit-link">Modifică</a>
                        <a href="?delete=<?php echo $row['id']; ?>" class="delete-link" onclick="return confirm('Sigur dorești ștergerea acestui produs?')">Șterge</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="index.php" class="back-site">← Vizualizează Site Public</a>
    </div>

</body>
</html>
