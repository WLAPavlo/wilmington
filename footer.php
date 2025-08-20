<?php
/**
 * Footer
 */
?>

<!-- BEGIN of footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Contact Information Column -->
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="footer__contact">
                    <?php if ( $contact_title = get_field( 'footer_contact_title', 'options' ) ): ?>
                        <h5 class="footer__title"><?php echo esc_html( $contact_title ); ?></h5>
                    <?php endif; ?>

                    <div class="footer__contact-info">
                        <?php if ($address = get_field('address', 'options')): ?>
                            <div class="footer__contact-item footer__contact-item--address">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                <div class="footer__contact-text">
                                    <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($address); ?>"
                                       target="_blank">
                                        <?php echo wp_kses_post($address); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ( $office_hours = get_field( 'footer_office_hours', 'options' ) ): ?>
                            <div class="footer__contact-item footer__contact-item--hours">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <div class="footer__contact-text">
                                    <?php echo wp_kses_post( $office_hours ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ( $phone = get_field( 'phone', 'options' ) ): ?>
                            <div class="footer__contact-item footer__contact-item--phone">
                                <i class="fas fa-phone" aria-hidden="true"></i>
                                <div class="footer__contact-text">
                                    <a href="tel:<?php echo sanitize_number( $phone ); ?>"><?php echo esc_html( $phone ); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Footer Menu Columns -->
            <?php
            $footer_menu_items = wp_get_nav_menu_items('footer-menu');
            $items_per_column = get_field( 'footer_menu_columns', 'options' ) ?: 6;

            if ( $footer_menu_items ) {
                $total_items = count( $footer_menu_items );
                $columns = ceil( $total_items / $items_per_column );
                $columns = min( $columns, 2 );

                for ( $col = 0; $col < $columns; $col++ ) {
                    $start_index = $col * $items_per_column;
                    $end_index = min( $start_index + $items_per_column, $total_items );
                    $column_items = array_slice( $footer_menu_items, $start_index, $items_per_column );

                    if ( !empty( $column_items ) ) : ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="footer__menu-column">
                                <ul class="footer__menu">
                                    <?php foreach ( $column_items as $item ) : ?>
                                        <li class="footer__menu-item">
                                            <a href="<?php echo esc_url( $item->url ); ?>" class="footer__menu-link">
                                                <?php echo esc_html( $item->title ); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif;
                }
            } ?>

            <!-- Logo and Copyright Column -->
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="footer__brand">
                    <div class="footer__logo">
                        <?php if ( $footer_logo = get_field( 'footer_logo', 'options' ) ):
                            echo wp_get_attachment_image( $footer_logo['id'], 'medium', false, array( 'class' => 'footer__logo-img' ) );
                        else:
                            show_custom_logo();
                        endif; ?>
                    </div>

                    <?php if ( $copyright = get_field( 'copyright', 'options' ) ): ?>
                        <div class="footer__copyright">
                            <?php echo wp_kses_post( $copyright ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END of footer -->

<button id="back-to-top"><span class="arrow"></span></button>

<?php wp_footer(); ?>
<?php if ( $ada_script = get_field( 'ada', 'options' ) ) : ?>
    <?php echo $ada_script; ?>
<?php endif; ?>
</body>
</html>