<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Seu Carrinho</h1>

    <?php if (empty($carrinho)): ?>
        <p class="text-center">Seu carrinho está vazio.</p>
        <div class="text-center">
            <a href="../index.php" class="btn btn-brown">Continuar Comprando</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrinho as $id => $item): ?>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
                        $stmt->execute([$id]);
                        $produto = $stmt->fetch();
                        $subtotal = $produto['preco'] * $item['quantidade'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                            <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                            <td>
                                <a href="../api/remover_carrinho.php?id=<?php echo $id; ?>" class="btn btn-sm btn-danger">Remover</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end">
            <h4>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h4>
            <a href="checkout.php" class="btn btn-brown">Finalizar Compra</a>
        </div>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
