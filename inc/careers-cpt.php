<?php
/**
 * Careers Custom Post Type
 */

// Register Careers Custom Post Type
function register_careers_cpt() {
    $labels = array(
        'name'               => _x( 'Careers', 'post type general name', 'default' ),
        'singular_name'      => _x( 'Career', 'post type singular name', 'default' ),
        'add_new'            => _x( 'Add New', 'career', 'default' ),
        'add_new_item'       => __( 'Add New Career', 'default' ),
        'edit_item'          => __( 'Edit Career', 'default' ),
        'new_item'           => __( 'New Career', 'default' ),
        'all_items'          => __( 'All Careers', 'default' ),
        'view_item'          => __( 'View Career', 'default' ),
        'search_items'       => __( 'Search Careers', 'default' ),
        'not_found'          => __( 'No careers found.', 'default' ),
        'not_found_in_trash' => __( 'No careers found in Trash.', 'default' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Careers'
    );

    $args = array(
        'labels'        => $labels,
        'description'   => 'Career opportunities for the website',
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-businessman',
        'menu_position' => 8,
        'supports'      => array(
            'title',
            'editor',
            'page-attributes'
        ),
        'has_archive'   => true,
        'hierarchical'  => false,
        'rewrite'       => array( 'slug' => 'careers' ),
    );

    register_post_type( 'careers', $args );
}
add_action( 'init', 'register_careers_cpt' );

// Add custom columns to careers admin list
add_filter( 'manage_careers_posts_columns', 'add_careers_columns' );

function add_careers_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['career_details'] = __( 'Details Preview', 'default' );
    $new_columns['date'] = $columns['date'];

    return $new_columns;
}

// Populate custom columns
add_action( 'manage_careers_posts_custom_column', 'populate_careers_columns', 10, 2 );

function populate_careers_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'career_details':
            $content = get_post_field( 'post_content', $post_id );
            if ( $content ) {
                echo wp_trim_words( strip_tags( $content ), 15 );
            } else {
                echo '—';
            }
            break;
    }
}