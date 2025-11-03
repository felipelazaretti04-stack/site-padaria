<?php
session_start();
include '../includes/db_connect.php';

$id_produto = $_POST['id_produto'] ?? 0;
$quantidade = $_POST['quantidade'] ?? 1;

if ($id_produto && $quantidade > 0) {
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    if (isset($_SESSION['carrinho'][$id_produto])) {
        $_SESSION['carrinho'][$id_produto]['quantidade'] += $quantidade;
    } else {
        $_SESSION['carrinho'][$id_produto] = ['quantidade' => $quantidade];
    }
}

header('Location: ../pages/carrinho.php');
exit;
?>
