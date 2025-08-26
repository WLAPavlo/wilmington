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

                // Use first image from gallery
                $main_image = $project_gallery[0];
                ?>
                <div class="project-item">
                    <div class="project-item__image">
                        <?php echo wp_get_attachment_image( $main_image['ID'], 'large', false, array( 'class' => 'project-item__img' ) ); ?>
                    </div>

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
</section>