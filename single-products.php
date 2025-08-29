<?php
/**
 * Single Product Page
 */
get_header(); ?>

<?php if (!is_front_page() && !is_home()): ?>
    <?php show_template('hero-banner', array('title' => get_the_title(), 'image' => get_post_thumbnail_id())); ?>
<?php endif; ?>

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

                                <!-- Navigation -->
                                <div class="product-single__navigation">
                                    <div class="product-single__nav-buttons">
                                        <a href="<?php echo get_post_type_archive_link( 'products' ); ?>" class="btn btn-outline-teal product-single__back-btn">
                                            <i class="fas fa-arrow-left"></i>
                                            <?php _e( 'Back to Products', 'default' ); ?>
                                        </a>
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