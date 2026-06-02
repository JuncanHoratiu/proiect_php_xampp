<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/cos.php';

cos_init();
$produse_cos = cos_produse();
$total = cos_total();
$nr_articole = cos_nr_articole();

$mesaj = '';
if (isset($_GET['cos'])) {
    switch ($_GET['cos']) {
        case 'sters': $mesaj = 'Produsul a fost eliminat din coș.'; break;
        case 'golit': $mesaj = 'Coșul a fost golit.'; break;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coș de cumpărături</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-catalog page-cart">

    <div class="page-bg" aria-hidden="true"></div>

    <?php include __DIR__ . '/includes/nav_public.php'; ?>

    <header class="hero hero-compact">
        <div class="hero-img">
            <img src="assets/images/empty-cart.svg" alt="Coș de cumpărături">
        </div>
        <div class="hero-text">
            <h1>Coșul tău de cumpărături</h1>
            <p><?php echo $nr_articole > 0 ? $nr_articole . ' articol(e) în coș' : 'Coșul este gol momentan.'; ?></p>
        </div>
    </header>

    <div class="container">
        <?php if ($mesaj !== ''): ?>
            <div class="alert-success"><?php echo htmlspecialchars($mesaj); ?></div>
        <?php endif; ?>

        <?php if (count($produse_cos) > 0): ?>
            <ul class="cart-list">
                <?php foreach ($produse_cos as $item): ?>
                <li class="cart-item">
                    <img class="cart-item-thumb" src="<?php echo htmlspecialchars(imagine_produs($item['nume'], (int) $item['id'])); ?>"
                         alt="">
                    <div class="cart-item-info">
                        <span class="prod-nume"><?php echo htmlspecialchars($item['nume']); ?></span>
                        <span class="cart-item-unit"><?php echo number_format($item['pret'], 2); ?> RON / buc.</span>
                    </div>
                    <form method="POST" action="cos_actiune.php" class="cart-qty-form">
                        <input type="hidden" name="actiune" value="actualizeaza">
                        <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                        <label class="sr-only" for="qty-<?php echo (int) $item['id']; ?>">Cantitate</label>
                        <input type="number" id="qty-<?php echo (int) $item['id']; ?>" name="cantitate"
                               value="<?php echo (int) $item['cantitate']; ?>" min="1" max="99" class="qty-input">
                        <button type="submit" class="btn-qty-update" title="Actualizează cantitatea">✓</button>
                    </form>
                    <span class="cart-item-subtotal">
                        <?php echo number_format($item['pret'] * $item['cantitate'], 2); ?> RON
                    </span>
                    <a href="cos_actiune.php?actiune=sterge&id=<?php echo (int) $item['id']; ?>"
                       class="btn-remove" title="Elimină din coș">×</a>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="cart-summary">
                <div class="cart-total-row">
                    <span>Total de plată:</span>
                    <strong class="cart-total"><?php echo number_format($total, 2); ?> RON</strong>
                </div>
                <div class="cart-actions-row">
                    <a href="index.php" class="btn-secondary">← Continuă cumpărăturile</a>
                    <a href="cos_actiune.php?actiune=goleste" class="btn-clear"
                       onclick="return confirm('Golești tot coșul?')">Golește coșul</a>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <img src="assets/images/empty-cart.svg" alt="Coș gol">
                <p>Nu ai adăugat încă niciun produs.</p>
                <a href="index.php" class="btn-admin" style="margin-top: 16px; width: auto; display: inline-flex;">Vezi catalogul</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
