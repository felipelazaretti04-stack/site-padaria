// Curiosidades Page JavaScript

// Curiosities data
const curiosities = [
    {
        id: 1,
        category: "Pão Francês",
        title: "Origem do Pão Francês",
        text: "O pão francês, conhecido como 'baguete' na França, foi criado em 1920 por um padeiro parisiense. Ele se tornou símbolo da culinária francesa e é consumido em todo o mundo.",
        image: "https://images.unsplash.com/photo-1549931319-a545dcf3bc73?w=400&h=200&fit=crop"
    },
    {
        id: 2,
        category: "Pizza",
        title: "A Pizza Mais Cara do Mundo",
        text: "A pizza mais cara do mundo custa cerca de R$ 10.000 e é servida em um restaurante italiano. Ela leva ingredientes premium como lagosta, caviar e ouro comestível.",
        image: "https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400&h=200&fit=crop"
    },
    {
        id: 3,
        category: "Cuca",
        title: "Tradição Alemã",
        text: "A cuca é um bolo típico da culinária alemã trazido ao Brasil pelos imigrantes. Originalmente doce, hoje existe em versões salgadas e é tradição nas festas juninas.",
        image: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=200&fit=crop"
    },
    {
        id: 4,
        category: "Pães Especiais",
        title: "Pão de Queijo Mineiro",
        text: "O pão de queijo é originário de Minas Gerais e foi criado pelas escravas africanas que trabalhavam nas fazendas de café. Elas misturavam polvilho com água do café.",
        image: "https://images.unsplash.com/photo-1587668178277-295251f900ce?w=400&h=200&fit=crop"
    },
    {
        id: 5,
        category: "Doces",
        title: "O Doce Mais Antigo",
        text: "O mel é considerado o doce mais antigo da humanidade. Os egípcios já o usavam há mais de 5.000 anos, tanto na culinária quanto na medicina.",
        image: "https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=400&h=200&fit=crop"
    },
    {
        id: 6,
        category: "Café",
        title: "O Café Brasileiro",
        text: "O Brasil é o maior produtor de café do mundo, responsável por cerca de 30% da produção global. O café chegou ao país no século 18 trazido pelos jesuítas.",
        image: "https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=400&h=200&fit=crop"
    }
];

// Function to create curiosity card HTML
function createCuriosityCard(curiosity) {
    return `
        <div class="curiosity-card">
            <img src="${curiosity.image}" alt="${curiosity.title}" class="curiosity-image">
            <div class="curiosity-content">
                <div class="curiosity-category">${curiosity.category}</div>
                <h3 class="curiosity-title">${curiosity.title}</h3>
                <p class="curiosity-text">${curiosity.text}</p>
            </div>
        </div>
    `;
}

// Function to load curiosities
function loadCuriosities() {
    const grid = document.getElementById('curiositiesGrid');
    if (grid) {
        grid.innerHTML = curiosities.map(createCuriosityCard).join('');
    }
}

// WhatsApp function
function openWhatsApp() {
    const phone = "31984059204"; // Update with actual number
    const message = "Olá! Gostaria de saber mais sobre as curiosidades da padaria.";
    const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadCuriosities();
});
