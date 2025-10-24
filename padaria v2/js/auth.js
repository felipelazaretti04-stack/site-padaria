// Authentication JavaScript for client login and registration

// User data storage (simulated - in real app, this would be server-side)
let currentUser = null;
let users = JSON.parse(localStorage.getItem('padaria_users')) || [];

// DOM elements
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const loginSide = document.getElementById('loginSide');
const registerSide = document.getElementById('registerSide');
const welcomeSide = document.getElementById('welcomeSide');
const registerWelcomeSide = document.getElementById('registerWelcomeSide');
const customerArea = document.getElementById('customerArea');

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is already logged in
    const savedUser = localStorage.getItem('padaria_current_user');
    if (savedUser) {
        currentUser = JSON.parse(savedUser);
        showCustomerArea();
    }

    // Add form validation
    setupFormValidation();
});

// Switch between login and register
function switchToRegister() {
    loginSide.style.display = 'none';
    welcomeSide.style.display = 'none';
    registerSide.style.display = 'block';
    registerWelcomeSide.style.display = 'block';
}

function switchToLogin() {
    registerSide.style.display = 'none';
    registerWelcomeSide.style.display = 'none';
    loginSide.style.display = 'block';
    welcomeSide.style.display = 'block';
}

// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
}

// Handle login
function handleLogin(event) {
    event.preventDefault();

    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    const rememberMe = document.getElementById('rememberMe').checked;

    // Clear previous errors
    clearErrors('login');

    // Validate input
    if (!validateEmail(email)) {
        showError('loginEmailError', 'E-mail inválido');
        return;
    }

    if (!password) {
        showError('loginPasswordError', 'Senha é obrigatória');
        return;
    }

    // Find user
    const user = users.find(u => u.email === email && u.password === password);

    if (user) {
        currentUser = user;
        if (rememberMe) {
            localStorage.setItem('padaria_current_user', JSON.stringify(user));
        } else {
            sessionStorage.setItem('padaria_current_user', JSON.stringify(user));
        }

        showNotification('Login realizado com sucesso!', 'success');
        setTimeout(() => {
            showCustomerArea();
        }, 1000);
    } else {
        showError('loginPasswordError', 'E-mail ou senha incorretos');
    }
}

// Handle registration
function handleRegister(event) {
    event.preventDefault();

    const name = document.getElementById('registerName').value;
    const surname = document.getElementById('registerSurname').value;
    const email = document.getElementById('registerEmail').value;
    const phone = document.getElementById('registerPhone').value;
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('registerConfirmPassword').value;
    const acceptTerms = document.getElementById('acceptTerms').checked;

    // Clear previous errors
    clearErrors('register');

    // Validate input
    if (!name || name.length < 2) {
        showError('registerNameError', 'Nome deve ter pelo menos 2 caracteres');
        return;
    }

    if (!surname || surname.length < 2) {
        showError('registerSurnameError', 'Sobrenome deve ter pelo menos 2 caracteres');
        return;
    }

    if (!validateEmail(email)) {
        showError('registerEmailError', 'E-mail inválido');
        return;
    }

    if (users.some(u => u.email === email)) {
        showError('registerEmailError', 'Este e-mail já está cadastrado');
        return;
    }

    if (password.length < 6) {
        showError('registerPasswordError', 'Senha deve ter pelo menos 6 caracteres');
        return;
    }

    if (password !== confirmPassword) {
        showError('registerConfirmPasswordError', 'Senhas não coincidem');
        return;
    }

    if (!acceptTerms) {
        showError('registerConfirmPasswordError', 'Você deve aceitar os termos');
        return;
    }

    users.push(newUser);
    localStorage.setItem('padaria_users', JSON.stringify(users));

    currentUser = newUser;
    localStorage.setItem('padaria_current_user', JSON.stringify(newUser));

    showNotification('Conta criada com sucesso!', 'success');
    setTimeout(() => {
        showCustomerArea();
    }, 1000);
}

// Show customer area
function showCustomerArea() {
    document.querySelector('.main-container').style.display = 'none';
    customerArea.style.display = 'block';

    // Update user info
    document.getElementById('customerName').textContent = currentUser.name;
    document.getElementById('customerEmail').textContent = currentUser.email;
    document.getElementById('customerAvatar').textContent = currentUser.avatar;
}

// Logout
function logout() {
    currentUser = null;
    localStorage.removeItem('padaria_current_user');
    sessionStorage.removeItem('padaria_current_user');

    customerArea.style.display = 'none';
    document.querySelector('.main-container').style.display = 'flex';

    showNotification('Logout realizado com sucesso!', 'success');
}

// Show forgot password
function showForgotPassword() {
    const email = prompt('Digite seu e-mail para redefinir a senha:');
    if (email && validateEmail(email)) {
        // In real app, send reset email
        showNotification('E-mail de redefinição enviado! (simulado)', 'success');
    } else if (email) {
        showNotification('E-mail inválido', 'error');
    }
}

// Social login (simulated)
function loginWithGoogle() {
    showNotification('Login com Google (simulado)', 'success');
    // In real app, integrate with Google OAuth
}

function loginWithFacebook() {
    showNotification('Login com Facebook (simulado)', 'success');
    // In real app, integrate with Facebook OAuth
}

// Dashboard functions
function showOrders() {
    alert('Funcionalidade de pedidos em desenvolvimento');
}

function showFavorites() {
    alert('Funcionalidade de favoritos em desenvolvimento');
}

function showProfile() {
    alert('Funcionalidade de perfil em desenvolvimento');
}

function showAddresses() {
    alert('Funcionalidade de endereços em desenvolvimento');
}

// Form validation helpers
function setupFormValidation() {
    // Real-time validation
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
}

function validateField(field) {
    const value = field.value;
    const fieldName = field.id.replace('login', '').replace('register', '').toLowerCase();
    const errorElement = document.getElementById(field.id + 'Error');

    if (errorElement) {
        errorElement.textContent = '';
        field.classList.remove('error');
    }

    switch (fieldName) {
        case 'email':
            if (value && !validateEmail(value)) {
                showError(field.id + 'Error', 'E-mail inválido');
            }
            break;
        case 'password':
            if (value && value.length < 6) {
                showError(field.id + 'Error', 'Mínimo 6 caracteres');
            }
            break;
        case 'name':
        case 'surname':
            if (value && value.length < 2) {
                showError(field.id + 'Error', 'Mínimo 2 caracteres');
            }
            break;
    }
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showError(elementId, message) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = message;
        element.previousElementSibling.classList.add('error');
    }
}

function clearErrors(formType) {
    document.querySelectorAll(`#${formType}Form .error-message`).forEach(el => {
        el.textContent = '';
    });
    document.querySelectorAll(`#${formType}Form .form-input`).forEach(el => {
        el.classList.remove('error');
    });
}

// Notification system
function showNotification(message, type) {
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

// Add notification styles
const style = document.createElement('style');
style.textContent = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 10px;
        color: white;
        font-weight: bold;
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
    }

    .notification.show {
        transform: translateX(0);
    }

    .notification.success {
        background: #27AE60;
    }

    .notification.error {
        background: #E74C3C;
    }

    .notification.warning {
        background: #F39C12;
    }
`;
document.head.appendChild(style);
