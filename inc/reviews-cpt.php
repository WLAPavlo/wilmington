<?php
/**
 * Reviews Custom Post Type
 */

// Register Reviews Custom Post Type
function register_reviews_cpt() {
    $labels = array(
        'name'               => _x( 'Reviews', 'post type general name', 'default' ),
        'singular_name'      => _x( 'Review', 'post type singular name', 'default' ),
        'add_new'            => _x( 'Add New', 'review', 'default' ),
        'add_new_item'       => __( 'Add New Review', 'default' ),
        'edit_item'          => __( 'Edit Review', 'default' ),
        'new_item'           => __( 'New Review', 'default' ),
        'all_items'          => __( 'All Reviews', 'default' ),
        'view_item'          => __( 'View Review', 'default' ),
        'search_items'       => __( 'Search Reviews', 'default' ),
        'not_found'          => __( 'No reviews found.', 'default' ),
        'not_found_in_trash' => __( 'No reviews found in Trash.', 'default' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Reviews'
    );

    $args = array(
        'labels'        => $labels,
        'description'   => 'Customer reviews for the website',
        'public'        => false, // No individual pages/permalinks
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-star-filled',
        'menu_position' => 7,
        'supports'      => array(
            'title',
            'editor',
            'page-attributes'
        ),
        'has_archive'   => false,
        'hierarchical'  => false,
        'publicly_queryable' => false, // No front-end access
        'rewrite'       => false,
    );

    register_post_type( 'reviews', $args );
}
add_action( 'init', 'register_reviews_cpt' );

// Add custom meta boxes for reviews
add_action( 'add_meta_boxes', 'add_review_meta_boxes' );

function add_review_meta_boxes() {
    add_meta_box(
        'review_details',
        __( 'Review Details', 'default' ),
        'review_details_callback',
        'reviews',
        'normal',
        'high'
    );
}

function review_details_callback( $post ) {
    wp_nonce_field( 'save_review_details', 'review_nonce' );

    $author = get_post_meta( $post->ID, 'review_author', true );
    $source = get_post_meta( $post->ID, 'review_source', true );
    $stars = get_post_meta( $post->ID, 'review_stars', true ) ?: 5;
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="review_author"><?php _e( 'Author Name', 'default' ); ?></label>
            </th>
            <td>
                <input type="text" id="review_author" name="review_author" value="<?php echo esc_attr( $author ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'Optional: Name of the person who wrote the review', 'default' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="review_source"><?php _e( 'Review Source', 'default' ); ?></label>
            </th>
            <td>
                <select id="review_source" name="review_source">
                    <option value=""><?php _e( 'Select Source', 'default' ); ?></option>
                    <option value="google" <?php selected( $source, 'google' ); ?>><?php _e( 'Google', 'default' ); ?></option>
                    <option value="facebook" <?php selected( $source, 'facebook' ); ?>><?php _e( 'Facebook', 'default' ); ?></option>
                    <option value="yelp" <?php selected( $source, 'yelp' ); ?>><?php _e( 'Yelp', 'default' ); ?></option>
                    <option value="website" <?php selected( $source, 'website' ); ?>><?php _e( 'Website', 'default' ); ?></option>
                    <option value="other" <?php selected( $source, 'other' ); ?>><?php _e( 'Other', 'default' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="review_stars"><?php _e( 'Star Rating', 'default' ); ?></label>
            </th>
            <td>
                <select id="review_stars" name="review_stars">
                    <?php for ( $i = 1; $i <= 5; $i++ ): ?>
                        <option value="<?php echo $i; ?>" <?php selected( $stars, $i ); ?>>
                            <?php echo $i; ?> <?php echo $i === 1 ? __( 'Star', 'default' ) : __( 'Stars', 'default' ); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Save review meta data
add_action( 'save_post', 'save_review_details' );

function save_review_details( $post_id ) {
    if ( ! isset( $_POST['review_nonce'] ) || ! wp_verify_nonce( $_POST['review_nonce'], 'save_review_details' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['review_author'] ) ) {
        update_post_meta( $post_id, 'review_author', sanitize_text_field( $_POST['review_author'] ) );
    }

    if ( isset( $_POST['review_source'] ) ) {
        update_post_meta( $post_id, 'review_source', sanitize_text_field( $_POST['review_source'] ) );
    }

    if ( isset( $_POST['review_stars'] ) ) {
        update_post_meta( $post_id, 'review_stars', intval( $_POST['review_stars'] ) );
    }
}

// Add custom columns to reviews admin list
add_filter( 'manage_reviews_posts_columns', 'add_reviews_columns' );

function add_reviews_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['review_author'] = __( 'Author', 'default' );
    $new_columns['review_source'] = __( 'Source', 'default' );
    $new_columns['review_stars'] = __( 'Rating', 'default' );
    $new_columns['date'] = $columns['date'];

    return $new_columns;
}

// Populate custom columns
add_action( 'manage_reviews_posts_custom_column', 'populate_reviews_columns', 10, 2 );

function populate_reviews_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'review_author':
            $author = get_post_meta( $post_id, 'review_author', true );
            echo $author ? esc_html( $author ) : '—';
            break;

        case 'review_source':
            $source = get_post_meta( $post_id, 'review_source', true );
            if ( $source ) {
                $sources = array(
                    'google' => 'Google',
                    'facebook' => 'Facebook',
                    'yelp' => 'Yelp',
                    'website' => 'Website',
                    'other' => 'Other'
                );
                echo isset( $sources[$source] ) ? esc_html( $sources[$source] ) : esc_html( ucfirst( $source ) );
            } else {
                echo '—';
            }
            break;

        case 'review_stars':
            $stars = get_post_meta( $post_id, 'review_stars', true );
            if ( $stars ) {
                echo str_repeat( '★', intval( $stars ) ) . str_repeat( '☆', 5 - intval( $stars ) );
            } else {
                echo '—';
            }
            break;
    }
}