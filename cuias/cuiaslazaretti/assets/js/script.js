// Atualizar contador do carrinho
function updateCartCount() {
    fetch('api/get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.count;
        });
}

// Adicionar ao carrinho via AJAX
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-to-cart')) {
        e.preventDefault();
        const id = e.target.getAttribute('data-id');
        fetch('api/adicionar_carrinho.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            updateCartCount();
            alert('Produto adicionado ao carrinho!');
        });
    }
});

// Atualizar quantidade no carrinho
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('quantity-input')) {
        const id = e.target.getAttribute('data-id');
        const quantidade = e.target.value;
        fetch('api/atualizar_carrinho.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id + '&quantidade=' + quantidade
        })
        .then(response => response.json())
        .then(data => {
            location.reload(); // Recarregar página para atualizar totais
        });
    }
});

// Remover do carrinho
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-from-cart')) {
        e.preventDefault();
        const id = e.target.getAttribute('data-id');
        fetch('api/remover_carrinho.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        });
    }
});

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});
