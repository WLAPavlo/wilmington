<?php
/**
 * WP 5.2 wp_body_open backward compatibility
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

// ACF Pro Options Page
if ( function_exists( 'acf_add_options_page' ) ) {

    acf_add_options_page( array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false
    ) );
}

// By adding theme support, we declare that this theme does not use a
// hard-coded <title> tag in the document head, and expect WordPress to
// provide it for us.
add_theme_support( 'title-tag' );

//  Add widget support shortcodes
add_filter( 'widget_text', 'do_shortcode' );

// Support for Featured Images
add_theme_support( 'post-thumbnails' );

// Custom Background
add_theme_support( 'custom-background', array( 'default-color' => 'fff' ) );

// Custom Logo
add_theme_support( 'custom-logo', array(
    'height'      => '150',
    'flex-height' => true,
    'flex-width'  => true,
) );

// Add HTML5 elements
add_theme_support( 'html5', array(
    'comment-list',
    'search-form',
    'comment-form',
    'gallery',
    'caption',
    'script',
    'style'
) );

// Custom Header
add_theme_support( 'custom-header', array(
    'default-image' => get_template_directory_uri() . '/images/custom-logo.png',
    'height'        => '200',
    'flex-height'   => true,
    'uploads'       => true,
    'header-text'   => false
) );

// Add RSS Links generation
add_theme_support( 'automatic-feed-links' );

// Hide comments feed link
add_filter( 'feed_links_show_comments_feed', '__return_false' );

// Add excerpt to pages
add_post_type_support( 'page', 'excerpt' );

// Register Navigation Menu
register_nav_menus( array(
    'header-menu' => 'Header Menu',
    'footer-menu' => 'Footer Menu'
) );


// Register Sidebars
function bootstrap_widgets_init() {
    /* Sidebar Right */
    register_sidebar( array(
        'id'            => 'bootstrap_sidebar_right',
        'name'          => __( 'Sidebar Right' ),
        'description'   => __( 'This sidebar is located on the right-hand side of each page.' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h5 class="widget__title">',
        'after_title'   => '</h5>',
    ) );

}

add_action( 'widgets_init', 'bootstrap_widgets_init' );

// Remove #more anchor from posts
function remove_more_jump_link( $link ) {
    $offset = strpos( $link, '#more-' );
    if ( $offset ) {
        $end = strpos( $link, '"', $offset );
    }
    if ( $end ) {
        $link = substr_replace( $link, '', $offset, $end - $offset );
    }

    return $link;
}

add_filter( 'the_content_more_link', 'remove_more_jump_link' );

// Remove more tag <span> anchor
function remove_more_anchor( $content ) {
    return str_replace( '<p><span id="more-' . get_the_ID() . '"></span></p>', '', $content );
}

add_filter( 'the_content', 'remove_more_anchor' );

// Remove author archive pages
function remove_author_archive_page() {
    global $wp_query;

    if ( is_author() ) {
        $wp_query->set_404();
        status_header(404);
        // Redirect to homepage
        // wp_redirect(get_option('home'));
    }
}
add_action( 'template_redirect', 'remove_author_archive_page' );

// Enable revisions for all custom post types
add_filter( 'cptui_user_supports_params', function () {
    return array( 'revisions' );
} );

// Limit number of revisions for all post types
function limit_revisions_number() {
    return 10;
}

add_filter( 'wp_revisions_to_keep', 'limit_revisions_number');

// Add ability ro reply to comments
add_filter( 'wpseo_remove_reply_to_com', '__return_false' );

// Remove comments feed links
add_filter( 'post_comments_feed_link', '__return_null' );


// Prevent Fatal error on site if ACF not installed/activated
function include_acf_placeholder() {
    include_once get_stylesheet_directory() . '/inc/acf-placeholder.php';
}

add_action( 'wp', 'include_acf_placeholder', PHP_INT_MAX );

/**
 * Copyright field functionality
 *
 * @param array $field ACF Field settings
 *
 * @return array
 */
function populate_copyright_instructions( $field ) {
    $field['instructions'] = 'Input <code>@year</code> to replace static year with dynamic, so it will always shows current year.';

    return $field;
}

add_action( 'acf/load_field/name=copyright', 'populate_copyright_instructions');

if ( ! is_admin() ) {
    // Replace @year with current year
    add_filter( 'acf/load_value/name=copyright', function ( $value ) {
        return str_replace( '@year', date( 'Y' ), $value );
    } );

    // Stick Admin Bar To The Top
    add_action( 'get_header', 'remove_topbar_bump' );

    function remove_topbar_bump() {
        remove_action( 'wp_head', '_admin_bar_bump_cb' );
    }

    function stick_admin_bar() {
        echo "
			<style type='text/css'>
				body.admin-bar {margin-top:32px !important}
				@media screen and (max-width: 782px) {
					body.admin-bar { margin-top:46px !important }
				}
			</style>
			";
    }

    add_action( 'admin_head', 'stick_admin_bar' );
    add_action( 'wp_head', 'stick_admin_bar' );
}

// Customize Login Screen
function wordpress_login_styling() {
    if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
        $custom_logo_img = wp_get_attachment_image_src( $custom_logo_id, 'medium' );
        $custom_logo_src = $custom_logo_img[0];
    } else {
        $custom_logo_src = 'wp-admin/images/wordpress-logo.svg?ver=20131107';
    }
    ?>
    <style type="text/css">
        .login #login h1 a {
            background-image: url('<?php echo $custom_logo_src; ?>');
            background-size: contain;
            background-position: 50% 50%;
            width: auto;
            height: 120px;
        }

        body.login {
            background-color: #f1f1f1;
        <?php if ($bg_image = get_background_image()) {?> background-image: url('<?php echo $bg_image; ?>') !important;
        <?php } ?> background-repeat: repeat;
            background-position: center center;
        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'wordpress_login_styling' );

function admin_logo_custom_url() {
    $site_url = get_bloginfo( 'url' );

    return ( $site_url );
}

add_filter( 'login_headerurl', 'admin_logo_custom_url' );

// Disable Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_wp_emojis_in_tinymce' );
function disable_wp_emojis_in_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

// Enable control over YouTube iframe through API + add unique ID
function add_youtube_iframe_args( $html, $url, $args ) {

    /* Modify video parameters. */
    if ( strstr( $html, 'youtube.com/embed/' ) && ! empty( $args['location'] ) ) {
        preg_match_all( '|embed/(.*)\?|', $html, $matches );
        $html = str_replace( '?feature=oembed', '?feature=oembed&enablejsapi=1&autoplay=1&mute=1&controls=0&loop=1&showinfo=0&rel=0&playlist=' . $matches[1][0], $html );
        $html = str_replace( '<iframe', '<iframe rel="0" enablejsapi="1" id=slide-' . get_the_ID(), $html );
    }

    return $html;
}

add_filter( 'oembed_result', 'add_youtube_iframe_args', 10, 3 );

// Wrap any iframe and emved tag into div for responsive view
function iframe_wrapper( $content ) {
    // match any iframes
    $pattern = '~<iframe.*?<\/iframe>|<embed.*?<\/embed>~';
    preg_match_all( $pattern, $content, $matches );

    foreach ( $matches[0] as $match ) {
        // Check if it is a video player iframe
        if ( strpos( $match, 'youtu' ) || strpos( $match, 'vimeo' ) ) {
            // wrap matched iframe with div
            $wrappedframe = '<div class="embed-responsive embed-responsive-16by9">' . $match . '</div>';
            //replace original iframe with new in content
            $content = str_replace( $match, $wrappedframe, $content );
        }
    }

    return $content;
}

add_filter( 'the_content', 'iframe_wrapper' );
add_filter( 'acf_the_content', 'iframe_wrapper' );

// Custom outline color
add_action( 'wp_head', 'custom_outline_color' );

function custom_outline_color() {
    $outline_color = get_theme_mod( 'outline_color' );
    if ( $outline_color ) {
        echo "<style>a,input,button,textarea,select{outline-color: {$outline_color}}</style>";
    }
}

// Replace Wordpress email Sender name
function replace_email_sender_name() {
    return get_bloginfo();
}

add_filter( 'wp_mail_from_name', 'replace_email_sender_name' );

// Disable Robin Image optimizer backup
add_filter( 'wbcr/factory/populate_option_backup_origin_images', function () {
    return ! empty( get_option( 'wbcr_io_backup_origin_images' ) ) ? get_option( 'wbcr_io_backup_origin_images' ) : 0;
} );

// Disable Robin Image resize image
add_filter( 'wbcr/factory/populate_option_resize_larger', function () {
    return ! empty( get_option( 'wbcr_io_resize_larger' ) ) ? get_option( 'wbcr_io_resize_larger' ) : 0;
} );


// Specify image sizes that need to be optimized
function specify_sizes_to_optimize( $sizes ) {
    if ( empty( $sizes ) || $sizes == 'thumbnail,medium' ) {
        $sizes = 'thumbnail,medium,medium_large,large,large_high,full_hd,1536x1536,2048x2048';
    }

    return $sizes;
}

add_filter( 'wbcr/factory/populate_option_allowed_sizes_thumbnail', 'specify_sizes_to_optimize' );
