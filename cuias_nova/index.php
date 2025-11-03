<?php
include 'includes/db_connect.php';

// Buscar produtos em destaque
$stmt = $pdo->query("SELECT * FROM produtos LIMIT 6");
$produtos = $stmt->fetchAll();
?>

<?php include 'includes/header.php'; ?>

    <!-- Carrossel -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption">
                    <h1 class="display-4 fade-in">Bem-vindo à CuiasLazaretti</h1>
                    <p class="lead">Produtos artesanais com tradição gaúcha</p>
                    <a href="pages/produtos.php" class="btn btn-brown btn-lg">Ver Produtos</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption">
                    <h1 class="display-4 fade-in">Cuias Personalizadas</h1>
                    <p class="lead">Crie sua cuia única e especial</p>
                    <a href="pages/contato.php" class="btn btn-outline-brown btn-lg">Fale Conosco</a>
                </div>
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

    <!-- Sobre Nós -->
    <section class="py-5 bg-beige">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="text-brown mb-4">Tradição Gaúcha em Cada Detalhe</h2>
                    <p class="lead">Na CuiasLazaretti, preservamos a rica tradição do chimarrão gaúcho, oferecendo cuias artesanais, bombas elegantes e kits completos feitos com materiais de alta qualidade e design moderno.</p>
                    <p>Nossos produtos são cuidadosamente elaborados por artesãos experientes, combinando técnicas tradicionais com toques contemporâneos para atender às necessidades do chimarreiro moderno.</p>
                    <a href="pages/produtos.php" class="btn btn-brown">Conheça Nossos Produtos</a>
                </div>
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Cuia Artesanal" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Produtos em Destaque -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center text-brown mb-5">Produtos em Destaque</h2>
            <div class="row">
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-brown"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars(substr($produto['descricao'], 0, 100)); ?>...</p>
                                <p class="card-text mt-auto"><strong class="text-brown h4">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong></p>
                                <div class="mt-3">
                                    <a href="pages/produto_detalhe.php?id=<?php echo $produto['id']; ?>" class="btn btn-brown me-2">Ver Detalhes</a>
                                    <a href="api/adicionar_carrinho.php?id=<?php echo $produto['id']; ?>" class="btn btn-outline-brown">Adicionar ao Carrinho</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <a href="pages/produtos.php" class="btn btn-brown btn-lg">Ver Todos os Produtos</a>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-brown text-white">
        <div class="container text-center">
            <h2 class="mb-4">Pronto para Experimentar a Tradição Gaúcha?</h2>
            <p class="lead mb-4">Descubra o prazer do chimarrão com nossos produtos de alta qualidade</p>
            <a href="pages/contato.php" class="btn btn-outline-brown btn-lg me-3">Entre em Contato</a>
            <a href="pages/produtos.php" class="btn btn-brown btn-lg">Comprar Agora</a>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
