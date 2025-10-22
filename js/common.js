// Common JavaScript functions for Padaria Website

// Notification System
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Close modal when clicking outside
function setupModalClose(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    }
}

// Form Utilities
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}

function serializeForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return {};

    const formData = new FormData(form);
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    return data;
}

// Local Storage Utilities
function saveToLocalStorage(key, data) {
    try {
        localStorage.setItem(key, JSON.stringify(data));
        return true;
    } catch (error) {
        console.error('Error saving to localStorage:', error);
        return false;
    }
}

function getFromLocalStorage(key) {
    try {
        const data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    } catch (error) {
        console.error('Error reading from localStorage:', error);
        return null;
    }
}

function removeFromLocalStorage(key) {
    try {
        localStorage.removeItem(key);
        return true;
    } catch (error) {
        console.error('Error removing from localStorage:', error);
        return false;
    }
}

// Cart Management
class CartManager {
    constructor() {
        this.cartKey = 'padaria_cart';
        this.cart = this.getCart();
    }

    getCart() {
        return getFromLocalStorage(this.cartKey) || [];
    }

    saveCart() {
        return saveToLocalStorage(this.cartKey, this.cart);
    }

    addItem(product) {
        const existingItem = this.cart.find(item => item.id === product.id);
        if (existingItem) {
            existingItem.quantity += product.quantity || 1;
        } else {
            this.cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: product.quantity || 1,
                category: product.category
            });
        }
        this.saveCart();
        this.updateCartDisplay();
        showNotification(`${product.name} adicionado ao carrinho!`, 'success');
    }

    removeItem(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
        this.updateCartDisplay();
        showNotification('Item removido do carrinho!', 'warning');
    }

    updateQuantity(productId, quantity) {
        const item = this.cart.find(item => item.id === productId);
        if (item) {
            item.quantity = Math.max(0, quantity);
            if (item.quantity === 0) {
                this.removeItem(productId);
            } else {
                this.saveCart();
                this.updateCartDisplay();
            }
        }
    }

    getTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    getItemCount() {
        return this.cart.reduce((count, item) => count + item.quantity, 0);
    }

    clearCart() {
        this.cart = [];
        this.saveCart();
        this.updateCartDisplay();
        showNotification('Carrinho esvaziado!', 'warning');
    }

    updateCartDisplay() {
        // Update cart count in header
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
            cartCount.textContent = this.getItemCount();
        }

        // Dispatch custom event for cart updates
        window.dispatchEvent(new CustomEvent('cartUpdated', {
            detail: {
                cart: this.cart,
                total: this.getTotal(),
                itemCount: this.getItemCount()
            }
        }));
    }
}

// Initialize cart manager
const cartManager = new CartManager();

// Quick add to cart function
function addToCart(productId, productName, productPrice, productImage = '', quantity = 1) {
    cartManager.addItem({
        id: productId,
        name: productName,
        price: parseFloat(productPrice),
        image: productImage,
        quantity: quantity
    });
}

// WhatsApp Integration
function openWhatsApp() {
    const phone = "31984059204"; // Padaria phone
    const message = encodeURIComponent("Olá! Gostaria de fazer um pedido.");
    const url = `https://wa.me/${phone}?text=${message}`;
    window.open(url, '_blank');
}

// Search Functionality
function setupSearch() {
    const searchInput = document.querySelector('.search-box');
    const searchIcon = document.querySelector('.search-icon');

    if (searchInput && searchIcon) {
        searchIcon.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
}

function performSearch() {
    const searchInput = document.querySelector('.search-box');
    if (searchInput) {
        const query = searchInput.value.trim();
        if (query) {
            // Implement search logic here
            showNotification(`Buscando por: ${query}`, 'info');
            // Could redirect to search results page or filter products
        }
    }
}

// Responsive Navigation
function setupMobileNav() {
    // Add mobile menu toggle if needed
    const nav = document.querySelector('.nav-primary');
    if (nav && window.innerWidth <= 768) {
        // Implement mobile menu logic
    }
}

// Keyboard Shortcuts
document.addEventListener('keydown', function(event) {
    // Escape to close modals
    if (event.key === 'Escape') {
        const openModals = document.querySelectorAll('.modal[style*="display: flex"]');
        openModals.forEach(modal => {
            modal.style.display = 'none';
        });
    }
});

// Initialize common functionality
document.addEventListener('DOMContentLoaded', function() {
    setupSearch();
    setupMobileNav();

    // Update cart display on page load
    cartManager.updateCartDisplay();

    // Setup modal close for all modals
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        setupModalClose(modal.id);
    });

    // Show welcome notification
    setTimeout(() => {
        showNotification('Bem-vindo à Padaria!', 'success');
    }, 1000);
});

// Utility functions
function formatCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
