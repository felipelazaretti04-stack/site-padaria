// Admin Panel JavaScript

// Simple authentication (in a real app, this would be server-side)
const ADMIN_PASSWORD = "padaria123"; // Change this to a secure password

// Check authentication
function checkAuth() {
    const isLoggedIn = sessionStorage.getItem('admin_logged_in');
    if (!isLoggedIn) {
        const password = prompt("Digite a senha do painel administrativo:");
        if (password === ADMIN_PASSWORD) {
            sessionStorage.setItem('admin_logged_in', 'true');
        } else {
            alert("Senha incorreta!");
            window.location.href = '../html/home.html';
            return false;
        }
    }
    return true;
}

// Logout function
function logout() {
    sessionStorage.removeItem('admin_logged_in');
    window.location.href = '../html/home.html';
}

// Load products from JSON
async function loadProducts() {
    try {
        const response = await fetch('../produtos.json');
        const data = await response.json();
        return data.products || [];
    } catch (error) {
        console.error('Error loading products:', error);
        return [];
    }
}

// Save products to localStorage (in a real app, this would be saved to server)
function saveProducts(products) {
    localStorage.setItem('padaria_products', JSON.stringify(products));
    // In a real implementation, you would send this to the server
    showNotification('Produtos salvos com sucesso!', 'success');
}

// Get products from localStorage or load from JSON
async function getProducts() {
    let products = JSON.parse(localStorage.getItem('padaria_products'));
    if (!products) {
        products = await loadProducts();
        saveProducts(products);
    }
    return products;
}

// Render products list
function renderProducts(products) {
    const productsList = document.getElementById('productsList');
    if (!productsList) return;

    productsList.innerHTML = products.map(product => `
        <div class="product-item ${product.active ? '' : 'inactive'}">
            <div class="status-badge ${product.active ? 'status-active' : 'status-inactive'}">
                ${product.active ? 'Ativo' : 'Inativo'}
            </div>
            <img src="${product.image || 'https://via.placeholder.com/300x200?text=Imagem+do+Produto'}" alt="${product.name}" class="product-image-admin">
            <h3 class="product-name-admin">${product.name}</h3>
            <div class="product-category-admin">${product.category}</div>
            <div class="product-price-admin">R$ ${product.price.toFixed(2)}</div>
            <p class="product-description-admin">${product.description}</p>
            <div class="product-actions">
                <button class="btn-edit" onclick="editProduct(${product.id})">Editar</button>
                <button class="btn-delete" onclick="confirmDelete(${product.id})">Excluir</button>
            </div>
        </div>
    `).join('');
}

// Add new product
async function addProduct(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const newProduct = {
        id: Date.now(), // Simple ID generation
        name: formData.get('name'),
        category: formData.get('category'),
        price: parseFloat(formData.get('price')),
        image: formData.get('image') || '',
        description: formData.get('description'),
        active: formData.get('active') === 'on'
    };

    const products = await getProducts();
    products.push(newProduct);
    saveProducts(products);

    renderProducts(products);
    event.target.reset();
    showNotification('Produto adicionado com sucesso!', 'success');
}

// Edit product
async function editProduct(productId) {
    const products = await getProducts();
    const product = products.find(p => p.id === productId);
    if (!product) return;

    // Fill edit form
    document.getElementById('editProductId').value = product.id;
    document.getElementById('editProductName').value = product.name;
    document.getElementById('editProductCategory').value = product.category;
    document.getElementById('editProductPrice').value = product.price;
    document.getElementById('editProductImage').value = product.image;
    document.getElementById('editProductDescription').value = product.description;
    document.getElementById('editProductActive').checked = product.active;

    // Show modal
    openModal('editModal');
}

// Save edited product
async function saveEditedProduct(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const productId = parseInt(formData.get('id'));
    const updatedProduct = {
        id: productId,
        name: formData.get('name'),
        category: formData.get('category'),
        price: parseFloat(formData.get('price')),
        image: formData.get('image') || '',
        description: formData.get('description'),
        active: formData.get('active') === 'on'
    };

    const products = await getProducts();
    const index = products.findIndex(p => p.id === productId);
    if (index !== -1) {
        products[index] = updatedProduct;
        saveProducts(products);
        renderProducts(products);
        closeModal('editModal');
        showNotification('Produto atualizado com sucesso!', 'success');
    }
}

// Delete product
async function confirmDelete(productId) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        await deleteProduct(productId);
    }
}

async function deleteProduct(productId) {
    const products = await getProducts();
    const filteredProducts = products.filter(p => p.id !== productId);
    saveProducts(filteredProducts);
    renderProducts(filteredProducts);
    closeModal('editModal');
    showNotification('Produto excluído com sucesso!', 'warning');
}

// Initialize admin panel
async function initAdmin() {
    if (!checkAuth()) return;

    const products = await getProducts();
    renderProducts(products);

    // Setup form handlers
    const addForm = document.getElementById('addProductForm');
    const editForm = document.getElementById('editProductForm');

    if (addForm) {
        addForm.addEventListener('submit', addProduct);
    }

    if (editForm) {
        editForm.addEventListener('submit', saveEditedProduct);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initAdmin);
