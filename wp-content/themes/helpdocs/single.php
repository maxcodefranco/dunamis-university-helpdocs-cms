<?php
/**
 * Template Single Post
 * Layout com sidebar condicional para categoria Manuais
 *
 * @package HelpDocs
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">

    <?php while (have_posts()) : the_post(); ?>

        <?php if (has_category('manuais')) : ?>
            <!-- Layout com Sidebar (Manuais) -->
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Sidebar com Índice -->
                <aside class="lg:w-1/4 sidebar-manual">
                    <?php if (isset($GLOBALS['helpdocs_toc'])) : ?>
                        <?php echo $GLOBALS['helpdocs_toc']; ?>
                    <?php endif; ?>
                </aside>

                <!-- Conteúdo Principal -->
                <article <?php post_class('lg:w-3/4 bg-white rounded-lg shadow-md p-8'); ?>>

                    <header class="entry-header mb-6">
                        <?php the_title('<h1 class="text-4xl font-bold mb-4" style="color: #190e2ca8;">', '</h1>'); ?>

                        <div class="entry-meta text-sm text-gray-500 flex items-center gap-4 pb-4 border-b">
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

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="entry-thumbnail mb-6">
                            <?php the_post_thumbnail('helpdocs-featured', ['class' => 'w-full rounded-lg', 'loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content prose max-w-none">
                        <?php the_content(); ?>
                    </div>

                    <!-- Sistema de Feedback -->
                    <?php get_template_part('templates/feedback'); ?>

                    <!-- Navegação entre Posts -->
                    <nav class="post-navigation mt-8 pt-6 border-t flex justify-between items-center">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>

                        <?php if ($prev_post) : ?>
                            <a href="<?php echo get_permalink($prev_post); ?>" class="flex items-center gap-2 text-[#190e2ca8] hover:text-[#fa5329] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="font-semibold"><?php echo get_the_title($prev_post); ?></span>
                            </a>
                        <?php else : ?>
                            <span></span>
                        <?php endif; ?>

                        <?php if ($next_post) : ?>
                            <a href="<?php echo get_permalink($next_post); ?>" class="flex items-center gap-2 text-[#190e2ca8] hover:text-[#fa5329] transition-colors">
                                <span class="font-semibold"><?php echo get_the_title($next_post); ?></span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </nav>

                </article>

            </div>

        <?php else : ?>
            <!-- Layout Padrão (sem sidebar) -->
            <div class="max-w-4xl mx-auto">

                <article <?php post_class('bg-white rounded-lg shadow-md p-8'); ?>>

                    <header class="entry-header mb-6">
                        <?php the_title('<h1 class="text-4xl font-bold mb-4" style="color: #190e2ca8;">', '</h1>'); ?>

                        <div class="entry-meta text-sm text-gray-500 flex items-center gap-4 pb-4 border-b">
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

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="entry-thumbnail mb-6">
                            <?php the_post_thumbnail('helpdocs-featured', ['class' => 'w-full rounded-lg', 'loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content prose max-w-none">
                        <?php the_content(); ?>
                    </div>

                    <!-- Sistema de Feedback -->
                    <?php get_template_part('templates/feedback'); ?>

                    <!-- Navegação entre Posts -->
                    <nav class="post-navigation mt-8 pt-6 border-t flex justify-between items-center">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>

                        <?php if ($prev_post) : ?>
                            <a href="<?php echo get_permalink($prev_post); ?>" class="flex items-center gap-2 text-[#190e2ca8] hover:text-[#fa5329] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="font-semibold"><?php echo get_the_title($prev_post); ?></span>
                            </a>
                        <?php else : ?>
                            <span></span>
                        <?php endif; ?>

                        <?php if ($next_post) : ?>
                            <a href="<?php echo get_permalink($next_post); ?>" class="flex items-center gap-2 text-[#190e2ca8] hover:text-[#fa5329] transition-colors">
                                <span class="font-semibold"><?php echo get_the_title($next_post); ?></span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </nav>

                </article>

            </div>

        <?php endif; ?>

    <?php endwhile; ?>

</div>

<?php get_footer(); ?>
