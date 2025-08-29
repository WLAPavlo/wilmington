<?php
$module_class = esc_attr( get_sub_field('module_class') ?: '' );
$module_id_raw = get_sub_field('module_id');
$module_id_attr = $module_id_raw ? ' id="' . esc_attr( $module_id_raw ) . '"' : '';

$section_title = get_sub_field('section_title') ?: 'Our Products';
$content = get_sub_field('content');
$right_buttons = get_sub_field('right_buttons');
$selected_products = get_sub_field('products_selection');
$bottom_buttons = get_sub_field('bottom_buttons');

// Get all product categories for dropdown
$product_categories = get_terms( array(
    'taxonomy' => 'product_category',
    'hide_empty' => false,
) );

// Get selected product IDs for JavaScript
$selected_product_ids = array();
if ( $selected_products ) {
    foreach ( $selected_products as $product ) {
        $selected_product_ids[] = $product->ID;
    }
}
?>

<section class="module module--products <?= $module_class; ?>" <?= $module_id_attr; ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="products-section">
                    <!-- Header Section -->
                    <div class="products-section__header">
                        <div class="row align-items-start">
                            <!-- Left Column - Title, Filter, Content -->
                            <div class="col-12">
                                <div class="row align-items-start">
                                    <div class="col-lg-9 col-md-7 col-sm-12">
                                        <h2 class="products-section__title"><?php echo esc_html( $section_title ); ?></h2>

                                        <!-- Right Column Buttons - Mobile Order -->
                                        <?php if ( $right_buttons ): ?>
                                            <div class="products-section__buttons products-section__buttons--mobile d-lg-none">
                                                <?php foreach ( $right_buttons as $button ): ?>
                                                    <a href="<?php echo esc_url( $button['button_url'] ); ?>"
                                                       class="btn btn-<?php echo esc_attr( $button['button_color'] ); ?>"
                                                        <?php echo $button['button_new_tab'] ? 'target="_blank" rel="noopener"' : ''; ?>>
                                                        <?php echo esc_html( $button['button_text'] ); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="products-section__controls d-none d-lg-block">
                                            <select class="products-filter" id="products-filter">
                                                <option value="all">All</option>
                                                <?php if ( $product_categories && !is_wp_error( $product_categories ) ): ?>
                                                    <?php foreach ( $product_categories as $category ): ?>
                                                        <option value="<?php echo esc_attr( $category->slug ); ?>">
                                                            <?php echo esc_html( $category->name ); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <?php if ( $content ): ?>
                                            <div class="products-section__content">
                                                <?php echo wp_kses_post( $content ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Right Column - Buttons -->
                                    <div class="col-lg-3 col-md-5 col-sm-12">
                                        <?php if ( $right_buttons ): ?>
                                            <div class="products-section__buttons products-section__buttons--right d-none d-lg-block">
                                                <?php foreach ( $right_buttons as $button ): ?>
                                                    <a href="<?php echo esc_url( $button['button_url'] ); ?>"
                                                       class="btn btn-<?php echo esc_attr( $button['button_color'] ); ?>"
                                                        <?php echo $button['button_new_tab'] ? 'target="_blank" rel="noopener"' : ''; ?>>
                                                        <?php echo esc_html( $button['button_text'] ); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid" id="products-grid">
                        <div class="products-row" id="products-container">
                            <?php
                            // Display selected products or all products
                            // For home page, limit to 8 products by design
                            $posts_per_page = is_front_page() ? 8 : -1;

                            $args = array(
                                'post_type' => 'products',
                                'posts_per_page' => $posts_per_page,
                                'post_status' => 'publish',
                                'orderby' => 'menu_order',
                                'order' => 'ASC'
                            );

                            if ( !empty( $selected_product_ids ) ) {
                                $args['post__in'] = $selected_product_ids;
                                $args['orderby'] = 'post__in';
                                // If on home page and selected products > 8, limit to first 8
                                if ( is_front_page() && count( $selected_product_ids ) > 8 ) {
                                    $args['post__in'] = array_slice( $selected_product_ids, 0, 8 );
                                }
                            }

                            $products_query = new WP_Query( $args );

                            if ( $products_query->have_posts() ):
                                while ( $products_query->have_posts() ): $products_query->the_post();
                                    $categories = wp_get_object_terms( get_the_ID(), 'product_category', array( 'fields' => 'slugs' ) );
                                    ?>
                                    <div class="products-grid__item" data-categories="<?php echo esc_attr( implode( ',', $categories ) ); ?>">
                                        <div class="product-card">
                                            <?php if ( has_post_thumbnail() ): ?>
                                                <div class="product-card__image">
                                                    <?php the_post_thumbnail( 'medium_large', array( 'class' => 'product-card__img' ) ); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="product-card__content">
                                                <h4 class="product-card__title"><?php the_title(); ?></h4>
                                                <?php if ( get_the_excerpt() ): ?>
                                                    <p class="product-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                            else:
                                ?>
                                <div class="products-grid__item" style="flex: 1 0 100%;">
                                    <p class="text-center">No products found.</p>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Bottom Buttons -->
                    <?php if ( $bottom_buttons ): ?>
                        <div class="products-section__bottom">
                            <div class="products-section__buttons products-section__buttons--bottom">
                                <?php foreach ( $bottom_buttons as $button ): ?>
                                    <a href="<?php echo esc_url( $button['button_url'] ); ?>"
                                       class="btn btn-<?php echo esc_attr( $button['button_color'] ); ?>"
                                        <?php echo $button['button_new_tab'] ? 'target="_blank" rel="noopener"' : ''; ?>>
                                        <?php echo esc_html( $button['button_text'] ); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var selectedProducts = <?php echo json_encode( $selected_product_ids ); ?>;
            var isHomePage = <?php echo is_front_page() ? 'true' : 'false'; ?>;

            $('#products-filter').on('change', function() {
                var selectedCategory = $(this).val();
                var $container = $('#products-container');
                var $grid = $('#products-grid');

                // Show loading state
                $grid.addClass('loading');

                $.ajax({
                    url: ajax.url,
                    type: 'POST',
                    data: {
                        action: 'filter_products',
                        nonce: ajax.nonce,
                        category: selectedCategory,
                        selected_products: selectedProducts,
                        is_home_page: isHomePage
                    },
                    beforeSend: function() {
                        // Add smooth fade out effect
                        $container.css('opacity', '0.3');
                    },
                    success: function(response) {
                        if (response.success) {
                            // Smooth content replacement
                            setTimeout(function() {
                                $container.html(response.html);
                                $container.css('opacity', '1');
                                $grid.removeClass('loading');
                            }, 200);
                        } else {
                            $container.css('opacity', '1');
                            $grid.removeClass('loading');
                        }
                    },
                    error: function() {
                        $container.css('opacity', '1');
                        $grid.removeClass('loading');
                        console.log('Error filtering products');
                    }
                });
            });
        });
    </script>
</section>