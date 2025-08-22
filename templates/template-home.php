<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<!--HOME PAGE SLIDER-->
<?php home_slider_template(); ?>
<!--END of HOME PAGE SLIDER-->

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <!-- BEGIN of main content -->
        <div id="main-content" class="container">
            <div class="row">
                <div class="col-12">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <!-- END of main content -->

        <!-- Flexible Content -->
        <?php if ( have_rows( 'flexible_content' ) ): ?>
            <?php while ( have_rows( 'flexible_content' ) ): the_row(); ?>
                <?php $layout = get_row_layout(); ?>
                <?php get_template_part( 'parts/flexible/flexible', $layout ); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
