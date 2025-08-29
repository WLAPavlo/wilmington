<?php
/**
 * Hero Banner for pages (not home)
 * Displays featured image and page title passed as argument
 */


$page_title = is_archive() ? single_term_title('', false) : (isset($title) ? $title : get_the_title());
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');

if (empty($featured_image)) {
    $featured_image = get_template_directory_uri() . '/assets/images/placeholder.jpg';
}

if (is_archive()) {
    $post_types = ['products' => 'PRODUCTS', 'careers' => 'CAREERS'];
    foreach ($post_types as $type => $title) {
        if (is_post_type_archive($type)) {
            $page_title = $title;
            if ($page = get_page_by_path($type)) {
                $featured_image = get_the_post_thumbnail_url($page->ID, 'full_hd');
            }
            break;
        }
    }
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