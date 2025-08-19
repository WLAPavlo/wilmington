<?php
$module_class = esc_attr( get_sub_field('module_class') ?: '' );
$module_id_raw = get_sub_field('module_id');
$module_id_attr = $module_id_raw ? ' id="' . esc_attr( $module_id_raw ) . '"' : '';

$content = get_sub_field('content');

if ( empty( $content ) ) return;
?>

<section class="module module--example-module <?= $module_class; ?>" <?= $module_id_attr; ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</section>