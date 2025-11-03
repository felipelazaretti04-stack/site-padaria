<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../admin/login.php');
    exit;
}

$carrinho = $_SESSION['carrinho'] ?? [];
if (empty($carrinho)) {
    header('Location: carrinho.php');
    exit;
}

$total = 0;
foreach ($carrinho as $id => $item) {
    $stmt = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();
    $total += $produto['preco'] * $item['quantidade'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inserir pedido
    $stmt = $pdo->prepare("INSERT INTO pedidos (id_usuario, total) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $total]);
    $pedido_id = $pdo->lastInsertId();

    // Inserir itens do pedido
    foreach ($carrinho as $id => $item) {
        $stmt = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch();
        $stmt = $pdo->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pedido_id, $id, $item['quantidade'], $produto['preco']]);
    }

    // Limpar carrinho
    unset($_SESSION['carrinho']);

    echo "<div class='container'><div class='alert alert-success'>Pedido realizado com sucesso! Número do pedido: $pedido_id</div></div>";
    include '../includes/footer.php';
    exit;
}
?>

<div class="container">
    <h1 class="mb-4">Finalizar Compra</h1>
    <div class="row">
        <div class="col-md-8">
            <form method="post">
                <h3>Endereço de Entrega</h3>
                <div class="mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" required>
                </div>
                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" required>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" required>
                </div>
                <div class="mb-3">
                    <label for="rua" class="form-label">Rua</label>
                    <input type="text" class="form-control" id="rua" name="rua" required>
                </div>
                <div class="mb-3">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" required>
                </div>
                <div class="mb-3">
                    <label for="complemento" class="form-label">Complemento</label>
                    <input type="text" class="form-control" id="complemento" name="complemento">
                </div>
                <button type="submit" class="btn btn-brown">Finalizar Pedido</button>
            </form>
        </div>
        <div class="col-md-4">
            <h3>Resumo do Pedido</h3>
            <p>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
            <div id="frete-info"></div>
        </div>
    </div>
</div>

<script>
document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch(`../api/calcular_frete.php?cep=${cep}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('frete-info').innerHTML = `<p>Frete: R$ ${data.frete.toFixed(2)}</p>`;
            });
    }
});
</script>

<?php include '../includes/footer.php'; ?>
