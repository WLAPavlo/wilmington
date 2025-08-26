<?php
/**
 * Template Name: Careers Page
 */
get_header(); ?>

    <main class="main-content template-careers" style="padding: 0;">
        <!-- Flexible Content for Careers -->
        <?php if ( have_rows( 'flexible_content' ) ): ?>
            <?php while ( have_rows( 'flexible_content' ) ): the_row(); ?>
                <?php $layout = get_row_layout(); ?>
                <?php get_template_part( 'parts/flexible/flexible', $layout ); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </main>

<?php get_footer(); ?>