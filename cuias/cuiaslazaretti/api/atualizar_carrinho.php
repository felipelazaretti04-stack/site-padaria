<?php
session_start();
include '../includes/db_connect.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? 0;
$quantidade = $_POST['quantidade'] ?? 1;

if (isset($_SESSION['carrinho'][$id])) {
    if ($quantidade > 0) {
        $_SESSION['carrinho'][$id]['quantidade'] = $quantidade;
    } else {
        unset($_SESSION['carrinho'][$id]);
    }
}

echo json_encode(['success' => true]);
?>
