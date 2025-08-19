<?php
/**
 * Functions
 */

/******************************************************************************
 * Included Functions
 ******************************************************************************/

// Helpers function
require_once get_stylesheet_directory() . '/inc/helpers.php';
// Install Recommended plugins
require_once get_stylesheet_directory() . '/inc/recommended-plugins.php';
// Walker modification
require_once get_stylesheet_directory() . '/inc/class-bootstrap-navigation.php';
// Home slider function
include_once get_stylesheet_directory() . '/inc/home-slider.php';
// Dynamic admin
include_once get_stylesheet_directory() . '/inc/class-dynamic-admin.php';
// SVG Support
include_once get_stylesheet_directory() . '/inc/svg-support.php';
// Lazy Load
include_once get_stylesheet_directory() . '/inc/class-lazyload.php';
// Extend WP Search with Custom fields
include_once get_stylesheet_directory() . '/inc/custom-fields-search.php';
//Google Maps
include_once get_stylesheet_directory() . '/inc/google-maps.php';
// TinyMCE Customizations
include_once get_stylesheet_directory() . '/inc/tiny-mce-customizations.php';
// Gravity Forms Customizations
include_once get_stylesheet_directory() . '/inc/gravity-forms-customizations.php';
// Theme Customizations
include_once get_stylesheet_directory() . '/inc/theme-customizations.php';
// WooCommerce functionality
//include_once get_stylesheet_directory() . '/inc/woo-custom.php';
// Include all additional shortcodes
//include_once get_stylesheet_directory() . '/inc/shortcodes.php';

/******************************************************************************************************************************
 * Constants.
 *******************************************************************************************************************************/

define( 'IMAGE_PLACEHOLDER', get_stylesheet_directory_uri() . '/assets/images/placeholder.jpg' );

/******************************************************************************************************************************
 * Enqueue Scripts and Styles for Front-End
 *******************************************************************************************************************************/

function bootstrap_scripts_and_styles() {
	if ( ! is_admin() ) {

		// Disable gutenberg built-in styles
		wp_dequeue_style( 'wp-block-library' );

		// Load Stylesheets
		//core
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', null, '4.3.1' );

		//system
		wp_enqueue_style( 'custom', get_template_directory_uri() . '/assets/css/custom.css', null, null );/*2rd priority*/
		wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', null, null );/*1st priority*/

		// Load JavaScripts
		//core
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bootstrap.min', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', null, '4.3.1', true );

		//plugins
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/plugins/slick.min.js', null, '1.8.1', true );
		wp_enqueue_script( 'lazyload', get_template_directory_uri() . '/assets/js/plugins/lazyload.min.js', null, '12.4.0', true );
		wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/assets/js/plugins/jquery.matchHeight-min.js', null, '0.7.2', true );
//		wp_enqueue_script( 'fancybox.v2', get_template_directory_uri() . '/assets/js/plugins/jquery.fancybox.v2.js', null, '2.1.5', true );
		wp_enqueue_script( 'fancybox.v3', get_template_directory_uri() . '/assets/js/plugins/jquery.fancybox.v3.js', null, '3.5.2', true );
//		wp_enqueue_script( 'jarallax', get_template_directory_uri() . '/assets/js/plugins/jarallax.min.js', null, '1.12.0', true );

		//custom javascript
		wp_enqueue_script( 'global', get_template_directory_uri() . '/assets/js/global.js', null, null, true ); /* This should go first */

	}
}

add_action( 'wp_enqueue_scripts', 'bootstrap_scripts_and_styles' );

/******************************************************************************
 * Additional Functions
 *******************************************************************************/

// Dynamic Admin
if ( is_admin() ) {
	// $dynamic_admin = new DynamicAdmin();
	//	$dynamic_admin->addField( 'page', 'template', 'Page Template', 'template_detail_field_for_page' );

	// $dynamic_admin->run();
}

// Apply lazyload to whole page content
function lazyload() {
	ob_start( 'lazyloadBuffer' );
}

add_action( 'template_redirect', 'lazyload' );

/**
 * @param string $html HTML content.
 *
 * @return string
 */
function lazyloadBuffer( $html ) {
	$lazy   = new CreateLazyImg;
	$buffer = $lazy->ignoreScripts( $html );
	$buffer = $lazy->ignoreNoscripts( $buffer );

	$html = $lazy->lazyloadImages( $html, $buffer );
	$html = $lazy->lazyloadPictures( $html, $buffer );
	$html = $lazy->lazyloadBackgroundImages( $html, $buffer );

	return $html;
}

/******************* HIDE/SHOW WORDPRESS PLUGINS MENU ITEM *********************/

/**
 * Remove and Restore ability to Add new plugins to site
 */
function remove_plugins_menu_item( $role_name ) {
    $role = get_role( $role_name );
    $role->remove_cap( 'activate_plugins' );
    $role->remove_cap( 'install_plugins' );
    $role->remove_cap( 'upload_plugins' );
    $role->remove_cap( 'update_plugins' );
}

function restore_plugins_menu_item( $role_name ) {
    $role = get_role( $role_name );
    $role->add_cap( 'activate_plugins' );
    $role->add_cap( 'install_plugins' );
    $role->add_cap( 'upload_plugins' );
    $role->add_cap( 'update_plugins' );
}

// remove_plugins_menu_item('administrator');
// restore_plugins_menu_item('administrator');

/*********************** PUT YOU FUNCTIONS BELOW ********************************/

add_image_size( 'full_hd', 1920, 0, array( 'center', 'center' ) );
add_image_size( 'large_high', 1024, 0, false );
// add_image_size( 'name', width, height, array('center','center'));

// Disable gutenberg
add_filter('use_block_editor_for_post_type', '__return_false');