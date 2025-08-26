<?php
$module_class = esc_attr( get_sub_field('module_class') ?: '' );
$module_id_raw = get_sub_field('module_id');
$module_id_attr = $module_id_raw ? ' id="' . esc_attr( $module_id_raw ) . '"' : '';

$projects = get_sub_field('projects_list');

if ( empty( $projects ) ) {
    return;
}
?>

<section class="module module--projects <?= $module_class; ?>" <?= $module_id_attr; ?>>
    <div class="container">
        <div class="projects-list">
            <?php foreach ( $projects as $index => $project ): ?>
                <?php
                $project_title = $project['project_title'];
                $project_subtitle = $project['project_subtitle'];
                $project_description = $project['project_description'];
                $project_gallery = $project['project_gallery'];

                if ( empty( $project_gallery ) ) {
                    continue;
                }
                ?>
                <div class="project-item">
                    <?php if ( count( $project_gallery ) > 1 ): ?>
                        <!-- Multiple images - show as slider -->
                        <div class="project-item__gallery" id="project-gallery-<?php echo $index; ?>">
                            <?php foreach ( $project_gallery as $image ): ?>
                                <div class="project-gallery__slide">
                                    <?php echo wp_get_attachment_image( $image['ID'], 'large', false, array( 'class' => 'project-gallery__img' ) ); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <!-- Single image -->
                        <div class="project-item__image">
                            <?php echo wp_get_attachment_image( $project_gallery[0]['ID'], 'large', false, array( 'class' => 'project-item__img' ) ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="project-item__content">
                        <?php if ( $project_title ): ?>
                            <h2 class="project-item__title"><?php echo esc_html( $project_title ); ?></h2>
                        <?php endif; ?>

                        <?php if ( $project_subtitle ): ?>
                            <h3 class="project-item__subtitle"><?php echo esc_html( $project_subtitle ); ?></h3>
                        <?php endif; ?>

                        <?php if ( $project_description ): ?>
                            <div class="project-item__description">
                                <?php echo wp_kses_post( $project_description ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    // Check if any project has multiple images for slider initialization
    $has_sliders = false;
    foreach ( $projects as $project ) {
        if ( !empty( $project['project_gallery'] ) && count( $project['project_gallery'] ) > 1 ) {
            $has_sliders = true;
            break;
        }
    }
    ?>

    <?php if ( $has_sliders ): ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                <?php foreach ( $projects as $index => $project ): ?>
                <?php if ( !empty( $project['project_gallery'] ) && count( $project['project_gallery'] ) > 1 ): ?>
                $('#project-gallery-<?php echo $index; ?>').slick({
                    dots: true,
                    arrows: true,
                    infinite: true,
                    speed: 500,
                    fade: true,
                    cssEase: 'ease-in-out',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: false,
                    adaptiveHeight: false,
                    prevArrow: '<button type="button" class="slick-prev"></button>',
                    nextArrow: '<button type="button" class="slick-next"></button>',
                    customPaging: function(slider, i) {
                        return '<button type="button"></button>';
                    },
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: true,
                                dots: true
                            }
                        }
                    ]
                });
                <?php endif; ?>
                <?php endforeach; ?>
            });
        </script>
    <?php endif; ?>
</section>