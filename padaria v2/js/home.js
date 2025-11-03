        let currentSlide = 0;
        let currentProduct = 0;
        const totalSlides = 3;
        const totalProducts = 6;
        const productsPerView = 4;

        // Main Carousel Functions
        function nextSlide() {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateCarousel();
            }
        }

        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateCarousel();
            }
        }

        function updateCarousel() {
            const carousel = document.getElementById('mainCarousel');
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        // Products Carousel Functions
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

        // Auto-advance main carousel
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateCarousel();
        }, 5000);

        // WhatsApp function
        function openWhatsApp() {
            window.open('https://wa.me/5551999999999?text=Olá! Gostaria de saber mais sobre os produtos Vianncy!', '_blank');
        } 

        // Search functionality
        document.querySelector('.search-box').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                alert('Pesquisando por: ' + this.value);
            }
        });

        // Carousel and WhatsApp button listeners
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.carousel-btn.prev').addEventListener('click', prevSlide);
            document.querySelector('.carousel-btn.next').addEventListener('click', nextSlide);

            document.querySelector('.products-nav.prev').addEventListener('click', prevProduct);
            document.querySelector('.products-nav.next').addEventListener('click', nextProduct);

            const whatsappButton = document.querySelector('.whatsapp-float');
            if (whatsappButton) {
                whatsappButton.addEventListener('click', openWhatsApp);
            }
        });

// Foco automático no campo de pesquisa ao clicar na lupa
document.addEventListener('DOMContentLoaded', () => {
  const searchIcon = document.querySelector('.search-icon');
  const searchBox = document.querySelector('.search-box');

  if (searchIcon && searchBox) {
    searchIcon.addEventListener('click', () => {
      searchBox.focus();
    });
  }
});

// Navigation interactions
// Removed alert handlers; nav items now use default link behavior

// Product click events are now handled by <a> tags in HTML.

// Cart button
// Removed alert handler; cart button now uses default link behavior

// Login button
// Removed alert handler; login button now uses default link behavior

// Footer links now use default link behavior from HTML href attributes.
