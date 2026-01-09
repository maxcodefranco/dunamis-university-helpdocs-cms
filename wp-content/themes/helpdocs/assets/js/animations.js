/**
 * HelpDocs GSAP Animations
 * Animações suaves para melhorar a experiência do usuário
 */

(function() {
    'use strict';

    // Registra ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);

    // Aguarda DOM carregar
    document.addEventListener('DOMContentLoaded', function() {
        initHeroAnimations();
        initCardAnimations();
        initScrollReveal();
        initHeaderAnimation();
        initSmoothScroll();
    });

    /**
     * Animações do Hero Section
     */
    function initHeroAnimations() {
        const heroSection = document.querySelector('.home-hero');
        if (!heroSection) return;

        const timeline = gsap.timeline({ defaults: { ease: 'power3.out' } });

        // Anima título principal
        timeline.from('.home-hero h1', {
            y: 50,
            opacity: 0,
            duration: 0.8,
            delay: 0.2
        });

        // Anima descrição
        timeline.from('.home-hero p', {
            y: 30,
            opacity: 0,
            duration: 0.6
        }, '-=0.4');

        // Anima campo de busca
        timeline.from('.home-hero form', {
            y: 30,
            opacity: 0,
            duration: 0.6,
            scale: 0.95
        }, '-=0.3');
    }

    /**
     * Animações dos Cards de Categoria
     */
    function initCardAnimations() {
        const cards = document.querySelectorAll('.help-card, article');
        if (!cards.length) return;

        cards.forEach((card, index) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                },
                y: 60,
                opacity: 0,
                duration: 0.6,
                delay: index * 0.1,
                ease: 'power2.out'
            });

            // Animação no hover
            card.addEventListener('mouseenter', function() {
                gsap.to(card, {
                    y: -8,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            card.addEventListener('mouseleave', function() {
                gsap.to(card, {
                    y: 0,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });
    }

    /**
     * Scroll Reveal - Elementos aparecem ao scroll
     */
    function initScrollReveal() {
        // Títulos de seção
        gsap.utils.toArray('section h2, section h3').forEach(heading => {
            gsap.from(heading, {
                scrollTrigger: {
                    trigger: heading,
                    start: 'top 90%',
                    toggleActions: 'play none none reverse'
                },
                x: -50,
                opacity: 0,
                duration: 0.8,
                ease: 'power3.out'
            });
        });

        // Parágrafos
        gsap.utils.toArray('section p').forEach(paragraph => {
            gsap.from(paragraph, {
                scrollTrigger: {
                    trigger: paragraph,
                    start: 'top 92%',
                    toggleActions: 'play none none reverse'
                },
                y: 30,
                opacity: 0,
                duration: 0.6,
                ease: 'power2.out'
            });
        });

        // Botões
        gsap.utils.toArray('.btn-primary, .btn-secondary, .btn').forEach(button => {
            gsap.from(button, {
                scrollTrigger: {
                    trigger: button,
                    start: 'top 92%',
                    toggleActions: 'play none none reverse'
                },
                scale: 0.9,
                opacity: 0,
                duration: 0.5,
                ease: 'back.out(1.7)'
            });
        });
    }

    /**
     * Animação do Header ao scroll
     */
    function initHeaderAnimation() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScroll = 0;

        ScrollTrigger.create({
            start: 'top -80',
            end: 99999,
            onUpdate: (self) => {
                const currentScroll = self.scroll();

                if (currentScroll > lastScroll && currentScroll > 100) {
                    // Scrolling down - esconde header
                    gsap.to(header, {
                        y: -100,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                } else {
                    // Scrolling up - mostra header
                    gsap.to(header, {
                        y: 0,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                }

                lastScroll = currentScroll;
            }
        });

        // Adiciona sombra ao header no scroll
        ScrollTrigger.create({
            start: 'top -1',
            end: 99999,
            onEnter: () => {
                header.classList.add('scrolled');
                gsap.to(header, {
                    boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                    duration: 0.3
                });
            },
            onLeaveBack: () => {
                header.classList.remove('scrolled');
                gsap.to(header, {
                    boxShadow: '0 0 0 rgba(0, 0, 0, 0)',
                    duration: 0.3
                });
            }
        });
    }

    /**
     * Smooth Scroll para âncoras
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));

                if (target) {
                    e.preventDefault();

                    gsap.to(window, {
                        duration: 1,
                        scrollTo: {
                            y: target,
                            offsetY: 100
                        },
                        ease: 'power3.inOut'
                    });
                }
            });
        });
    }

    /**
     * Animação do TOC (Table of Contents) nos manuais
     */
    function initTocAnimations() {
        const toc = document.querySelector('#toc');
        if (!toc) return;

        // Anima entrada do TOC
        gsap.from(toc, {
            x: -50,
            opacity: 0,
            duration: 0.8,
            delay: 0.3,
            ease: 'power3.out'
        });

        // Anima cada item do TOC
        const tocItems = toc.querySelectorAll('li');
        tocItems.forEach((item, index) => {
            gsap.from(item, {
                x: -30,
                opacity: 0,
                duration: 0.4,
                delay: 0.5 + (index * 0.05),
                ease: 'power2.out'
            });
        });

        // Highlight suave ao clicar
        tocItems.forEach(item => {
            const link = item.querySelector('a');
            if (link) {
                link.addEventListener('click', function() {
                    // Remove active de todos
                    tocItems.forEach(i => i.querySelector('a')?.classList.remove('active'));

                    // Adiciona active ao clicado
                    this.classList.add('active');

                    // Animação de pulso
                    gsap.fromTo(this,
                        { scale: 1 },
                        {
                            scale: 1.05,
                            duration: 0.2,
                            yoyo: true,
                            repeat: 1
                        }
                    );
                });
            }
        });
    }

    // Inicializa animações do TOC se existir
    if (document.querySelector('#toc')) {
        initTocAnimations();
    }

    /**
     * Animações dos botões de feedback
     */
    function initFeedbackAnimations() {
        const feedbackButtons = document.querySelectorAll('.feedback-btn');
        if (!feedbackButtons.length) return;

        feedbackButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('active')) {
                    // Animação de sucesso
                    gsap.fromTo(this,
                        { scale: 1 },
                        {
                            scale: 1.1,
                            duration: 0.2,
                            yoyo: true,
                            repeat: 1,
                            ease: 'power2.inOut',
                            onComplete: () => {
                                gsap.to(this, {
                                    backgroundColor: '#fa5329',
                                    color: '#ffffff',
                                    duration: 0.3
                                });
                            }
                        }
                    );
                }
            });
        });
    }

    // Inicializa animações de feedback
    initFeedbackAnimations();

    /**
     * Parallax suave em elementos
     */
    function initParallax() {
        gsap.utils.toArray('.hero-pattern, .background-pattern').forEach(element => {
            gsap.to(element, {
                scrollTrigger: {
                    trigger: element,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1
                },
                y: 100,
                ease: 'none'
            });
        });
    }

    // Inicializa parallax se existir
    if (document.querySelector('.hero-pattern, .background-pattern')) {
        initParallax();
    }

    /**
     * Fade in progressivo para listas
     */
    function initListAnimations() {
        gsap.utils.toArray('ul li, ol li').forEach((item, index) => {
            gsap.from(item, {
                scrollTrigger: {
                    trigger: item,
                    start: 'top 95%',
                    toggleActions: 'play none none reverse'
                },
                x: -20,
                opacity: 0,
                duration: 0.4,
                delay: index * 0.05,
                ease: 'power2.out'
            });
        });
    }

    // Inicializa animações de lista
    initListAnimations();

})();
