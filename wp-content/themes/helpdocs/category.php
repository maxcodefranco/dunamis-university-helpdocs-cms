<?php
/**
 * Template Category Archive
 *
 * @package HelpDocs
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">

    <div class="max-w-6xl mx-auto">

        <!-- Header da Categoria -->
        <header class="category-header mb-12 text-center">
            <?php
            $category = get_queried_object();
            $icon = '📄';
            if (stripos($category->name, 'Manual') !== false) $icon = '📚';
            elseif (stripos($category->name, 'Tutorial') !== false) $icon = '▶️';
            elseif (stripos($category->name, 'Documento') !== false) $icon = '📄';
            ?>

            <div class="text-6xl mb-4"><?php echo $icon; ?></div>

            <h1 class="text-5xl font-bold mb-4" style="color: #190e2ca8;">
                <?php single_cat_title(); ?>
            </h1>

            <?php if (category_description()) : ?>
                <div class="text-lg text-gray-600 max-w-3xl mx-auto">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>

            <div class="mt-6 text-sm text-gray-500">
                <?php echo $wp_query->found_posts; ?> <?php echo ($wp_query->found_posts == 1) ? 'item encontrado' : 'itens encontrados'; ?>
            </div>
        </header>

        <?php if (have_posts()) : ?>

            <!-- Grid de Posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

                <?php while (have_posts()) : the_post(); ?>

                    <article <?php post_class('bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all transform hover:-translate-y-1'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('helpdocs-thumbnail', [
                                        'class' => 'w-full h-48 object-cover',
                                        'loading' => 'lazy'
                                    ]); ?>
                                </a>
                            </div>
                        <?php else : ?>
                            <div class="w-full h-48 bg-gradient-to-br from-[#190e2ca8] to-[#190e2c] flex items-center justify-center">
                                <span class="text-6xl"><?php echo $icon; ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="p-6">
                            <header class="entry-header mb-3">
                                <?php the_title(
                                    '<h2 class="text-xl font-bold mb-2"><a href="' . esc_url(get_permalink()) . '" class="hover:text-[#fa5329] transition-colors">',
                                    '</a></h2>'
                                ); ?>
                            </header>

                            <div class="entry-excerpt text-gray-600 text-sm mb-4">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </div>

                            <div class="entry-meta text-xs text-gray-500 flex items-center justify-between">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo get_the_date(); ?>
                                </span>

                                <a href="<?php the_permalink(); ?>" class="text-[#fa5329] font-semibold hover:underline">
                                    Ler mais →
                                </a>
                            </div>
                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

            <!-- Paginação -->
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('&laquo; Anterior', 'helpdocs'),
                'next_text' => __('Próximo &raquo;', 'helpdocs'),
                'class'     => 'flex justify-center gap-2',
            ));
            ?>

        <?php else : ?>

            <div class="no-results bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🔍</div>
                <h2 class="text-3xl font-bold mb-4" style="color: #190e2ca8;">
                    Nenhum conteúdo encontrado
                </h2>
                <p class="text-gray-600 mb-6">
                    Ainda não há conteúdo nesta categoria.
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary inline-block">
                    Voltar para a home
                </a>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php get_footer(); ?>
