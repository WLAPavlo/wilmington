<?php
$module_class = esc_attr( get_sub_field('module_class') ?: '' );
$module_id_raw = get_sub_field('module_id');
$module_id_attr = $module_id_raw ? ' id="' . esc_attr( $module_id_raw ) . '"' : '';

$selected_careers = get_sub_field('careers_selection');

if ( empty( $selected_careers ) ) {
    // If no specific careers selected, show all
    $args = array(
        'post_type' => 'careers',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    $careers_query = new WP_Query( $args );
    $careers_to_display = $careers_query->posts;
} else {
    $careers_to_display = $selected_careers;
}

if ( empty( $careers_to_display ) ) {
    return;
}
?>

    <section class="module module--careers <?= $module_class; ?>" <?= $module_id_attr; ?>>
        <div class="container">
            <div class="careers-list">
                <?php foreach ( $careers_to_display as $career ): ?>
                    <?php
                    $career_id = is_object( $career ) ? $career->ID : $career;
                    $career_title = is_object( $career ) ? $career->post_title : get_the_title( $career );
                    $career_content = is_object( $career ) ? $career->post_content : get_post_field( 'post_content', $career );
                    $career_permalink = get_permalink( $career_id );
                    ?>
                    <div class="career-item">
                        <div class="career-item__header">
                            <h2 class="career-item__title"><?php echo esc_html( $career_title ); ?></h2>
                            <p class="career-item__subtitle">Wilmington Door & Hardware is now looking for an independent-minded, solutions-oriented Installation Technician for our road crews. This individual will...</p>
                        </div>

                        <?php if ( $career_content ): ?>
                            <div class="career-item__content">
                                <?php echo wp_kses_post( apply_filters( 'the_content', $career_content ) ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="career-item__actions">
                            <a href="<?php echo esc_url( $career_permalink ); ?>" class="career-item__btn career-item__btn--outline">
                                View Details
                            </a>
                            <a href="<?php echo esc_url( home_url( '/employment/?job-title=' . urlencode( $career_title ) ) ); ?>"
                               class="career-item__btn career-item__btn--teal">
                                Submit Resume
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php if ( isset( $careers_query ) ) wp_reset_postdata(); ?>