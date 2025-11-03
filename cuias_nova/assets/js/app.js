// Scripts para interações no site CuiasLazaretti

// Atualizar quantidade no carrinho (exemplo, pode ser expandido)
document.addEventListener('DOMContentLoaded', function() {
    // Exemplo: Calcular frete no checkout
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('blur', function() {
            const cep = this.value;
            if (cep.length === 8) {
                fetch('../api/calcular_frete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'cep=' + cep
                })
                .then(response => response.json())
                .then(data => {
                    alert('Frete calculado: R$ ' + data.frete);
                    // Atualizar total com frete
                });
            }
        });
    }

    // Outras interações podem ser adicionadas aqui
});
