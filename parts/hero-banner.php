<?php
/**
 * Hero Banner for pages (not home)
 * Displays featured image and page title
 */

// Don't show on home page
if ( is_front_page() || is_home() ) {
    return;
}

$page_title = '';
$featured_image = '';

// Get page title based on page type
if ( is_page() ) {
    $page_title = get_the_title();
    $featured_image = get_the_post_thumbnail_url( get_the_ID(), 'full_hd' );
} elseif ( is_single() ) {
    $page_title = get_the_title();
    $featured_image = get_the_post_thumbnail_url( get_the_ID(), 'full_hd' );
} elseif ( is_archive() ) {
    if ( is_post_type_archive( 'products' ) ) {
        $page_title = 'PRODUCTS';
        // Try to get featured image from Products archive page if it exists
        $products_page = get_page_by_path( 'products' );
        if ( $products_page ) {
            $featured_image = get_the_post_thumbnail_url( $products_page->ID, 'full_hd' );
        }
    } elseif ( is_post_type_archive( 'careers' ) ) {
        $page_title = 'CAREERS';
        // Try to get featured image from Careers archive page if it exists
        $careers_page = get_page_by_path( 'careers' );
        if ( $careers_page ) {
            $featured_image = get_the_post_thumbnail_url( $careers_page->ID, 'full_hd' );
        }
    } else {
        $page_title = get_the_archive_title();
    }
    // For archive pages, try to get featured image from archive page or use default
} elseif ( is_category() || is_tag() ) {
    $page_title = single_term_title( '', false );
} elseif ( is_search() ) {
    $page_title = sprintf( __( 'Search Results for: %s', 'default' ), get_search_query() );
} elseif ( is_404() ) {
    $page_title = __( '404: Page Not Found', 'default' );
}

// Fallback image if no featured image
if ( ! $featured_image ) {
    $featured_image = get_template_directory_uri() . '/assets/images/placeholder.jpg';
}
?>

<?php if ( $page_title ): ?>
    <section class="hero-banner" <?php bg( $featured_image ); ?>>
        <div class="hero-banner__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-banner__content">
                        <h1 class="hero-banner__title"><?php echo esc_html( $page_title ); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>