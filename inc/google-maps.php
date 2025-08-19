<?php
add_filter( 'acf/load_field/type=google_map', function ( $field ) {
    $google_map_api = 'https://maps.googleapis.com/maps/api/js';
    $api_args       = array(
        'key' => get_theme_mod( 'google_maps_api' ) ?: 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840',
        'language' => 'en',
        'v' => '3.exp'
    );
    wp_enqueue_script( 'google.maps.api', add_query_arg( $api_args, $google_map_api ), null, null, true );

    return $field;
} );

// Set Google Map API key
function set_custom_google_api_key() {
    acf_update_setting( 'google_api_key', get_theme_mod( 'google_maps_api' ) ?: 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840' );
}

add_action( 'acf/init', 'set_custom_google_api_key' );

// Register Google Maps API key settings in customizer
function register_google_maps_settings( $wp_customize ) {
    $wp_customize->add_section( 'google_maps', array(
        'title'    => __( 'Google Maps', 'default' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'google_maps_api', array(
        'default' => 'AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840',
    ) );
    $wp_customize->add_control( 'google_maps_api', array(
        'label'    => __( 'Google Maps API key', 'default' ),
        'section'  => 'google_maps',
        'settings' => 'google_maps_api',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'outline_color', array() );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'outline_color', array(
        'label' => __( 'Outline color', 'default' ),
        'section' => 'colors',
        'settings' => 'outline_color'
    ) ) );
}

add_action( 'customize_register', 'register_google_maps_settings' );