</main>

<!-- Footer -->
<footer class="site-footer bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Footer -->
        <div class="py-16 grid grid-cols-1 md:grid-cols-4 gap-12">

            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <img src="https://cdn.prod.website-files.com/64f6f8f3d0b3d9a2cf477aed/65bfa16662ed5413a33112fc_FD-LOGO-p-500.png"
                         alt="Faculdade Dunamis"
                         class="h-10 w-auto"
                         loading="lazy">
                    <span class="text-lg font-medium text-white">
                        Central de Ajuda
                    </span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-md">
                    Central de documentação e suporte da Faculdade Dunamis. Encontre manuais, tutoriais e documentos para aproveitar todos os recursos disponíveis.
                </p>
            </div>

            <!-- Links Rápidos -->
            <div>
                <h3 class="text-white font-bold mb-4">Links Rápidos</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'space-y-3',
                    'container'      => false,
                    'fallback_cb'    => 'helpdocs_footer_menu_fallback',
                    'link_before'    => '<span class="text-sm text-gray-400 hover:text-white transition-colors">',
                    'link_after'     => '</span>',
                ));
                ?>
            </div>

            <!-- Suporte -->
            <div>
                <h3 class="text-white font-bold mb-4">Suporte</h3>
                <div class="space-y-3 text-sm">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="block text-gray-400 hover:text-white transition-colors">
                        Página Inicial
                    </a>
                    <a href="https://faculdadedunamis.com.br" target="_blank" rel="noopener" class="block text-gray-400 hover:text-white transition-colors">
                        Site Institucional
                    </a>
                    <a href="<?php echo esc_url(home_url('/?s=')); ?>" class="block text-gray-400 hover:text-white transition-colors">
                        Buscar Ajuda
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-500">
                    <p>&copy; <?php echo date('Y'); ?> <a href="https://faculdadedunamis.com.br" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors">Faculdade Dunamis</a>. Todos os direitos reservados.</p>
                </div>
                <div class="flex items-center gap-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-colors">Política de Privacidade</a>
                    <a href="#" class="hover:text-white transition-colors">Termos de Uso</a>
                </div>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
