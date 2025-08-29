<?php
/**
 * Single Career Page
 */
get_header(); ?>

<?php if (!is_front_page() && !is_home()): ?>
    <?php show_template('hero-banner', array('title' => get_the_title(), 'image' => get_post_thumbnail_id())); ?>
<?php endif; ?>

    <main class="main-content">
        <div class="container">
            <div class="row">
                <!-- BEGIN of career content -->
                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article id="career-<?php the_ID(); ?>" <?php post_class('entry career-single'); ?>>
                                <!-- Career Header -->
                                <div class="career-single__header">
                                    <h1 class="page-title career-single__title"><?php the_title(); ?></h1>
                                </div>

                                <!-- Career Content -->
                                <div class="career-single__content">
                                    <?php the_content( '', true ); ?>
                                </div>

                                <!-- Submit Resume Button -->
                                <div class="career-single__actions">
                                    <?php
                                    // Get button settings from meta fields
                                    $button_enabled = get_post_meta( get_the_ID(), 'career_button_enabled', true );
                                    $button_text = get_post_meta( get_the_ID(), 'career_button_text', true ) ?: 'SUBMIT RESUME';
                                    $button_url = get_post_meta( get_the_ID(), 'career_button_url', true );
                                    $button_target = get_post_meta( get_the_ID(), 'career_button_target', true ) ?: '_self';

                                    // Default URL if none specified
                                    if ( empty( $button_url ) ) {
                                        $button_url = home_url( '/employment/?job-title=' . urlencode( get_the_title() ) );
                                    }

                                    // Only show button if enabled (default is enabled)
                                    if ( $button_enabled !== '0' ):
                                        ?>
                                        <a href="<?php echo esc_url( $button_url ); ?>"
                                           class="btn btn-primary career-single__submit-btn"
                                           target="<?php echo esc_attr( $button_target ); ?>"
                                            <?php echo $button_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
                                            <?php echo esc_html( $button_text ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Navigation -->
                                <div class="career-single__navigation">
                                    <div class="career-single__nav-buttons">
                                        <a href="<?php echo get_post_type_archive_link( 'careers' ); ?>" class="btn btn-outline-primary career-single__back-btn">
                                            <i class="fas fa-arrow-left"></i>
                                            <?php _e( 'Back to Careers', 'default' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <!-- END of career content -->

                <!-- BEGIN of sidebar -->
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 sidebar">
                    <?php get_sidebar( 'right' ); ?>
                </div>
                <!-- END of sidebar -->
            </div>
        </div>
    </main>

<?php get_footer(); ?>