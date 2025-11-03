<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuiasLazaretti - Loja de Cuias e Bombas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="bg-brown text-white py-3 fixed-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="index.php" class="text-white text-decoration-none">
                        <h1 class="h4 mb-0">CuiasLazaretti</h1>
                    </a>
                </div>
                <div class="col-md-6">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Buscar produtos..." aria-label="Search">
                        <button class="btn btn-beige" type="submit">Buscar</button>
                    </form>
                </div>
                <div class="col-md-3 text-end">
                    <a href="pages/carrinho.php" class="text-white me-3">
                        <i class="fas fa-shopping-cart"></i> Carrinho (<span id="cart-count">0</span>)
                    </a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="admin/index.php" class="text-white">Painel Admin</a>
                    <?php else: ?>
                        <a href="admin/login.php" class="text-white">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <main class="mt-5 pt-4">
