 // Animated counter for stats
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target.toLocaleString('pt-BR');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString('pt-BR');
                }
            }, 16);
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    
                    // Animate counters when stats section is visible
                    if (entry.target.classList.contains('stats-section')) {
                        const counters = entry.target.querySelectorAll('.stat-number');
                        counters.forEach(counter => {
                            if (counter.textContent === '0') {
                                animateCounter(counter);
                            }
                        });
                    }
                }
            });
        }, observerOptions);

        // Observe sections for scroll animations
        document.querySelectorAll('.value-card, .timeline-item, .team-member, .stats-section').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease';
            observer.observe(el);
        });



        function goToProducts() {
            showNotification('Redirecionando para produtos...', 'success');
            setTimeout(() => {
                alert('Você será redirecionado para nossa página de produtos!\n\nDescubra todos os sabores artesanais da Vianncy.');
            }, 1000);
        }

        function goToContact() {
            showNotification('Redirecionando para contato...', 'success');
            setTimeout(() => {
                alert('Você será redirecionado para nossa página de contato!\n\nFale conosco e tire todas as suas dúvidas.');
            }, 1000);
        }

        // WhatsApp function
        function openWhatsApp() {
            const message = 'Olá! Conheci a história da Vianncy e gostaria de saber mais sobre os produtos!';
            window.open(`https://wa.me/5531984059204?text=${encodeURIComponent(message)}`, '_blank');
            showNotification('Abrindo WhatsApp...', 'success');
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

        // Parallax effect on hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero-section');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Smooth reveal for story section
        const storyObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.querySelectorAll('.story-content, .story-image').forEach((el, index) => {
                        setTimeout(() => {
                            el.style.opacity = '1';
                            el.style.transform = 'translateX(0)';
                        }, index * 200);
                    });
                }
            });
        }, { threshold: 0.3 });

        const storySection = document.querySelector('.story-section');
        if (storySection) {
            storyObserver.observe(storySection);
        }

        // Timeline items sequential animation
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const items = entry.target.querySelectorAll('.timeline-item');
                    items.forEach((item, index) => {
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, index * 200);
                    });
                }
            });
        }, { threshold: 0.1 });

        const timeline = document.querySelector('.timeline');
        if (timeline) {
            timelineObserver.observe(timeline);
        }

        // Team members hover effect
        document.querySelectorAll('.team-member').forEach(member => {
            member.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.02)';
            });
            
            member.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Value cards staggered animation
        const valuesObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const cards = entry.target.querySelectorAll('.value-card');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 100);
                    });
                }
            });
        }, { threshold: 0.2 });

        const valuesSection = document.querySelector('.values-section');
        if (valuesSection) {
            valuesObserver.observe(valuesSection);
        }

        // Floating circles animation in hero
        document.querySelectorAll('.hero-circle').forEach((circle, index) => {
            setInterval(() => {
                const randomX = Math.random() * 20 - 10;
                const randomY = Math.random() * 20 - 10;
                circle.style.transform = `translate(${randomX}px, ${randomY}px)`;
            }, 3000 + (index * 1000));
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Show welcome message
            setTimeout(() => {
                showNotification('Bem-vindo à história da Vianncy! 🎉', 'success');
            }, 1000);

            // Add scroll indicator
            const hero = document.querySelector('.hero-section');
            const scrollIndicator = document.createElement('div');
            scrollIndicator.style.cssText = `
                position: absolute;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                color: white;
                font-size: 2em;
                animation: bounce 2s infinite;
                cursor: pointer;
            `;
            scrollIndicator.textContent = '↓';
            scrollIndicator.addEventListener('click', () => {
                window.scrollTo({
                    top: hero.offsetHeight,
                    behavior: 'smooth'
                });
            });
            hero.appendChild(scrollIndicator);

            // Add bounce animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes bounce {
                    0%, 20%, 50%, 80%, 100% {
                        transform: translateX(-50%) translateY(0);
                    }
                    40% {
                        transform: translateX(-50%) translateY(-10px);
                    }
                    60% {
                        transform: translateX(-50%) translateY(-5px);
                    }
                }
            `;
            document.head.appendChild(style);

            // Preload images for smoother experience
            const imagesToPreload = [
                'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=600&h=500&fit=crop',
                'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&h=200&fit=crop',
                'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop'
            ];

            imagesToPreload.forEach(src => {
                const img = new Image();
                img.src = src;
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Press 'H' to go home
            if (e.key === 'h' || e.key === 'H') {
                if (!e.target.matches('input, textarea')) {
                    goHome();
                }
            }
            
            // Press 'P' to see products
            if (e.key === 'p' || e.key === 'P') {
                if (!e.target.matches('input, textarea')) {
                    goToProducts();
                }
            }
            
            // Press 'C' to contact
            if (e.key === 'c' || e.key === 'C') {
                if (!e.target.matches('input, textarea')) {
                    goToContact();
                }
            }
        });

        // Track scroll progress
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const windowHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollProgress = (scrolled / windowHeight) * 100;
            
            // Could add a progress bar here
            console.log('Scroll progress:', scrollProgress.toFixed(2) + '%');
        });

        // Easter egg: Click logo 5 times for special message
        let logoClicks = 0;
        document.querySelector('.logo').addEventListener('click', function() {
            logoClicks++;
            if (logoClicks === 5) {
                showNotification('🎉 Você descobriu um segredo! Ganhe 10% de desconto com o cupom: HISTORIA10', 'success');
                logoClicks = 0;
            }
        });

        // Add subtle animations to timeline years
        document.querySelectorAll('.timeline-year').forEach(year => {
            year.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(-50%) scale(1.2) rotate(360deg)';
                this.style.transition = 'all 0.5s ease';
            });
            
            year.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(-50%) scale(1) rotate(0deg)';
            });
        });

        // Random fun fact tooltip
        const funFacts = [
            'Produzimos mais de 1000 pães por dia!',
            'Nossas receitas são passadas de geração em geração.',
            'Usamos mais de 50kg de chocolate belga por semana!',
            'Nosso croissant leva 2 dias para ficar perfeito.',
            'Atendemos mais de 500 clientes diariamente!'
        ];

        setInterval(() => {
            if (Math.random() > 0.95) { // 5% chance
                const randomFact = funFacts[Math.floor(Math.random() * funFacts.length)];
                showNotification('💡 Você sabia? ' + randomFact, 'success');
            }
        }, 30000); // Check every 30 seconds

         // Go home
        function goHome() {
            window.location.href = '../html/home.html';
        }