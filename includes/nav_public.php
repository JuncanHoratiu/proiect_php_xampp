<?php
require_once __DIR__ . '/cos.php';
cos_init();
$nr_cos = cos_nr_articole();
?>
<nav class="top-nav" aria-label="Navigare principală">
    <a href="index.php" class="nav-link">Catalog</a>
    <a href="cos.php" class="nav-cart">
        <span class="cart-icon" aria-hidden="true">🛒</span>
        Coșul meu
        <?php if ($nr_cos > 0): ?>
            <span class="cart-badge"><?php echo $nr_cos; ?></span>
        <?php endif; ?>
    </a>
</nav>
