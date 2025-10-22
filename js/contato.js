// Toggle FAQ
        function toggleFaq(element) {
            const wasActive = element.classList.contains('active');
            
            // Close all FAQs
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Open clicked FAQ if it wasn't active
            if (!wasActive) {
                element.classList.add('active');
            }
        }

        // Handle form submit
        function handleSubmit(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            
            // Simulate form submission
            showNotification('Mensagem enviada com sucesso! Entraremos em contato em breve.', 'success');
            
            // Reset form
            form.reset();
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Call phone
        function callPhone() {
            window.location.href = 'tel:+553132272071';
            showNotification('Ligando para (31) 3227-2071...', 'success');
        }

        // Send email
        function sendEmail() {
            window.location.href = 'mailto:site@padariavianney.com.br?subject=Contato via Site Vianncy';
            showNotification('Abrindo seu cliente de e-mail...', 'success');
        }

        // Show location
        function showLocation() {
            const mapSection = document.querySelector('.map-section');
            mapSection.scrollIntoView({ behavior: 'smooth' });
            showNotification('Rolando para o mapa...', 'success');
        }

        // Open WhatsApp
        function openWhatsApp() {
            const message = 'Olá! Gostaria de entrar em contato com a Vianncy.';
            window.open(`https://wa.me/5531984059204?text=${encodeURIComponent(message)}`, '_blank');
            showNotification('Abrindo WhatsApp...', 'success');
        }

        // Open social media
        function openSocial(platform) {
            const platforms = {
                'instagram': 'Instagram',
                'facebook': 'Facebook',
                'youtube': 'YouTube'
            };
            
            showNotification(`Redirecionando para ${platforms[platform]}...`, 'success');
            
            setTimeout(() => {
                alert(`Em breve você será redirecionado para nosso ${platforms[platform]}!\n\nSiga-nos para ficar por dentro de todas as novidades, promoções e lançamentos da Vianncy!`);
            }, 1000);
        }

        // Go home
        function goHome() {
            window.location.href = '../html/home.html';
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

        // Phone mask
        document.querySelector('input[type="tel"]')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) {
                value = value.slice(0, 11);
            }
            
            if (value.length > 6) {
                value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7)}`;
            } else if (value.length > 2) {
                value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
            } else if (value.length > 0) {
                value = `(${value}`;
            }
            
            e.target.value = value;
        });

        // Form validation
        document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '' && this.hasAttribute('required')) {
                    this.style.borderColor = '#e74c3c';
                } else {
                    this.style.borderColor = '#e0e0e0';
                }
            });

            input.addEventListener('focus', function() {
                this.style.borderColor = '#F4D03F';
            });
        });

        // Email validation
        document.querySelector('input[type="email"]')?.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(email) && email !== '') {
                this.style.borderColor = '#e74c3c';
                showNotification('Por favor, insira um e-mail válido', 'error');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.contact-card, .faq-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Show welcome message
            setTimeout(() => {
                showNotification('Bem-vindo à página de contato! Estamos prontos para ajudar! 📞', 'success');
            }, 1000);

            // Add hover effect to contact cards
            document.querySelectorAll('.contact-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Auto-expand first FAQ
            const firstFaq = document.querySelector('.faq-item');
            if (firstFaq) {
                setTimeout(() => {
                    firstFaq.classList.add('active');
                }, 1500);
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('.form-input')?.focus();
            }
            
            // ESC to close expanded FAQ
            if (e.key === 'Escape') {
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });
            }
        });

        // Track form interactions for analytics (simulated)
        document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(input => {
            input.addEventListener('change', function() {
                // Here you would send analytics data
                console.log('Form field changed:', this.name || this.placeholder);
            });
        });

        // Contact card click tracking
        document.querySelectorAll('.contact-card').forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('.contact-card-title').textContent;
                console.log('Contact card clicked:', title);
            });
        });

        // Social media click tracking
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const platform = this.textContent.trim();
                console.log('Social media clicked:', platform);
            });
        });

        // Copy email to clipboard on click
        document.querySelectorAll('.info-content a[href^="mailto"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const email = this.textContent;
                
                navigator.clipboard.writeText(email).then(() => {
                    showNotification(`E-mail ${email} copiado para área de transferência!`, 'success');
                }).catch(() => {
                    window.location.href = this.href;
                });
            });
        });

        // Copy phone to clipboard on click
        document.querySelectorAll('.info-content a[href^="tel"]').forEach(link => {
            link.addEventListener('dblclick', function(e) {
                e.preventDefault();
                const phone = this.textContent;
                
                navigator.clipboard.writeText(phone).then(() => {
                    showNotification(`Telefone ${phone} copiado! (Clique simples para ligar)`, 'success');
                });
            });
        });

        // Prevent form resubmission on page reload
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Add loading state to submit button
        document.querySelector('form')?.addEventListener('submit', function() {
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = 'Enviando...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        // Auto-fill form from URL parameters (for marketing campaigns)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('subject')) {
            const subjectSelect = document.querySelector('select.form-select');
            const subject = urlParams.get('subject');
            if (subjectSelect) {
                Array.from(subjectSelect.options).forEach(option => {
                    if (option.value === subject) {
                        option.selected = true;
                    }
                });
            }
        }

        // Show success message if coming from successful form submission
        if (urlParams.has('success')) {
            setTimeout(() => {
                showNotification('Sua mensagem foi enviada com sucesso! Em breve entraremos em contato.', 'success');
            }, 500);
        }