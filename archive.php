<?php
/**
 * Archive
 *
 * Standard loop for the archive page
 */
get_header(); ?>

<?php if (!is_front_page() && !is_home()): ?>
    <?php show_template('hero-banner', array('title' => get_the_title(), 'image' => get_post_thumbnail_id())); ?>
<?php endif; ?>

<main class="main-content">
    <div class="container">
        <div class="row posts-list">
            <div class="col-12 col-sm-12">
                <h2 class="page-title page-title--archive"><?php echo get_the_archive_title(); ?></h2>
            </div>
            <!-- BEGIN of Archive Content -->
            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'parts/loop', 'post' ); // Post item ?>
                    <?php endwhile; ?>
                <?php endif; ?>
                <!-- BEGIN of pagination -->
                <?php bootstrap_pagination(); ?>
                <!-- END of pagination -->
            </div>
            <!-- END of Archive Content -->
            <!-- BEGIN of Sidebar -->
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 sidebar">
                <?php get_sidebar( 'right' ); ?>
            </div>
            <!-- END of Sidebar -->
        </div>
    </div>
</main>


<?php get_footer(); ?>
