<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - CuiasLazaretti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">CuiasLazaretti Admin</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="produtos.php">Produtos</a>
                <a class="nav-link" href="pedidos.php">Pedidos</a>
                <a class="nav-link" href="logout.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Bem-vindo ao Painel Administrativo</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produtos</h5>
                        <p class="card-text">Gerenciar produtos da loja.</p>
                        <a href="produtos.php" class="btn btn-primary">Ver Produtos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos</h5>
                        <p class="card-text">Visualizar e gerenciar pedidos.</p>
                        <a href="pedidos.php" class="btn btn-primary">Ver Pedidos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
