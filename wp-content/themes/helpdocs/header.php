<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gray-50 antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- Header -->
<header class="site-header bg-[#190e2c] border-b border-[#190e2c]/50 sticky top-0 z-50 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <div class="site-branding flex items-center">
                <?php if (has_custom_logo()) : ?>
                    <div class="flex items-center gap-3">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group">
                        <img src="https://cdn.prod.website-files.com/64f6f8f3d0b3d9a2cf477aed/65bfa16662ed5413a33112fc_FD-LOGO-p-500.png"
                             alt="<?php bloginfo('name'); ?>"
                             class="h-10 w-auto transition-transform group-hover:scale-105"
                             loading="eager">
                        <span class="text-lg font-medium text-white">
                            Central de Ajuda
                        </span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Menu Desktop -->
            <nav class="hidden md:flex items-center gap-8">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'flex items-center gap-8',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'link_before'    => '<span class="text-sm font-medium text-gray-200 hover:text-[#fa5329] transition-colors">',
                    'link_after'     => '</span>',
                ));
                ?>

                <!-- Search Icon -->
                <button id="search-toggle" class="p-2 text-gray-200 hover:text-[#fa5329] transition-colors" aria-label="Buscar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-toggle"
                    class="md:hidden p-2 text-gray-200 hover:text-[#fa5329] transition-colors"
                    aria-label="Toggle menu"
                    aria-expanded="false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <nav id="mobile-menu" class="hidden md:hidden pb-6 border-t border-white/10 mt-4 pt-4">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'flex flex-col gap-4',
                'container'      => false,
                'fallback_cb'    => false,
                'link_before'    => '<span class="text-gray-200 hover:text-[#fa5329] transition-colors">',
                'link_after'     => '</span>',
            ));
            ?>

            <!-- Mobile Search -->
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mt-4">
                <input type="search"
                       name="s"
                       placeholder="Buscar..."
                       class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#fa5329] focus:border-transparent text-white placeholder-gray-400"
                       value="<?php echo get_search_query(); ?>">
            </form>
        </nav>
    </div>

    <!-- Search Bar (Desktop - expandable) - Estado inicial controlado por GSAP -->
    <div id="search-bar" class="border-t border-white/10 bg-[#190e2c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex gap-2">
                <input type="search"
                       name="s"
                       placeholder="O que você está procurando?"
                       class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#fa5329] focus:border-transparent text-white placeholder-gray-400"
                       value="<?php echo get_search_query(); ?>"
                       autofocus>
                <button type="submit" class="px-6 py-3 bg-[#fa5329] text-white rounded-lg hover:bg-[#e04720] transition-colors font-medium">
                    Buscar
                </button>
            </form>
        </div>
    </div>
</header>

<main id="main-content" class="site-main min-h-screen">
