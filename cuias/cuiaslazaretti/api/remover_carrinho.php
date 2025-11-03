<?php
session_start();
include '../includes/db_connect.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? 0;

if (isset($_SESSION['carrinho'][$id])) {
    unset($_SESSION['carrinho'][$id]);
}

echo json_encode(['success' => true]);
?>
