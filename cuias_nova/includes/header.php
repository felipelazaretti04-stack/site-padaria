<?php
// Cabeçalho comum para todas as páginas
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$cart_count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuiasLazaretti - Loja Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/form/cuias_nova/assets/css/style.css">
    <link rel="icon" href="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=32&q=80" type="image/x-icon">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/form/cuias_nova/index.php">
                <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2" style="border-radius: 50%;">
                CuiasLazaretti
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/form/cuias_nova/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/form/cuias_nova/pages/produtos.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/form/cuias_nova/pages/contato.php">Contato</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/form/cuias_nova/pages/carrinho.php">
                            <i class="fas fa-shopping-cart"></i> Carrinho (<span id="cart-count"><?php echo $cart_count; ?></span>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/form/cuias_nova/admin/login.php">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
