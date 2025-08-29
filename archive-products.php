<?php
/**
 * Products Archive Page
 */
get_header(); ?>

<?php show_template('hero-banner', array('title' => 'Products')); ?>

    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Products Grid -->
                    <div class="products-page__grid">
                        <?php if ( have_posts() ): ?>
                            <?php while ( have_posts() ): the_post(); ?>
                                <div class="products-page__item">
                                    <div class="product-tile">
                                        <a href="<?php the_permalink(); ?>" class="product-tile__link">
                                            <?php if ( has_post_thumbnail() ): ?>
                                                <div class="product-tile__image">
                                                    <?php the_post_thumbnail( 'medium_large', array( 'class' => 'product-tile__img' ) ); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="product-tile__content">
                                                <h3 class="product-tile__title"><?php the_title(); ?></h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center">No products found.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>