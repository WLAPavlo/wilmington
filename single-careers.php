<?php
/**
 * Single Career Page
 */
get_header(); ?>

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
                                           class="btn btn-teal career-single__submit-btn"
                                           target="<?php echo esc_attr( $button_target ); ?>"
                                            <?php echo $button_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
                                            <?php echo esc_html( $button_text ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Career Meta -->
                                <div class="career-single__meta">
                                    <div class="career-single__meta-item">
                                        <span class="career-single__meta-label"><?php _e( 'Posted: ', 'default' ); ?></span>
                                        <time class="career-single__meta-date" datetime="<?php echo get_the_date( 'c' ); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </div>
                                </div>

                                <!-- Navigation -->
                                <div class="career-single__navigation">
                                    <div class="career-single__nav-buttons">
                                        <a href="<?php echo get_post_type_archive_link( 'careers' ); ?>" class="btn btn-outline-teal career-single__back-btn">
                                            <i class="fas fa-arrow-left"></i>
                                            <?php _e( 'Back to Careers', 'default' ); ?>
                                        </a>

                                        <?php
                                        $prev_post = get_previous_post();
                                        $next_post = get_next_post();
                                        ?>

                                        <div class="career-single__nav-adjacent">
                                            <?php if ( $prev_post ): ?>
                                                <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="btn btn-outline-dark career-single__nav-prev" title="<?php echo esc_attr( $prev_post->post_title ); ?>">
                                                    <i class="fas fa-chevron-left"></i>
                                                    <span class="career-single__nav-text">
                                                    <small><?php _e( 'Previous', 'default' ); ?></small>
                                                    <span><?php echo wp_trim_words( $prev_post->post_title, 3 ); ?></span>
                                                </span>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ( $next_post ): ?>
                                                <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="btn btn-outline-dark career-single__nav-next" title="<?php echo esc_attr( $next_post->post_title ); ?>">
                                                <span class="career-single__nav-text">
                                                    <small><?php _e( 'Next', 'default' ); ?></small>
                                                    <span><?php echo wp_trim_words( $next_post->post_title, 3 ); ?></span>
                                                </span>
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
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