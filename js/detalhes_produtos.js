let quantity = 1;
        let cartCount = 0;
        let isFavorite = false;

        // Change main image
        function changeImage(thumbnail) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = thumbnail.src.replace('w=150&h=150', 'w=600&h=600');
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }

        // Toggle favorite
        function toggleFavorite() {
            const btn = document.getElementById('favoriteBtn');
            isFavorite = !isFavorite;
            
            if (isFavorite) {
                btn.textContent = '♥';
                btn.classList.add('active');
                showNotification('Adicionado aos favoritos! ❤️', 'success');
            } else {
                btn.textContent = '♡';
                btn.classList.remove('active');
                showNotification('Removido dos favoritos', 'success');
            }
        }

        // Update quantity
        function updateQuantity(change) {
            quantity = Math.max(1, quantity + change);
            document.getElementById('quantity').textContent = quantity;
        }

        // Show tab
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.classList.add('active');
        }

        
        // WhatsApp function
        function openWhatsApp() {
            const productName = "Mini Sanduiche Focaccia, Pesto de Pistache e Queijo Fresco";
            const price = "R$ 153,80";
            const message = `Olá! Gostaria de saber mais sobre:\n\n${productName}\nPreço: ${price}\n\nObrigado!`;
            
            window.open(`https://wa.me/5531984059204?text=${encodeURIComponent(message)}`, '_blank');
        }

        // Show notification
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

        // Image zoom on hover
        document.getElementById('mainImage')?.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            this.style.transformOrigin = `${x}% ${y}%`;
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === '+' || e.key === '=') {
                updateQuantity(1);
            } else if (e.key === '-') {
                updateQuantity(-1);
            } else if (e.ctrlKey && e.key === 'Enter') {
                addToCart();
            }
        });

        // Scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        document.querySelectorAll('.related-product-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            observer.observe(card);
        });

      

            // Load cart count from storage
            const savedCartCount = localStorage.getItem('vianncy_cart_count');
            if (savedCartCount) {
                cartCount = parseInt(savedCartCount);
                document.getElementById('cartCount').textContent = cartCount;
            }

            // Save cart count
            window.addEventListener('beforeunload', function() {
                localStorage.setItem('vianncy_cart_count', cartCount);
            });

            // Smooth scroll for tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelector('.tabs-section').scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });
        ;

        // Share product
        function shareProduct() {
            if (navigator.share) {
                navigator.share({
                    title: 'Mini Sanduiche Focaccia - Vianncy',
                    text: 'Confira este produto incrível!',
                    url: window.location.href
                }).then(() => {
                    showNotification('Produto compartilhado com sucesso!', 'success');
                }).catch(err => {
                    console.log('Erro ao compartilhar:', err);
                });
            } else {
                // Fallback
                const url = window.location.href;
                navigator.clipboard.writeText(url);
                showNotification('Link copiado para a área de transferência!', 'success');
            }
        }