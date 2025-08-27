<?php
/**
 * Careers Archive Page - Redirect to Careers page template
 */

get_header(); ?>

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
                                            <?php the_title(); ?>
                                        </h2>
                                    </div>

                                    <?php if ( get_the_content() ): ?>
                                        <div class="career-item__content">
                                            <?php the_content(); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="career-item__actions">
                                        <a href="<?php echo esc_url( home_url( '/employment/?job-title=' . urlencode( get_the_title() ) ) ); ?>"
                                           class="career-item__btn career-item__btn--teal">
                                            SUBMIT RESUME
                                        </a>
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