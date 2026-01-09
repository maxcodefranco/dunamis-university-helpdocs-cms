/**
 * HelpDocs Main JavaScript
 * Scripts customizados para funcionalidades do tema
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        initMobileMenu();
        initSearchToggle();
        initSmoothScroll();
        initTableOfContents();
        initFeedbackSystem();
    });

    /**
     * Menu mobile responsivo
     */
    function initMobileMenu() {
        const menuToggle = $('#mobile-menu-toggle');
        const mobileMenu = $('#mobile-menu');

        menuToggle.on('click', function() {
            mobileMenu.toggleClass('hidden');
            $(this).attr('aria-expanded', function(i, attr) {
                return attr === 'true' ? 'false' : 'true';
            });
        });
    }

    /**
     * Toggle de busca no header (desktop) com animação GSAP
     */
    function initSearchToggle() {
        const searchToggle = $('#search-toggle');
        const searchBar = $('#search-bar');
        let isSearchOpen = false;

        if (searchToggle.length && searchBar.length) {
            const searchBarEl = searchBar[0];
            const searchInput = searchBar.find('input[type="search"]');

            // Estado inicial - escondido
            gsap.set(searchBarEl, {
                height: 0,
                opacity: 0,
                overflow: 'hidden',
                display: 'none'
            });

            // Função para abrir
            function openSearch() {
                isSearchOpen = true;
                searchToggle.attr('aria-expanded', 'true');

                gsap.set(searchBarEl, { display: 'block' });

                gsap.to(searchBarEl, {
                    height: 'auto',
                    opacity: 1,
                    duration: 0.4,
                    ease: 'power3.out',
                    onComplete: function() {
                        searchInput.focus();
                    }
                });

                // Anima ícone de busca
                gsap.to('#search-toggle svg', {
                    scale: 0.9,
                    rotation: 90,
                    duration: 0.3,
                    ease: 'back.out(2)'
                });
            }

            // Função para fechar
            function closeSearch() {
                isSearchOpen = false;
                searchToggle.attr('aria-expanded', 'false');

                gsap.to(searchBarEl, {
                    height: 0,
                    opacity: 0,
                    duration: 0.3,
                    ease: 'power3.in',
                    onComplete: function() {
                        gsap.set(searchBarEl, { display: 'none' });
                    }
                });

                // Reseta ícone de busca
                gsap.to('#search-toggle svg', {
                    scale: 1,
                    rotation: 0,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            }

            // Toggle ao clicar no botão
            searchToggle.on('click', function(e) {
                e.stopPropagation();
                if (isSearchOpen) {
                    closeSearch();
                } else {
                    openSearch();
                }
            });

            // Previne fechar ao clicar dentro do search bar
            searchBar.on('click', function(e) {
                e.stopPropagation();
            });

            // Fechar ao clicar fora
            $(document).on('click', function(e) {
                if (isSearchOpen && !$(e.target).closest('#search-toggle, #search-bar').length) {
                    closeSearch();
                }
            });

            // Fechar com ESC
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && isSearchOpen) {
                    closeSearch();
                    searchToggle.focus(); // Retorna foco ao botão
                }
            });
        }
    }

    /**
     * Scroll suave para âncoras
     */
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));

            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });
    }

    /**
     * Highlight ativo no índice (Table of Contents)
     */
    function initTableOfContents() {
        if (!$('#toc').length) return;

        const toc = $('#toc');
        const headings = $('h2[id], h3[id]');

        if (headings.length === 0) return;

        $(window).on('scroll', function() {
            let current = '';

            headings.each(function() {
                const heading = $(this);
                const headingTop = heading.offset().top;

                if ($(window).scrollTop() >= headingTop - 150) {
                    current = heading.attr('id');
                }
            });

            // Remove active de todos
            toc.find('a').removeClass('active');

            // Adiciona active no atual
            if (current) {
                toc.find('a[href="#' + current + '"]').addClass('active');
            }
        });
    }

    /**
     * Sistema de feedback "Isso ajudou?"
     */
    function initFeedbackSystem() {
        $('.feedback-btn').on('click', function() {
            const btn = $(this);
            const postId = btn.data('post-id');
            const feedbackType = btn.data('feedback');

            // Previne múltiplos cliques
            if (btn.hasClass('active') || btn.prop('disabled')) {
                return;
            }

            // Envia via AJAX
            $.ajax({
                url: helpdocs_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'helpdocs_feedback',
                    nonce: helpdocs_ajax.nonce,
                    post_id: postId,
                    feedback: feedbackType
                },
                beforeSend: function() {
                    btn.prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        // Marca como ativo
                        $('.feedback-btn').removeClass('active');
                        btn.addClass('active');

                        // Salva no localStorage para persistir
                        localStorage.setItem('feedback_' + postId, feedbackType);

                        // Mensagem de sucesso
                        showFeedbackMessage('Obrigado pelo seu feedback!', 'success');
                    } else {
                        showFeedbackMessage('Erro ao enviar feedback. Tente novamente.', 'error');
                        btn.prop('disabled', false);
                    }
                },
                error: function() {
                    showFeedbackMessage('Erro ao enviar feedback. Tente novamente.', 'error');
                    btn.prop('disabled', false);
                }
            });
        });

        // Verifica se já votou (localStorage)
        $('.feedback-btn').each(function() {
            const btn = $(this);
            const postId = btn.data('post-id');
            const savedFeedback = localStorage.getItem('feedback_' + postId);

            if (savedFeedback === btn.data('feedback')) {
                btn.addClass('active');
                btn.prop('disabled', true);
            }
        });
    }

    /**
     * Mostra mensagem de feedback
     */
    function showFeedbackMessage(message, type) {
        const messageEl = $('<div>')
            .addClass('feedback-message')
            .addClass(type === 'success' ? 'text-green-600' : 'text-red-600')
            .text(message)
            .css({
                'margin-top': '0.5rem',
                'font-size': '0.875rem',
                'font-weight': '500'
            });

        $('.feedback-buttons').append(messageEl);

        setTimeout(function() {
            messageEl.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }

})(jQuery);
