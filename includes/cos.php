<?php

function cos_init(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['cos']) || !is_array($_SESSION['cos'])) {
        $_SESSION['cos'] = [];
    }
}

/** @return array<int, array{id:int, nume:string, pret:float, cantitate:int}> */
function cos_produse(): array
{
    cos_init();
    return $_SESSION['cos'];
}

function cos_nr_articole(): int
{
    $total = 0;
    foreach (cos_produse() as $item) {
        $total += (int) $item['cantitate'];
    }
    return $total;
}

function cos_total(): float
{
    $suma = 0.0;
    foreach (cos_produse() as $item) {
        $suma += (float) $item['pret'] * (int) $item['cantitate'];
    }
    return $suma;
}

function cos_adauga(mysqli $conn, int $id, int $cantitate = 1): bool
{
    cos_init();
    $cantitate = max(1, $cantitate);

    $stmt = $conn->prepare('SELECT id, nume, pret FROM produse WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $produs = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$produs) {
        return false;
    }

    if (isset($_SESSION['cos'][$id])) {
        $_SESSION['cos'][$id]['cantitate'] += $cantitate;
    } else {
        $_SESSION['cos'][$id] = [
            'id' => (int) $produs['id'],
            'nume' => $produs['nume'],
            'pret' => (float) $produs['pret'],
            'cantitate' => $cantitate,
        ];
    }

    return true;
}

function cos_actualizeaza(int $id, int $cantitate): void
{
    cos_init();
    if (!isset($_SESSION['cos'][$id])) {
        return;
    }
    if ($cantitate <= 0) {
        unset($_SESSION['cos'][$id]);
        return;
    }
    $_SESSION['cos'][$id]['cantitate'] = $cantitate;
}

function cos_sterge(int $id): void
{
    cos_init();
    unset($_SESSION['cos'][$id]);
}

function cos_goleste(): void
{
    cos_init();
    $_SESSION['cos'] = [];
}
