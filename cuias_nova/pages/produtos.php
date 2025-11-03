<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

// Buscar produtos com filtro opcional
$categoria = $_GET['categoria'] ?? '';
$query = "SELECT * FROM produtos WHERE 1";
if ($categoria) {
    $query .= " AND categoria = :categoria";
}
$stmt = $pdo->prepare($query);
if ($categoria) {
    $stmt->bindParam(':categoria', $categoria);
}
$stmt->execute();
$produtos = $stmt->fetchAll();

// Buscar categorias únicas
$stmt_cat = $pdo->query("SELECT DISTINCT categoria FROM produtos");
$categorias = $stmt_cat->fetchAll(PDO::FETCH_COLUMN);
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Nossos Produtos</h1>

    <!-- Filtros -->
    <div class="mb-4">
        <a href="produtos.php" class="btn btn-outline-brown me-2">Todos</a>
        <?php foreach ($categorias as $cat): ?>
            <a href="produtos.php?categoria=<?php echo urlencode($cat); ?>" class="btn btn-outline-brown me-2"><?php echo htmlspecialchars($cat); ?></a>
        <?php endforeach; ?>
    </div>

    <!-- Lista de Produtos -->
    <div class="row">
        <?php if (empty($produtos)): ?>
            <p class="text-center">Nenhum produto encontrado.</p>
        <?php else: ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="../assets/img/<?php echo htmlspecialchars($produto['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nome']); ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($produto['descricao'], 0, 100)); ?>...</p>
                            <p class="text-primary fw-bold">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                            <a href="produto_detalhe.php?id=<?php echo $produto['id']; ?>" class="btn btn-brown">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
