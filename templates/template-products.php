<?php
/**
 * Template Name: Products Page
 */
get_header(); ?>

<?php if (!is_front_page() && !is_home()): ?>
    <?php show_template('hero-banner', array('title' => get_the_title(), 'image' => get_post_thumbnail_id())); ?>
<?php endif; ?>

    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article <?php post_class('entry'); ?>>
                                <?php if ( get_the_content() ): ?>
                                    <div class="entry__content products-page__intro">
                                        <?php the_content( '', true ); ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endwhile; ?>
                    <?php endif; ?>

                    <!-- Products Grid -->
                    <div class="products-page__grid">
                        <?php
                        $products_args = array(
                            'post_type' => 'products',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );

                        $products_query = new WP_Query( $products_args );

                        if ( $products_query->have_posts() ):
                            while ( $products_query->have_posts() ): $products_query->the_post();
                                ?>
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
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            ?>
                            <div class="col-12">
                                <p class="text-center">No products found.</p>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>