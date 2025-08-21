<?php
$module_class = esc_attr( get_sub_field('module_class') ?: '' );
$module_id_raw = get_sub_field('module_id');
$module_id_attr = $module_id_raw ? ' id="' . esc_attr( $module_id_raw ) . '"' : '';

$content = get_sub_field('content');
$text_position = get_sub_field('text_position') ?: 'left';
$media_type = get_sub_field('media_type') ?: 'image';
$section_image = get_sub_field('section_image');
$image_display = get_sub_field('image_display') ?: 'fit';
$section_video = get_sub_field('section_video');

if ( empty( $content ) && empty( $section_image ) && empty( $section_video ) ) {
    return;
}
?>

<section class="module module--text-image <?= $module_class; ?>" <?= $module_id_attr; ?>>
    <div class="container">
        <div class="row align-items-center">
            <?php if ( $text_position === 'left' ): ?>
                <!-- Text Content - Left -->
                <div class="col-lg-6 col-md-6 col-sm-12 text-image__content">
                    <?php if ( $content ): ?>
                        <div class="text-image__text">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Media Content - Right -->
                <div class="col-lg-6 col-md-6 col-sm-12 text-image__media">
                    <?php if ( $media_type === 'image' && $section_image ): ?>
                        <div class="text-image__image text-image__image--<?php echo esc_attr( $image_display ); ?>">
                            <?php echo wp_get_attachment_image( $section_image['ID'], 'large', false, array( 'class' => 'text-image__img' ) ); ?>
                        </div>
                    <?php elseif ( $media_type === 'video' && $section_video ): ?>
                        <div class="text-image__video">
                            <?php if ( is_embed_video( $section_video ) ): ?>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <?php echo wp_oembed_get( $section_video ); ?>
                                </div>
                            <?php else: ?>
                                <video controls class="text-image__video-element">
                                    <source src="<?php echo esc_url( $section_video ); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Media Content - Left -->
                <div class="col-lg-6 col-md-6 col-sm-12 text-image__media">
                    <?php if ( $media_type === 'image' && $section_image ): ?>
                        <div class="text-image__image text-image__image--<?php echo esc_attr( $image_display ); ?>">
                            <?php echo wp_get_attachment_image( $section_image['ID'], 'large', false, array( 'class' => 'text-image__img' ) ); ?>
                        </div>
                    <?php elseif ( $media_type === 'video' && $section_video ): ?>
                        <div class="text-image__video">
                            <?php if ( is_embed_video( $section_video ) ): ?>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <?php echo wp_oembed_get( $section_video ); ?>
                                </div>
                            <?php else: ?>
                                <video controls class="text-image__video-element">
                                    <source src="<?php echo esc_url( $section_video ); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Text Content - Right -->
                <div class="col-lg-6 col-md-6 col-sm-12 text-image__content">
                    <?php if ( $content ): ?>
                        <div class="text-image__text">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>