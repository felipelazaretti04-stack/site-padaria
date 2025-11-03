<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db_connect.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, u.nome, u.email FROM pedidos p JOIN usuarios u ON p.id_usuario = u.id WHERE p.id = ?");
$stmt->execute([$id]);
$pedido = $stmt->fetch();

$stmt = $pdo->prepare("SELECT ip.*, pr.nome FROM itens_pedido ip JOIN produtos pr ON ip.id_produto = pr.id WHERE ip.id_pedido = ?");
$stmt->execute([$id]);
$itens = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido - CuiasLazaretti Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">CuiasLazaretti Admin</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="produtos.php">Produtos</a>
                <a class="nav-link" href="pedidos.php">Pedidos</a>
                <a class="nav-link" href="logout.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Detalhes do Pedido #<?php echo $pedido['id']; ?></h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Informações do Cliente</h3>
                <p><strong>Nome:</strong> <?php echo $pedido['nome']; ?></p>
                <p><strong>Email:</strong> <?php echo $pedido['email']; ?></p>
            </div>
            <div class="col-md-6">
                <h3>Informações do Pedido</h3>
                <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['data'])); ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst($pedido['status']); ?></p>
                <p><strong>Total:</strong> R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></p>
            </div>
        </div>
        <h3>Itens do Pedido</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($item['quantidade'] * $item['preco'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="pedidos.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>
