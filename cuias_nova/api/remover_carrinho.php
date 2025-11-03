<?php
session_start();

$id = $_GET['id'] ?? 0;
if (isset($_SESSION['carrinho'][$id])) {
    unset($_SESSION['carrinho'][$id]);
}

header('Location: ../pages/carrinho.php');
exit;
?>
