<?php
/**
 * Template Index (Fallback)
 *
 * @package HelpDocs
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">

        <?php if (have_posts()) : ?>

            <header class="page-header mb-8">
                <?php if (is_home()) : ?>
                    <h1 class="text-4xl font-bold mb-4" style="color: #190e2ca8;">
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    </h1>
                    <p class="text-lg text-gray-600">
                        <?php echo esc_html(get_bloginfo('description')); ?>
                    </p>
                <?php elseif (is_archive()) : ?>
                    <h1 class="text-4xl font-bold mb-4" style="color: #190e2ca8;">
                        <?php the_archive_title(); ?>
                    </h1>
                    <?php the_archive_description('<div class="text-gray-600">', '</div>'); ?>
                <?php elseif (is_search()) : ?>
                    <h1 class="text-4xl font-bold mb-4" style="color: #190e2ca8;">
                        Resultados da busca por: <?php echo get_search_query(); ?>
                    </h1>
                <?php endif; ?>
            </header>

            <div class="posts-list space-y-8">
                <?php while (have_posts()) : the_post(); ?>

                    <article <?php post_class('bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('helpdocs-featured', ['class' => 'w-full h-64 object-cover', 'loading' => 'lazy']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="p-6">
                            <header class="entry-header mb-4">
                                <?php
                                the_title(
                                    '<h2 class="text-2xl font-bold mb-2"><a href="' . esc_url(get_permalink()) . '" class="hover:text-[#fa5329] transition-colors">',
                                    '</a></h2>'
                                );
                                ?>

                                <div class="entry-meta text-sm text-gray-500 flex items-center gap-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <?php echo get_the_date(); ?>
                                    </span>

                                    <?php if (has_category()) : ?>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </header>

                            <div class="entry-excerpt text-gray-700 mb-4">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-[#fa5329] font-semibold hover:gap-3 transition-all">
                                Leia mais
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
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
                'class'     => 'mt-12',
            ));
            ?>

        <?php else : ?>

            <div class="no-results bg-white rounded-lg shadow-md p-12 text-center">
                <h2 class="text-3xl font-bold mb-4" style="color: #190e2ca8;">
                    Nenhum conteúdo encontrado
                </h2>
                <p class="text-gray-600 mb-6">
                    Desculpe, não encontramos o que você está procurando.
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary inline-block">
                    Voltar para a home
                </a>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
