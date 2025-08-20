<?php
/**
 * Products Custom Post Type
 */

// Register Products Custom Post Type
function register_products_cpt() {
    $labels = array(
        'name'               => _x( 'Products', 'post type general name', 'default' ),
        'singular_name'      => _x( 'Product', 'post type singular name', 'default' ),
        'add_new'            => _x( 'Add New', 'product', 'default' ),
        'add_new_item'       => __( 'Add New Product', 'default' ),
        'edit_item'          => __( 'Edit Product', 'default' ),
        'new_item'           => __( 'New Product', 'default' ),
        'all_items'          => __( 'All Products', 'default' ),
        'view_item'          => __( 'View Product', 'default' ),
        'search_items'       => __( 'Search Products', 'default' ),
        'not_found'          => __( 'No products found.', 'default' ),
        'not_found_in_trash' => __( 'No products found in Trash.', 'default' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Products'
    );

    $args = array(
        'labels'        => $labels,
        'description'   => 'Products for the website',
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-products',
        'menu_position' => 6,
        'supports'      => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'page-attributes'
        ),
        'has_archive'   => true,
        'hierarchical'  => false,
        'rewrite'       => array( 'slug' => 'products' ),
    );

    register_post_type( 'products', $args );
}
add_action( 'init', 'register_products_cpt' );

// Register Product Categories Taxonomy
function register_product_categories_taxonomy() {
    $labels = array(
        'name'              => _x( 'Product Categories', 'taxonomy general name', 'default' ),
        'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'default' ),
        'search_items'      => __( 'Search Product Categories', 'default' ),
        'all_items'         => __( 'All Product Categories', 'default' ),
        'parent_item'       => __( 'Parent Product Category', 'default' ),
        'parent_item_colon' => __( 'Parent Product Category:', 'default' ),
        'edit_item'         => __( 'Edit Product Category', 'default' ),
        'update_item'       => __( 'Update Product Category', 'default' ),
        'add_new_item'      => __( 'Add New Product Category', 'default' ),
        'new_item_name'     => __( 'New Product Category Name', 'default' ),
        'menu_name'         => __( 'Product Categories', 'default' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'product-category' ),
    );

    register_taxonomy( 'product_category', array( 'products' ), $args );
}
add_action( 'init', 'register_product_categories_taxonomy' );

// AJAX handler for product filtering
add_action( 'wp_ajax_filter_products', 'filter_products_callback' );
add_action( 'wp_ajax_nopriv_filter_products', 'filter_products_callback' );

function filter_products_callback() {
    check_ajax_referer( 'products_nonce', 'nonce' );

    $category = sanitize_text_field( $_POST['category'] );
    $selected_products = isset( $_POST['selected_products'] ) ? array_map( 'intval', $_POST['selected_products'] ) : array();

    $args = array(
        'post_type' => 'products',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );

    // If specific products are selected, show only those
    if ( !empty( $selected_products ) ) {
        $args['post__in'] = $selected_products;
        $args['orderby'] = 'post__in';
    }

    // Add category filter if not 'all'
    if ( $category && $category !== 'all' ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    $products_query = new WP_Query( $args );
    $response = array();

    if ( $products_query->have_posts() ) {
        ob_start();
        while ( $products_query->have_posts() ) {
            $products_query->the_post();
            ?>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12 products-grid__item" data-categories="<?php echo esc_attr( implode( ',', wp_get_object_terms( get_the_ID(), 'product_category', array( 'fields' => 'slugs' ) ) ) ); ?>">
                <div class="product-card">
                    <?php if ( has_post_thumbnail() ): ?>
                        <div class="product-card__image">
                            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'product-card__img' ) ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="product-card__content">
                        <h4 class="product-card__title"><?php the_title(); ?></h4>
                        <?php if ( get_the_excerpt() ): ?>
                            <p class="product-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        $response['html'] = ob_get_clean();
        $response['success'] = true;
    } else {
        $response['html'] = '<div class="col-12"><p class="text-center">No products found.</p></div>';
        $response['success'] = false;
    }

    wp_reset_postdata();
    wp_send_json( $response );
}