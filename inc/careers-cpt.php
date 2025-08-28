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
        'menu_position' => 8,
        'supports'      => array(
            'title',
            'editor',
        ),
        'has_archive'   => true,
    );

    register_post_type( 'careers', $args );
}
add_action( 'init', 'register_careers_cpt' );

// Add meta box for career button settings
function add_career_button_meta_box() {
    add_meta_box(
        'career_button_settings',
        __( 'Career Button Settings', 'default' ),
        'career_button_settings_callback',
        'careers',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'add_career_button_meta_box' );

// Meta box callback function
function career_button_settings_callback( $post ) {
    // Get current values
    $button_text = get_post_meta( $post->ID, 'career_button_text', true ) ?: 'SUBMIT RESUME';
    $button_url = get_post_meta( $post->ID, 'career_button_url', true );
    $button_target = get_post_meta( $post->ID, 'career_button_target', true ) ?: '_self';
    $button_enabled = get_post_meta( $post->ID, 'career_button_enabled', true );
    $button_enabled = $button_enabled !== '' ? $button_enabled : '1'; // Default to enabled

    wp_nonce_field( 'save_career_button_settings', 'career_button_nonce' );
    ?>
    <style>
        .career-meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .career-meta-table th {
            width: 150px;
            text-align: left;
            padding: 15px 10px 15px 0;
            vertical-align: top;
            font-weight: 600;
        }
        .career-meta-table td {
            padding: 15px 0;
        }
        .career-meta-table input[type="text"],
        .career-meta-table input[type="url"] {
            width: 100%;
            max-width: 400px;
        }
        .career-meta-description {
            color: #666;
            margin-top: 5px;
            font-size: 13px;
        }
        .career-meta-checkbox {
            margin-right: 8px;
        }
    </style>
    <table class="career-meta-table">
        <tr>
            <th scope="row">
                <label for="career_button_enabled"><?php _e( 'Enable Button', 'default' ); ?></label>
            </th>
            <td>
                <input type="checkbox" id="career_button_enabled" name="career_button_enabled" value="1" <?php checked( $button_enabled, '1' ); ?> class="career-meta-checkbox" />
                <label for="career_button_enabled"><?php _e( 'Show button on this career', 'default' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="career_button_text"><?php _e( 'Button Text', 'default' ); ?></label>
            </th>
            <td>
                <input type="text" id="career_button_text" name="career_button_text" value="<?php echo esc_attr( $button_text ); ?>" class="regular-text" />
                <p class="description career-meta-description"><?php _e( 'Text that will appear on the button (e.g., "SUBMIT RESUME", "APPLY NOW")', 'default' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="career_button_url"><?php _e( 'Button URL', 'default' ); ?></label>
            </th>
            <td>
                <input type="url" id="career_button_url" name="career_button_url" value="<?php echo esc_attr( $button_url ); ?>" class="regular-text" placeholder="https://example.com/employment" />
                <p class="description career-meta-description"><?php _e( 'URL where the button should link (leave empty to use default employment page with job title)', 'default' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="career_button_target"><?php _e( 'Open Link In', 'default' ); ?></label>
            </th>
            <td>
                <select id="career_button_target" name="career_button_target">
                    <option value="_self" <?php selected( $button_target, '_self' ); ?>><?php _e( 'Same Window', 'default' ); ?></option>
                    <option value="_blank" <?php selected( $button_target, '_blank' ); ?>><?php _e( 'New Window/Tab', 'default' ); ?></option>
                </select>
                <p class="description career-meta-description"><?php _e( 'Choose whether to open the link in the same window or a new tab', 'default' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Save career button settings
function save_career_button_settings( $post_id ) {
    // Check if this is a careers post type
    if ( get_post_type( $post_id ) !== 'careers' ) {
        return;
    }

    // Verify nonce
    if ( ! isset( $_POST['career_button_nonce'] ) || ! wp_verify_nonce( $_POST['career_button_nonce'], 'save_career_button_settings' ) ) {
        return;
    }

    // Check if user has permission to edit this post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save button enabled/disabled state
    $button_enabled = isset( $_POST['career_button_enabled'] ) ? '1' : '0';
    update_post_meta( $post_id, 'career_button_enabled', $button_enabled );

    // Save button text
    if ( isset( $_POST['career_button_text'] ) ) {
        $button_text = sanitize_text_field( $_POST['career_button_text'] );
        $button_text = $button_text ?: 'SUBMIT RESUME'; // Default text if empty
        update_post_meta( $post_id, 'career_button_text', $button_text );
    }

    // Save button URL
    if ( isset( $_POST['career_button_url'] ) ) {
        $button_url = esc_url_raw( $_POST['career_button_url'] );
        update_post_meta( $post_id, 'career_button_url', $button_url );
    }

    // Save button target
    if ( isset( $_POST['career_button_target'] ) ) {
        $button_target = sanitize_text_field( $_POST['career_button_target'] );
        $button_target = in_array( $button_target, array( '_self', '_blank' ) ) ? $button_target : '_self';
        update_post_meta( $post_id, 'career_button_target', $button_target );
    }
}
add_action( 'save_post', 'save_career_button_settings' );

// Add custom columns to careers admin list
function add_careers_admin_columns( $columns ) {
    $new_columns = array();

    // Keep the existing columns in order
    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;

        // Add our custom column after the title
        if ( $key === 'title' ) {
            $new_columns['career_button'] = __( 'Button Status', 'default' );
        }
    }

    return $new_columns;
}
add_filter( 'manage_careers_posts_columns', 'add_careers_admin_columns' );

// Display content for custom columns
function display_careers_admin_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'career_button':
            $button_enabled = get_post_meta( $post_id, 'career_button_enabled', true );
            $button_text = get_post_meta( $post_id, 'career_button_text', true ) ?: 'SUBMIT RESUME';

            if ( $button_enabled !== '0' ) {
                echo '<span style="color: #46b450; font-weight: 600;">✓ Enabled</span><br>';
                echo '<small style="color: #666;">' . esc_html( $button_text ) . '</small>';
            } else {
                echo '<span style="color: #dc3232; font-weight: 600;">✗ Disabled</span>';
            }
            break;
    }
}
add_action( 'manage_careers_posts_custom_column', 'display_careers_admin_columns', 10, 2 );