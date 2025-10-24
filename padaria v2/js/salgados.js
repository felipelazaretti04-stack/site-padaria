// JavaScript específico para a página de Salgados

let currentProduct = 0;
const totalProducts = 3;
const productsPerView = 4;

// Funções do carrossel de produtos
function nextProduct() {
    if (currentProduct < totalProducts - productsPerView) {
        currentProduct++;
        updateProductsCarousel();
    }
}

function prevProduct() {
    if (currentProduct > 0) {
        currentProduct--;
        updateProductsCarousel();
    }
}

function updateProductsCarousel() {
    const carousel = document.getElementById('productsCarousel');
    const translateX = currentProduct * (280 + 25); // card width + gap
    carousel.style.transform = `translateX(-${translateX}px)`;
}

// Função WhatsApp
function openWhatsApp() {
    window.open('https://wa.me/5531984059204?text=Olá! Gostaria de saber mais sobre os salgados!', '_blank');
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Navegação do carrossel
    document.querySelector('.products-nav.prev').addEventListener('click', prevProduct);
    document.querySelector('.products-nav.next').addEventListener('click', nextProduct);

    // WhatsApp button
    const whatsappButton = document.querySelector('.whatsapp-float');
    if (whatsappButton) {
        whatsappButton.addEventListener('click', openWhatsApp);
    }

    // Product click events
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            const title = this.querySelector('.product-title').textContent;
            const price = this.querySelector('.product-price').textContent;
            alert(`Produto selecionado!\n${title}\n${price}`);
        });
    });
});
