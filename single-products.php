<?php
/**
 * Single Product Page
 */
get_header(); ?>

    <main class="main-content">
        <div class="container">
            <div class="row">
                <!-- BEGIN of product content -->
                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article id="product-<?php the_ID(); ?>" <?php post_class('entry product-single'); ?>>
                                <!-- Product Header -->
                                <div class="product-single__header">
                                    <h1 class="page-title product-single__title"><?php the_title(); ?></h1>

                                    <?php
                                    // Display product categories if they exist
                                    $categories = get_the_terms( get_the_ID(), 'product_category' );
                                    if ( $categories && !is_wp_error( $categories ) ): ?>
                                        <div class="product-single__categories">
                                            <span class="product-single__category-label"><?php _e( 'Category: ', 'default' ); ?></span>
                                            <?php
                                            $category_links = array();
                                            foreach ( $categories as $category ) {
                                                $category_links[] = '<a href="' . get_term_link( $category ) . '" class="product-single__category-link">' . $category->name . '</a>';
                                            }
                                            echo implode( ', ', $category_links );
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Image -->
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="product-single__image-wrapper">
                                        <div class="product-single__image">
                                            <?php the_post_thumbnail( 'large', array( 'class' => 'product-single__img' ) ); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Product Content -->
                                <div class="product-single__content">
                                    <?php the_content( '', true ); ?>
                                </div>

                                <!-- Product Meta -->
                                <div class="product-single__meta">
                                    <div class="product-single__meta-item">
                                        <span class="product-single__meta-label"><?php _e( 'Published: ', 'default' ); ?></span>
                                        <time class="product-single__meta-date" datetime="<?php echo get_the_date( 'c' ); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </div>
                                </div>

                                <!-- Navigation -->
                                <div class="product-single__navigation">
                                    <div class="product-single__nav-buttons">
                                        <a href="<?php echo get_post_type_archive_link( 'products' ); ?>" class="btn btn--outline-teal product-single__back-btn">
                                            <i class="fas fa-arrow-left"></i>
                                            <?php _e( 'Back to Products', 'default' ); ?>
                                        </a>

                                        <?php
                                        $prev_post = get_previous_post();
                                        $next_post = get_next_post();
                                        ?>

                                        <div class="product-single__nav-adjacent">
                                            <?php if ( $prev_post ): ?>
                                                <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="btn btn--outline-dark product-single__nav-prev" title="<?php echo esc_attr( $prev_post->post_title ); ?>">
                                                    <i class="fas fa-chevron-left"></i>
                                                    <span class="product-single__nav-text">
                                                    <small><?php _e( 'Previous', 'default' ); ?></small>
                                                    <span><?php echo wp_trim_words( $prev_post->post_title, 3 ); ?></span>
                                                </span>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ( $next_post ): ?>
                                                <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="btn btn--outline-dark product-single__nav-next" title="<?php echo esc_attr( $next_post->post_title ); ?>">
                                                <span class="product-single__nav-text">
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
                <!-- END of product content -->

                <!-- BEGIN of sidebar -->
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 sidebar">
                    <?php get_sidebar( 'right' ); ?>
                </div>
                <!-- END of sidebar -->
            </div>
        </div>
    </main>

<?php get_footer(); ?>