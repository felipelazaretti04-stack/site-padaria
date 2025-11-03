<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    echo "<div class='container'><p>Produto não encontrado.</p></div>";
    include '../includes/footer.php';
    exit;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="../assets/img/produtos/<?php echo $produto['imagem']; ?>" class="img-fluid" alt="<?php echo $produto['nome']; ?>">
        </div>
        <div class="col-md-6">
            <h1><?php echo $produto['nome']; ?></h1>
            <p class="lead"><?php echo $produto['descricao']; ?></p>
            <p class="h4 text-brown">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            <p>Estoque: <?php echo $produto['estoque']; ?> unidades</p>
            <button class="btn btn-brown btn-lg add-to-cart" data-id="<?php echo $produto['id']; ?>">Adicionar ao Carrinho</button>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
