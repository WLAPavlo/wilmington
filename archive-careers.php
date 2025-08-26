<?php
/**
 * Careers Archive Page
 */
get_header(); ?>

    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Careers Grid -->
                    <div class="careers-page__grid">
                        <?php if ( have_posts() ): ?>
                            <?php while ( have_posts() ): the_post(); ?>
                                <div class="careers-page__item">
                                    <div class="career-tile">
                                        <div class="career-tile__content">
                                            <h3 class="career-tile__title"><?php the_title(); ?></h3>

                                            <?php if ( get_the_content() ): ?>
                                                <div class="career-tile__excerpt">
                                                    <?php echo wp_trim_words( get_the_content(), 20 ); ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="career-tile__actions">
                                                <a href="<?php the_permalink(); ?>" class="btn btn--outline-dark career-tile__details-btn">
                                                    View Details
                                                </a>
                                                <a href="<?php echo esc_url( home_url( '/employment/?job-title=' . urlencode( get_the_title() ) ) ); ?>"
                                                   class="btn btn--teal career-tile__submit-btn">
                                                    Submit Resume
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center">No career opportunities found at this time.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>