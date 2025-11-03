<?php
session_start();
include '../includes/db_connect.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? 0;
$quantidade = $_POST['quantidade'] ?? 1;

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_SESSION['carrinho'][$id])) {
    $_SESSION['carrinho'][$id]['quantidade'] += $quantidade;
} else {
    $_SESSION['carrinho'][$id] = ['quantidade' => $quantidade];
}

echo json_encode(['success' => true, 'count' => count($_SESSION['carrinho'])]);
?>
