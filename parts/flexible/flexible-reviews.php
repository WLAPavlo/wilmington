<?php
$module_class = esc_attr( get_sub_field('module_class') ?: '' );
$module_id_raw = get_sub_field('module_id');
$module_id_attr = $module_id_raw ? ' id="' . esc_attr( $module_id_raw ) . '"' : '';

$selected_reviews = get_sub_field('reviews_selection');

if ( empty( $selected_reviews ) ) {
    return;
}

// Get selected review IDs
$selected_review_ids = array();
foreach ( $selected_reviews as $review ) {
    $selected_review_ids[] = $review->ID;
}
?>

<section class="module module--reviews <?= $module_class; ?>" <?= $module_id_attr; ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="reviews-slider" id="reviews-slider">
                    <?php foreach ( $selected_reviews as $review ): ?>
                        <?php
                        $review_author = get_post_meta( $review->ID, 'review_author', true );
                        $review_source = get_post_meta( $review->ID, 'review_source', true );
                        $review_stars = get_post_meta( $review->ID, 'review_stars', true ) ?: 5;
                        $review_content = apply_filters( 'the_content', $review->post_content );

                        // Source images mapping
                        $source_images = array(
                            'google' => get_template_directory_uri() . '/assets/images/google.png',
                            'facebook' => get_template_directory_uri() . '/assets/images/facebook.png',
                            'yelp' => get_template_directory_uri() . '/assets/images/yelp.png',
                            'website' => get_template_directory_uri() . '/assets/images/website.png',
                            'other' => get_template_directory_uri() . '/assets/images/star.png'
                        );

                        $source_image = isset( $source_images[$review_source] ) ? $source_images[$review_source] : $source_images['other'];
                        $source_alt = ucfirst( $review_source ?: 'review' ) . ' review';
                        ?>
                        <div class="reviews-slide">
                            <div class="review-card">
                                <div class="review-card__content">
                                    <?php echo wp_kses_post( $review_content ); ?>
                                </div>

                                <div class="review-card__info">
                                    <div class="review-card__footer">
                                        <div class="review-card__source">
                                            <img src="<?php echo esc_url( $source_image ); ?>"
                                                 alt="<?php echo esc_attr( $source_alt ); ?>"
                                                 loading="lazy" />
                                        </div>

                                        <div class="review-card__stars">
                                            <?php for ( $i = 1; $i <= 5; $i++ ): ?>
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/star.png"
                                                     alt="<?php echo $i <= $review_stars ? 'Filled star' : 'Empty star'; ?>"
                                                     style="opacity: <?php echo $i <= $review_stars ? '1' : '0.3'; ?>;"
                                                     loading="lazy" />
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <?php if ( $review_author ): ?>
                                        <div class="review-card__author">
                                            <?php echo esc_html( $review_author ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ( count( $selected_reviews ) > 1 ): ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#reviews-slider').slick({
                    dots: true,
                    arrows: true,
                    infinite: true,
                    speed: 600,
                    easing: 'ease-in-out',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 7000,
                    pauseOnHover: true,
                    adaptiveHeight: false,
                    cssEase: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
                    prevArrow: '<button type="button" class="slick-prev reviews-arrow reviews-arrow--prev"><i class="fas fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next reviews-arrow reviews-arrow--next"><i class="fas fa-chevron-right"></i></button>',
                    customPaging: function(slider, i) {
                        return '<button type="button" class="reviews-dot"></button>';
                    },
                    dotsClass: 'reviews-dots',
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                speed: 500,
                                autoplaySpeed: 6000
                            }
                        }
                    ]
                });
            });
        </script>
    <?php endif; ?>
</section>