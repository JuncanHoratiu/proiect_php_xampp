<?php
require_once __DIR__ . '/includes/cos.php';

$conn = new mysqli('localhost', 'root', '', 'proiect_db');
if ($conn->connect_error) {
    die('Conexiune eșuată: ' . $conn->connect_error);
}

cos_init();

$redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? 'index.php';
$pagini_permise = ['index.php', 'cos.php'];
if (!in_array($redirect, $pagini_permise, true)) {
    $redirect = 'index.php';
}

$actiune = $_POST['actiune'] ?? $_GET['actiune'] ?? '';

switch ($actiune) {
    case 'adauga':
        $id = (int) ($_POST['id'] ?? 0);
        $cant = (int) ($_POST['cantitate'] ?? 1);
        if (cos_adauga($conn, $id, $cant)) {
            header('Location: ' . $redirect . '?cos=adaugat');
        } else {
            header('Location: ' . $redirect . '?cos=eroare');
        }
        break;

    case 'actualizeaza':
        $id = (int) ($_POST['id'] ?? 0);
        $cant = (int) ($_POST['cantitate'] ?? 0);
        cos_actualizeaza($id, $cant);
        header('Location: cos.php');
        break;

    case 'sterge':
        $id = (int) ($_GET['id'] ?? 0);
        cos_sterge($id);
        header('Location: cos.php?cos=sters');
        break;

    case 'goleste':
        cos_goleste();
        header('Location: cos.php?cos=golit');
        break;

    default:
        header('Location: index.php');
}

exit();
