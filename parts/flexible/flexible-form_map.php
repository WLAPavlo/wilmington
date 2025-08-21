<?php
$module_class = esc_attr( get_sub_field('module_class') ?: '' );
$module_id_raw = get_sub_field('module_id');
$module_id_attr = $module_id_raw ? ' id="' . esc_attr( $module_id_raw ) . '"' : '';

$contact_form = get_sub_field('contact_form');
$form_position = get_sub_field('form_position') ?: 'left';
$map_type = get_sub_field('map_type') ?: 'embed';
$map_image = get_sub_field('map_image');
$map_image_link = get_sub_field('map_image_link');
$map_embed = get_sub_field('map_embed');

if ( empty( $contact_form ) && empty( $map_image ) && empty( $map_embed ) ) {
    return;
}

// Function to convert Google Maps URL to embed URL
function convert_google_maps_url( $url ) {
    if ( empty( $url ) ) {
        return '';
    }

    // If it's already an embed code, return as is
    if ( strpos( $url, '<iframe' ) !== false ) {
        return $url;
    }

    // If it's a Google Maps URL, convert to embed
    if ( strpos( $url, 'maps.google.com' ) !== false || strpos( $url, 'goo.gl/maps' ) !== false ) {
        // Extract coordinates or place ID from various Google Maps URL formats
        $embed_url = '';

        // Handle different Google Maps URL formats
        if ( preg_match('/place\/([^\/]+)/', $url, $matches) ) {
            $place = urlencode( $matches[1] );
            $embed_url = "https://www.google.com/maps/embed/v1/place?key=AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840&q={$place}";
        } elseif ( preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches) ) {
            $lat = $matches[1];
            $lng = $matches[2];
            $embed_url = "https://www.google.com/maps/embed/v1/view?key=AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840&center={$lat},{$lng}&zoom=15";
        } else {
            // Fallback: try to extract query and use search
            $query = parse_url( $url, PHP_URL_QUERY );
            if ( $query && strpos( $query, 'q=' ) !== false ) {
                parse_str( $query, $params );
                if ( isset( $params['q'] ) ) {
                    $search = urlencode( $params['q'] );
                    $embed_url = "https://www.google.com/maps/embed/v1/search?key=AIzaSyBgg23TIs_tBSpNQa8RC0b7fuV4SOVN840&q={$search}";
                }
            }
        }

        if ( $embed_url ) {
            return '<iframe src="' . esc_url( $embed_url ) . '" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        }
    }

    return $url;
}
?>

<section class="module module--form-map <?= $module_class; ?>" <?= $module_id_attr; ?>>
    <div class="container-fluid">
        <div class="row no-gutters">
            <?php if ( $form_position === 'left' ): ?>
                <!-- Form Content - Left -->
                <div class="col-lg-6 col-md-6 col-sm-12 form-map__form-section">
                    <div class="form-map__form-content">
                        <div class="form-map__form-inner">
                            <?php if ( $contact_form && is_array( $contact_form ) ): ?>
                                <?php echo do_shortcode( "[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']" ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Map Content - Right -->
                <div class="col-lg-6 col-md-6 col-sm-12 form-map__map-section">
                    <?php if ( $map_type === 'image' && $map_image ): ?>
                        <div class="form-map__map-image">
                            <?php if ( $map_image_link ): ?>
                                <a href="<?php echo esc_url( $map_image_link ); ?>" target="_blank" rel="noopener">
                                    <?php echo wp_get_attachment_image( $map_image['ID'], 'large', false, array( 'class' => 'form-map__img' ) ); ?>
                                </a>
                            <?php else: ?>
                                <?php echo wp_get_attachment_image( $map_image['ID'], 'large', false, array( 'class' => 'form-map__img' ) ); ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ( $map_type === 'embed' && $map_embed ): ?>
                        <div class="form-map__map-embed">
                            <?php echo convert_google_maps_url( $map_embed ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Map Content - Left -->
                <div class="col-lg-6 col-md-6 col-sm-12 form-map__map-section">
                    <?php if ( $map_type === 'image' && $map_image ): ?>
                        <div class="form-map__map-image">
                            <?php if ( $map_image_link ): ?>
                                <a href="<?php echo esc_url( $map_image_link ); ?>" target="_blank" rel="noopener">
                                    <?php echo wp_get_attachment_image( $map_image['ID'], 'large', false, array( 'class' => 'form-map__img' ) ); ?>
                                </a>
                            <?php else: ?>
                                <?php echo wp_get_attachment_image( $map_image['ID'], 'large', false, array( 'class' => 'form-map__img' ) ); ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ( $map_type === 'embed' && $map_embed ): ?>
                        <div class="form-map__map-embed">
                            <?php echo convert_google_maps_url( $map_embed ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Form Content - Right -->
                <div class="col-lg-6 col-md-6 col-sm-12 form-map__form-section">
                    <div class="form-map__form-content">
                        <div class="form-map__form-inner">
                            <?php if ( $contact_form && is_array( $contact_form ) ): ?>
                                <?php echo do_shortcode( "[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']" ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>