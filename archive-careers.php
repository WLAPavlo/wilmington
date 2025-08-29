<?php
/**
 * Careers Archive Page - Redirect to Careers page template
 */

get_header(); ?>

<?php show_template('hero-banner', array('title' => 'Careers')); ?>

    <main class="main-content template-careers" style="padding: 0;">
        <div class="container">
            <div class="row">
                <!-- BEGIN of careers content -->
                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                    <div class="careers-list">
                        <?php
                        $args = array(
                            'post_type' => 'careers',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                        $careers_query = new WP_Query( $args );

                        if ( $careers_query->have_posts() ):
                            while ( $careers_query->have_posts() ): $careers_query->the_post();
                                ?>
                                <div class="career-item">
                                    <div class="career-item__header">
                                        <h2 class="career-item__title">
                                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h2>
                                    </div>

                                    <?php if ( get_the_content() ): ?>
                                        <div class="career-item__content">
                                            <?php the_content(); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="career-item__actions">
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
                                               class="btn btn-primary career-item__btn"
                                               target="<?php echo esc_attr( $button_target ); ?>"
                                                <?php echo $button_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
                                                <?php echo esc_html( $button_text ); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            ?>
                            <div class="col-12">
                                <p class="text-center">No career opportunities available at this time.</p>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
                <!-- END of careers content -->

                <!-- BEGIN of sidebar -->
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 sidebar">
                    <?php get_sidebar( 'right' ); ?>
                </div>
                <!-- END of sidebar -->
            </div>
        </div>
    </main>

<?php get_footer(); ?>