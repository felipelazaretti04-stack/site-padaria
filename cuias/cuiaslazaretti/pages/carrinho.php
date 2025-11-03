<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
?>

<div class="container">
    <h1 class="mb-4">Carrinho de Compras</h1>
    <?php if (empty($carrinho)): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
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
                            <td><?php echo $produto['nome']; ?></td>
                            <td>
                                <input type="number" class="form-control quantity-input" data-id="<?php echo $id; ?>" value="<?php echo $item['quantidade']; ?>" min="1">
                            </td>
                            <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                            <td><button class="btn btn-danger remove-from-cart" data-id="<?php echo $id; ?>">Remover</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h4>
            </div>
            <div class="col-md-6 text-end">
                <a href="checkout.php" class="btn btn-brown btn-lg">Finalizar Compra</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
