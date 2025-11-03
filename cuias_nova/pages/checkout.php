<?php
session_start();
include '../includes/db_connect.php';
include '../includes/header.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simular finalização (integrar com PagSeguro depois)
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];

    // Inserir usuário se não existir
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    if (!$usuario) {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, '', 'cliente')");
        $stmt->execute([$nome, $email]);
        $id_usuario = $pdo->lastInsertId();
    } else {
        $id_usuario = $usuario['id'];
    }

    // Inserir endereço
    $stmt = $pdo->prepare("INSERT INTO enderecos (id_usuario, cep, cidade, estado, rua, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_usuario, $cep, $cidade, $estado, $rua, $numero, $complemento]);

    // Inserir pedido
    $stmt = $pdo->prepare("INSERT INTO pedidos (id_usuario, total, status) VALUES (?, ?, 'pendente')");
    $stmt->execute([$id_usuario, $total]);
    $id_pedido = $pdo->lastInsertId();

    // Inserir itens
    foreach ($carrinho as $id_produto => $item) {
        $stmt = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
        $stmt->execute([$id_produto]);
        $produto = $stmt->fetch();
        $stmt = $pdo->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_pedido, $id_produto, $item['quantidade'], $produto['preco']]);
    }

    // Limpar carrinho
    unset($_SESSION['carrinho']);

    echo "<div class='alert alert-success'>Pedido finalizado com sucesso! Número do pedido: $id_pedido</div>";
    exit;
}
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Finalizar Compra</h1>

    <div class="row">
        <div class="col-md-8">
            <form method="POST">
                <h3>Dados Pessoais</h3>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <h3>Endereço de Entrega</h3>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="rua" name="rua" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>
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
            <!-- Aqui poderia adicionar cálculo de frete -->
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
