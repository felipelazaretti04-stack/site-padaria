<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $categoria = $_POST['categoria'];
        $estoque = $_POST['estoque'];
        $imagem = $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../assets/img/produtos/$imagem");

        $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, imagem, categoria, estoque) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $preco, $imagem, $categoria, $estoque]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $categoria = $_POST['categoria'];
        $estoque = $_POST['estoque'];

        $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, descricao = ?, preco = ?, categoria = ?, estoque = ? WHERE id = ?");
        $stmt->execute([$nome, $descricao, $preco, $categoria, $estoque, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
    }
}

$produtos = $pdo->query("SELECT * FROM produtos")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - CuiasLazaretti Admin</title>
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
        <h1>Gerenciar Produtos</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Adicionar Produto</button>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo $produto['estoque']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="<?php echo $produto['id']; ?>" data-bs-toggle="modal" data-bs-target="#editProductModal">Editar</button>
                            <form method="post" class="d-inline">
                                <button type="submit" name="delete" value="<?php echo $produto['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Adicionar Produto -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço</label>
                            <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="categoria" name="categoria">
                        </div>
                        <div class="mb-3">
                            <label for="estoque" class="form-label">Estoque</label>
                            <input type="number" class="form-control" id="estoque" name="estoque" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="add" class="btn btn-primary">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Produto -->
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="mb-3">
                            <label for="edit-nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="edit-nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="edit-descricao" name="descricao" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-preco" class="form-label">Preço</label>
                            <input type="number" step="0.01" class="form-control" id="edit-preco" name="preco" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-categoria" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="edit-categoria" name="categoria">
                        </div>
                        <div class="mb-3">
                            <label for="edit-estoque" class="form-label">Estoque</label>
                            <input type="number" class="form-control" id="edit-estoque" name="estoque" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="edit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                fetch(`get_product.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit-id').value = data.id;
                        document.getElementById('edit-nome').value = data.nome;
                        document.getElementById('edit-descricao').value = data.descricao;
                        document.getElementById('edit-preco').value = data.preco;
                        document.getElementById('edit-categoria').value = data.categoria;
                        document.getElementById('edit-estoque').value = data.estoque;
                    });
            });
        });
    </script>
</body>
</html>
