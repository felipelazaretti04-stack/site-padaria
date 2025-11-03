<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

$pedidos = $pdo->query("SELECT p.*, u.nome FROM pedidos p JOIN usuarios u ON p.id_usuario = u.id ORDER BY p.data DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos - CuiasLazaretti Admin</title>
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
        <h1>Gerenciar Pedidos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo $pedido['nome']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($pedido['data'])); ?></td>
                        <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                        <td><?php echo ucfirst($pedido['status']); ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $pedido['id']; ?>">
                                <select name="status" class="form-select form-select-sm d-inline w-auto">
                                    <option value="pendente" <?php echo $pedido['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                                    <option value="enviado" <?php echo $pedido['status'] == 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                                    <option value="entregue" <?php echo $pedido['status'] == 'entregue' ? 'selected' : ''; ?>>Entregue</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Atualizar</button>
                            </form>
                            <a href="pedido_detalhe.php?id=<?php echo $pedido['id']; ?>" class="btn btn-sm btn-info">Detalhes</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
