<?php
session_start();
header('Content-Type: application/json');

$count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
echo json_encode(['count' => $count]);
?>
