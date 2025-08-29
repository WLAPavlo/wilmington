<?php
/**
 * Single
 *
 * Loop container for single post content
 */
get_header(); ?>

<?php if ( ! is_front_page() && ! is_home() ): ?>
    <?php show_template( 'hero-banner', array( 'title' => get_the_title() ) ); ?>
<?php endif; ?>

<main class="main-content">
    <div class="container">
        <div class="row">
            <!-- BEGIN of post content -->
            <div class="col-12">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
                            <h1 class="page-title entry__title"><?php the_title(); ?></h1>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div title="<?php the_title_attribute(); ?>" class="entry__thumb">
                                    <?php the_post_thumbnail( 'large' ); ?>
                                </div>
                            <?php endif; ?>
                            <p class="entry__meta"><?php echo sprintf( __( 'Written by %s on %s', 'default' ), get_the_author_posts_link(), get_the_time( get_option( 'date_format' ) ) ); ?></p>
                            <div class="entry__content clearfix">
                                <?php the_content( '', true ); ?>
                            </div>
                            <h6 class="entry__cat"><?php _e( 'Posted Under: ', 'default' ); ?><?php the_category( ', ' ); ?></h6>
                            <?php comments_template(); ?>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <!-- END of post content -->
        </div>
    </div>
</main>

<?php get_footer(); ?>
