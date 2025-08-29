<?php
/**
 * WooCommerce Page. Shop / Product Category / Single Product view
 */
get_header(); ?>
<?php if (!is_front_page() && !is_home()): ?>
    <?php show_template('hero-banner', array('title' => get_the_title(), 'image' => get_post_thumbnail_id())); ?>
<?php endif; ?>


<?php if ( ! is_front_page() && ! is_home() ): ?>
    <?php
    $page_title = '';
    if ( is_shop() ) {
        $page_title = woocommerce_page_title( false );
    } elseif ( is_product_category() || is_product_tag() ) {
        $page_title = single_term_title( '', false );
    } elseif ( is_product() ) {
        $page_title = get_the_title();
    } else {
        $page_title = 'Shop';
    }
    show_template( 'hero-banner', array( 'title' => $page_title ) );
    ?>
<?php endif; ?>

<main class="main-content">
    <div class="container">
        <div class="row">
            <!-- BEGIN of page content -->
            <div class="col-12">
                <?php woocommerce_content(); ?>
            </div>
            <!-- END of page content -->
        </div>
    </div>
</main>

<?php get_footer(); ?>
