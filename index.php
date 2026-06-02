<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/cos.php';

cos_init();

$conn = new mysqli('localhost', 'root', '', 'proiect_db');
if ($conn->connect_error) {
    die('Conexiune eșuată: ' . $conn->connect_error);
}
$result = $conn->query('SELECT * FROM produse');

$mesaj_cos = '';
if (isset($_GET['cos'])) {
    if ($_GET['cos'] === 'adaugat') {
        $mesaj_cos = 'Produs adăugat în coș cu succes!';
    } elseif ($_GET['cos'] === 'eroare') {
        $mesaj_cos = 'Nu s-a putut adăuga produsul în coș.';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog Produse</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-catalog">

    <div class="page-bg" aria-hidden="true"></div>

    <?php include __DIR__ . '/includes/nav_public.php'; ?>

    <header class="hero">
        <div class="hero-img">
            <img src="assets/images/hero-shop.svg" alt="Magazin online">
        </div>
        <div class="hero-text">
            <h1>Catalogul Nostru de Produse</h1>
            <p>Descoperă ofertele noastre — prețuri actualizate în timp real.</p>
        </div>
    </header>

    <div class="container">
        <?php if ($mesaj_cos !== ''): ?>
            <div class="alert-success alert-pop"><?php echo htmlspecialchars($mesaj_cos); ?></div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <ul class="product-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="product-card">
                    <div class="product-thumb">
                        <img src="<?php echo htmlspecialchars(imagine_produs($row['nume'], (int) $row['id'])); ?>"
                             alt="<?php echo htmlspecialchars($row['nume']); ?>">
                    </div>
                    <div class="product-info">
                        <span class="prod-nume"><?php echo htmlspecialchars($row['nume']); ?></span>
                    </div>
                    <div class="product-actions">
                        <span class="prod-pret"><?php echo number_format($row['pret'], 2); ?> RON</span>
                        <form method="POST" action="cos_actiune.php" class="form-add-cart">
                            <input type="hidden" name="actiune" value="adauga">
                            <input type="hidden" name="id" value="<?php echo (int) $row['id']; ?>">
                            <input type="hidden" name="redirect" value="index.php">
                            <button type="submit" class="btn-add-cart">+ Adaugă în coș</button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="empty-state">
                <img src="assets/images/empty-cart.svg" alt="Coș gol">
                <p>Momentan nu există produse în magazin.</p>
            </div>
        <?php endif; ?>

        <a href="login.php" class="btn-admin">Autentificare Administrator</a>
    </div>

</body>
</html>
