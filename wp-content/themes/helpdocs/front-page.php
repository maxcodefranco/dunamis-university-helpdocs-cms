<?php
/**
 * Template da Home - HelpDocs
 * Layout profissional e clean
 *
 * @package HelpDocs
 */

get_header();
?>

<!-- Hero Section -->
<section class="bg-gradient-to-b from-white to-gray-50 py-20 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Como podemos ajudar você?
            </h1>
            <p class="text-lg text-gray-600 mb-10">
                Encontre respostas, guias e tutoriais para aproveitar ao máximo os recursos da Faculdade Dunamis
            </p>

            <!-- Search Box -->
            <div class="relative max-w-2xl mx-auto">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="relative">
                        <input type="search"
                               name="s"
                               placeholder="Pesquise por tópicos, tutoriais, manuais..."
                               class="w-full px-6 py-4 pr-14 bg-white border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#fa5329] focus:border-transparent shadow-sm text-gray-900 placeholder-gray-500"
                               value="<?php echo get_search_query(); ?>">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-[#fa5329] transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Main Categories -->
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Title -->
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Navegue por categoria</h2>
            <p class="text-gray-600">Escolha o tipo de conteúdo que você procura</p>
        </div>

        <!-- Category Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Manuais -->
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Manuais'))); ?>"
               class="group bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-[#fa5329] hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-[#190e2ca8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#fa5329] transition-colors">
                    Manuais
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Guias completos passo a passo com índice interativo para navegar entre seções
                </p>
                <div class="mt-6 flex items-center text-sm font-medium text-[#fa5329] group-hover:gap-2 transition-all">
                    <span>Ver manuais</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Tutoriais -->
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Tutoriais'))); ?>"
               class="group bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-[#fa5329] hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-[#fa5329]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#fa5329] transition-colors">
                    Tutoriais
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Aprenda rapidamente com tutoriais práticos e objetivos sobre ferramentas e recursos
                </p>
                <div class="mt-6 flex items-center text-sm font-medium text-[#fa5329] group-hover:gap-2 transition-all">
                    <span>Ver tutoriais</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Documentos -->
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Documentos'))); ?>"
               class="group bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-[#fa5329] hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[#fa5329] transition-colors">
                    Documentos
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Acesse documentos oficiais, regulamentos, políticas e formulários importantes
                </p>
                <div class="mt-6 flex items-center text-sm font-medium text-[#fa5329] group-hover:gap-2 transition-all">
                    <span>Ver documentos</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- Recent Content -->
<?php
$recent_posts = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
));

if ($recent_posts->have_posts()) :
?>
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Conteúdo recente</h2>
                <p class="text-gray-600">Últimas adições e atualizações</p>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                <article class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:border-[#fa5329] hover:shadow-lg transition-all duration-300 group">

                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden bg-gray-100">
                            <?php the_post_thumbnail('helpdocs-featured', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300', 'loading' => 'lazy']); ?>
                        </a>
                    <?php endif; ?>

                    <div class="p-6">
                        <!-- Category Badge -->
                        <?php
                        $categories = get_the_category();
                        if ($categories) :
                            $cat = $categories[0];
                        ?>
                            <div class="mb-3">
                                <span class="inline-block px-3 py-1 text-xs font-medium text-[#fa5329] bg-orange-50 rounded-full">
                                    <?php echo esc_html($cat->name); ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-[#fa5329] transition-colors">
                            <a href="<?php the_permalink(); ?>" class="line-clamp-2">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                        </p>

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                            <a href="<?php the_permalink(); ?>" class="text-[#fa5329] font-medium hover:underline">
                                Ler mais →
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-[#190e2ca8] to-[#190e2c] rounded-3xl p-12 lg:p-16 text-center text-white relative overflow-hidden">

            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
            </div>

            <div class="relative z-10">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                    Não encontrou o que procura?
                </h2>
                <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                    Nossa equipe está pronta para ajudar com qualquer dúvida
                </p>
                <a href="https://faculdadedunamis.com.br" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-8 py-4 bg-[#fa5329] hover:bg-[#e04720] text-white rounded-xl font-semibold transition-all hover:scale-105 shadow-lg">
                    <span>Falar com Suporte</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
