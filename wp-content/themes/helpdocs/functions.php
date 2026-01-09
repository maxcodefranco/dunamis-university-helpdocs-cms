<?php
/**
 * HelpDocs Theme Functions
 *
 * @package HelpDocs
 * @since 1.0.0
 */

// Evita acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define constantes do tema
 */
define('HELPDOCS_THEME_VERSION', '1.0.0');
define('HELPDOCS_THEME_DIR', get_template_directory());
define('HELPDOCS_THEME_URI', get_template_directory_uri());

/**
 * Configuração do tema
 */
function helpdocs_theme_setup() {
    // Adiciona suporte a título dinâmico
    add_theme_support('title-tag');

    // Adiciona suporte a imagens destacadas
    add_theme_support('post-thumbnails');

    // Adiciona suporte a HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // Adiciona suporte a editor de blocos (Gutenberg)
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');

    // Adiciona suporte a feed automático
    add_theme_support('automatic-feed-links');

    // Suporte a categorias e tags (nativo para posts)
    add_theme_support('post-categories');
    add_theme_support('post-tags');

    // Registra menus
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'helpdocs'),
        'footer' => __('Menu Rodapé', 'helpdocs'),
    ));

    // Tamanhos de imagem customizados
    add_image_size('helpdocs-featured', 1200, 600, true);
    add_image_size('helpdocs-thumbnail', 400, 300, true);
}
add_action('after_setup_theme', 'helpdocs_theme_setup');

/**
 * Cria categorias padrão ao ativar o tema
 */
function helpdocs_create_default_categories() {
    // Array com categorias padrão
    $default_categories = array(
        array(
            'name' => 'Manuais',
            'slug' => 'manuais',
            'description' => 'Guias completos passo a passo para usar sistemas e plataformas da Faculdade Dunamis'
        ),
        array(
            'name' => 'Tutoriais',
            'slug' => 'tutoriais',
            'description' => 'Aprenda rapidamente com tutoriais práticos e dicas úteis sobre ferramentas e recursos'
        ),
        array(
            'name' => 'Documentos',
            'slug' => 'documentos',
            'description' => 'Acesse documentos oficiais, políticas, regulamentos e formulários importantes'
        )
    );

    foreach ($default_categories as $category) {
        // Verifica se a categoria já existe
        if (!term_exists($category['slug'], 'category')) {
            wp_insert_term(
                $category['name'],
                'category',
                array(
                    'slug' => $category['slug'],
                    'description' => $category['description']
                )
            );
        }
    }
}
add_action('after_switch_theme', 'helpdocs_create_default_categories');

/**
 * Habilita categorias e tags no editor Gutenberg
 */
function helpdocs_enable_taxonomy_rest() {
    global $wp_taxonomies;

    // Garante que categorias e tags estejam disponíveis na REST API
    if (isset($wp_taxonomies['category'])) {
        $wp_taxonomies['category']->show_in_rest = true;
        $wp_taxonomies['category']->rest_base = 'categories';
        $wp_taxonomies['category']->rest_controller_class = 'WP_REST_Terms_Controller';
    }

    if (isset($wp_taxonomies['post_tag'])) {
        $wp_taxonomies['post_tag']->show_in_rest = true;
        $wp_taxonomies['post_tag']->rest_base = 'tags';
        $wp_taxonomies['post_tag']->rest_controller_class = 'WP_REST_Terms_Controller';
    }
}
add_action('init', 'helpdocs_enable_taxonomy_rest', 30);

/**
 * Garante que o painel de categorias esteja visível no editor
 */
function helpdocs_show_category_panel() {
    return true;
}
add_filter('rest_endpoints', 'helpdocs_show_category_panel');

/**
 * Enqueue scripts e styles
 */
function helpdocs_enqueue_assets() {
    // Tailwind CSS v4 via CDN (para desenvolvimento) - usando @tailwindcss/browser
    wp_enqueue_script(
        'tailwindcss',
        'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4',
        array(),
        '4',
        false // Carregar no head para processar antes do render
    );

    // Google Fonts - Montserrat
    wp_enqueue_style(
        'google-fonts-montserrat',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap',
        array(),
        null
    );

    // Style.css do tema
    wp_enqueue_style(
        'helpdocs-style',
        get_stylesheet_uri(),
        array(),
        HELPDOCS_THEME_VERSION
    );

    // CSS customizado
    if (file_exists(HELPDOCS_THEME_DIR . '/assets/css/custom.css')) {
        wp_enqueue_style(
            'helpdocs-custom',
            HELPDOCS_THEME_URI . '/assets/css/custom.css',
            array('helpdocs-style'),
            HELPDOCS_THEME_VERSION
        );
    }

    // GSAP - GreenSock Animation Platform
    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
        array(),
        '3.12.5',
        true
    );

    // GSAP ScrollTrigger Plugin
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.12.5',
        true
    );

    // Animações GSAP customizadas
    if (file_exists(HELPDOCS_THEME_DIR . '/assets/js/animations.js')) {
        wp_enqueue_script(
            'helpdocs-animations',
            HELPDOCS_THEME_URI . '/assets/js/animations.js',
            array('gsap', 'gsap-scrolltrigger'),
            HELPDOCS_THEME_VERSION,
            true
        );
    }

    // JavaScript principal
    if (file_exists(HELPDOCS_THEME_DIR . '/assets/js/main.js')) {
        wp_enqueue_script(
            'helpdocs-main',
            HELPDOCS_THEME_URI . '/assets/js/main.js',
            array('jquery', 'gsap'),
            HELPDOCS_THEME_VERSION,
            true
        );

        // Localizar script para AJAX
        wp_localize_script('helpdocs-main', 'helpdocs_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('helpdocs_ajax_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'helpdocs_enqueue_assets');

/**
 * Adiciona classes body customizadas
 */
function helpdocs_body_classes($classes) {
    // Adiciona classe para categoria
    if (is_category()) {
        $category = get_queried_object();
        $classes[] = 'category-' . $category->slug;
    }

    // Adiciona classe para post com categoria manuais
    if (is_single() && has_category('manuais')) {
        $classes[] = 'single-manual';
        $classes[] = 'has-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'helpdocs_body_classes');

/**
 * Registra widget areas
 */
function helpdocs_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Manual', 'helpdocs'),
        'id'            => 'sidebar-manual',
        'description'   => __('Aparece na lateral de posts da categoria Manuais', 'helpdocs'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title font-bold text-lg mb-2">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'helpdocs_widgets_init');

/**
 * Gera índice de conteúdo baseado em headings
 */
function helpdocs_generate_table_of_contents($content) {
    if (!is_single() || !has_category('manuais')) {
        return $content;
    }

    // Extrai H2 e H3 do conteúdo
    preg_match_all('/<h([23])>(.*?)<\/h[23]>/i', $content, $matches, PREG_SET_ORDER);

    if (empty($matches)) {
        return $content;
    }

    $toc = '<nav class="table-of-contents bg-gray-50 p-4 rounded-lg sticky top-4" id="toc">';
    $toc .= '<h3 class="font-bold text-lg mb-4" style="color: #190e2ca8;">Índice</h3>';
    $toc .= '<ul class="space-y-2 text-sm">';

    foreach ($matches as $index => $heading) {
        $level = $heading[1];
        $text = strip_tags($heading[2]);
        $id = 'heading-' . $index;

        // Adiciona ID ao heading original no conteúdo
        $content = preg_replace(
            '/' . preg_quote($heading[0], '/') . '/',
            '<h' . $level . ' id="' . $id . '">' . $heading[2] . '</h' . $level . '>',
            $content,
            1
        );

        $indent_class = ($level == 3) ? 'ml-4' : '';
        $toc .= '<li class="' . $indent_class . '"><a href="#' . $id . '" class="hover:text-[#fa5329] transition-colors">' . esc_html($text) . '</a></li>';
    }

    $toc .= '</ul>';
    $toc .= '</nav>';

    // Salva o TOC em uma variável global para usar no template
    $GLOBALS['helpdocs_toc'] = $toc;

    return $content;
}
add_filter('the_content', 'helpdocs_generate_table_of_contents', 9);

/**
 * Remove admin bar do front-end para todos os usuários
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Fallback para menu do footer
 */
function helpdocs_footer_menu_fallback() {
    echo '<div class="space-y-3 text-sm">';
    echo '<a href="' . esc_url(home_url('/')) . '" class="block text-gray-400 hover:text-white transition-colors">Início</a>';
    echo '<a href="' . esc_url(get_category_link(get_cat_ID('Manuais'))) . '" class="block text-gray-400 hover:text-white transition-colors">Manuais</a>';
    echo '<a href="' . esc_url(get_category_link(get_cat_ID('Tutoriais'))) . '" class="block text-gray-400 hover:text-white transition-colors">Tutoriais</a>';
    echo '<a href="' . esc_url(get_category_link(get_cat_ID('Documentos'))) . '" class="block text-gray-400 hover:text-white transition-colors">Documentos</a>';
    echo '</div>';
}

/**
 * Configura permalinks amigáveis automaticamente
 */
function helpdocs_set_permalink_structure() {
    global $wp_rewrite;

    // Configura estrutura de permalink
    if (get_option('permalink_structure') == '') {
        update_option('rewrite_rules', false);
        $wp_rewrite->set_permalink_structure('/%postname%/');
    }

    // Altera base de categoria de 'category' para 'categorias'
    $wp_rewrite->category_base = 'categorias';

    // Flush rewrite rules para aplicar mudanças
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'helpdocs_set_permalink_structure');

/**
 * Mantém a base de categoria como 'categorias'
 */
function helpdocs_change_category_base() {
    global $wp_rewrite;
    $wp_rewrite->category_base = 'categorias';
}
add_action('init', 'helpdocs_change_category_base');

/**
 * Inclui arquivos adicionais
 */
require_once HELPDOCS_THEME_DIR . '/inc/feedback.php';

/**
 * Desabilita editor de arquivos do WordPress (segurança)
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}
