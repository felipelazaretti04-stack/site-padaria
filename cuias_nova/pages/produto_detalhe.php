<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    echo "<main class='container my-5'><p class='text-center'>Produto não encontrado.</p></main>";
    include '../includes/footer.php';
    exit;
}
?>

<main class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="../assets/img/<?php echo htmlspecialchars($produto['imagem']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
        </div>
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
            <p><?php echo htmlspecialchars($produto['descricao']); ?></p>
            <p class="text-primary fw-bold fs-4">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            <p>Estoque: <?php echo $produto['estoque']; ?> unidades</p>
            <form action="../api/adicionar_carrinho.php" method="POST">
                <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>">
                <div class="mb-3">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="quantidade" name="quantidade" value="1" min="1" max="<?php echo $produto['estoque']; ?>">
                </div>
                <button type="submit" class="btn btn-brown">Adicionar ao Carrinho</button>
            </form>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
