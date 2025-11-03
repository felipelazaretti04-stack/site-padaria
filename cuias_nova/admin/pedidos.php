<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../includes/db_connect.php';

// Atualizar status se POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id_pedido]);
    header('Location: pedidos.php');
    exit;
}

// Buscar pedidos
$stmt = $pdo->query("SELECT p.*, u.nome FROM pedidos p JOIN usuarios u ON p.id_usuario = u.id ORDER BY p.data DESC");
$pedidos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-brown">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin CuiasLazaretti</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="produtos.php">Produtos</a>
                <a class="nav-link" href="pedidos.php">Pedidos</a>
                <a class="nav-link" href="logout.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Gerenciar Pedidos</h1>
        <table class="table table-striped">
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
                        <td><?php echo htmlspecialchars($pedido['nome']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($pedido['data'])); ?></td>
                        <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($pedido['status']); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id_pedido" value="<?php echo $pedido['id']; ?>">
                                <select name="status" class="form-select form-select-sm d-inline w-auto">
                                    <option value="pendente" <?php if ($pedido['status'] == 'pendente') echo 'selected'; ?>>Pendente</option>
                                    <option value="processando" <?php if ($pedido['status'] == 'processando') echo 'selected'; ?>>Processando</option>
                                    <option value="enviado" <?php if ($pedido['status'] == 'enviado') echo 'selected'; ?>>Enviado</option>
                                    <option value="entregue" <?php if ($pedido['status'] == 'entregue') echo 'selected'; ?>>Entregue</option>
                                    <option value="cancelado" <?php if ($pedido['status'] == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Atualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
