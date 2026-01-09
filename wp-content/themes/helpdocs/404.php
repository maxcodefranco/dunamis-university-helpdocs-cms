<?php
/**
 * Template 404 Not Found
 *
 * @package HelpDocs
 */

get_header();
?>

<div class="container mx-auto px-4 py-20">
    <div class="max-w-2xl mx-auto text-center">

        <!-- Ilustração 404 -->
        <div class="mb-8">
            <span class="text-9xl">🔍</span>
        </div>

        <h1 class="text-6xl font-bold mb-4" style="color: #190e2ca8;">404</h1>
        <h2 class="text-3xl font-bold mb-6 text-gray-700">Página não encontrada</h2>

        <p class="text-lg text-gray-600 mb-8">
            Desculpe, não conseguimos encontrar a página que você está procurando.
            Ela pode ter sido movida ou não existe mais.
        </p>

        <!-- Busca -->
        <div class="mb-8">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex gap-2 max-w-md mx-auto">
                <input type="search"
                       name="s"
                       placeholder="Buscar ajuda..."
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#fa5329]">
                <button type="submit" class="btn-primary px-6">
                    Buscar
                </button>
            </form>
        </div>

        <!-- Links úteis -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-12">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="help-card group">
                <svg class="w-8 h-8 mx-auto mb-2 text-[#fa5329]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <h3 class="font-bold">Página Inicial</h3>
            </a>

            <?php if (get_cat_ID('Manuais')) : ?>
                <a href="<?php echo esc_url(get_category_link(get_cat_ID('Manuais'))); ?>" class="help-card group">
                    <svg class="w-8 h-8 mx-auto mb-2 text-[#fa5329]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="font-bold">Manuais</h3>
                </a>
            <?php endif; ?>

            <?php if (get_cat_ID('Tutoriais')) : ?>
                <a href="<?php echo esc_url(get_category_link(get_cat_ID('Tutoriais'))); ?>" class="help-card group">
                    <svg class="w-8 h-8 mx-auto mb-2 text-[#fa5329]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-bold">Tutoriais</h3>
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
