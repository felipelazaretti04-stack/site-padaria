<?php
include '../includes/db_connect.php';
include '../includes/header.php';
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Entre em Contato</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Envie uma Mensagem</h3>
            <form>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="mensagem" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="mensagem" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-brown">Enviar</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Informações de Contato</h3>
            <p><strong>Endereço:</strong> Rua das Cuias, 123 - Porto Alegre, RS</p>
            <p><strong>Telefone:</strong> (51) 99999-9999</p>
            <p><strong>E-mail:</strong> contato@cuiaslazaretti.com.br</p>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
