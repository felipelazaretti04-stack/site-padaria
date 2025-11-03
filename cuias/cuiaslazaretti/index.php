<?php
session_start();
include 'includes/db_connect.php';
include 'includes/header.php';

// Buscar produtos em destaque
$stmt = $pdo->query("SELECT * FROM produtos LIMIT 8");
$produtos = $stmt->fetchAll();
?>

<div class="container">
    <!-- Carrossel de banners -->
    <div id="carouselExample" class="carousel slide mb-5">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/banner1.jpg" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="assets/img/banner2.jpg" class="d-block w-100" alt="Banner 2">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Produtos em destaque -->
    <h2 class="mb-4">Produtos em Destaque</h2>
    <div class="row">
        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="assets/img/produtos/<?php echo $produto['imagem']; ?>" class="card-img-top" alt="<?php echo $produto['nome']; ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                        <p class="card-text"><?php echo substr($produto['descricao'], 0, 100) . '...'; ?></p>
                        <p class="card-text fw-bold">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        <a href="pages/produto_detalhe.php?id=<?php echo $produto['id']; ?>" class="btn btn-brown mt-auto">Ver Detalhes</a>
                        <button class="btn btn-beige mt-2 add-to-cart" data-id="<?php echo $produto['id']; ?>">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
