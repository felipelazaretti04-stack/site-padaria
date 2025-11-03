<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

// Buscar todos os produtos
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll();
?>

<div class="container">
    <h1 class="mb-4">Nossos Produtos</h1>
    <div class="row">
        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="../assets/img/produtos/<?php echo $produto['imagem']; ?>" class="card-img-top" alt="<?php echo $produto['nome']; ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                        <p class="card-text"><?php echo substr($produto['descricao'], 0, 100) . '...'; ?></p>
                        <p class="card-text fw-bold">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                        <a href="produto_detalhe.php?id=<?php echo $produto['id']; ?>" class="btn btn-brown mt-auto">Ver Detalhes</a>
                        <button class="btn btn-beige mt-2 add-to-cart" data-id="<?php echo $produto['id']; ?>">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
