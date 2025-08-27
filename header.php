<?php
/**
 * Header
 */
?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <!-- Set up Meta -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta charset="<?php bloginfo( 'charset' ); ?>">

        <!-- Set the viewport width to device width for mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
        <!-- Remove Microsoft Edge's & Safari phone-email styling -->
        <meta name="format-detection" content="telephone=no,email=no,url=no">

        <!-- Add external fonts below (GoogleFonts / Typekit) -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&display=swap">

        <?php wp_head(); ?>
    </head>

<body <?php body_class('no-outline'); ?>>
<?php wp_body_open(); ?>

    <!-- BEGIN of Alert Bar -->
<?php if (get_field('enable_alert_bar', 'options')) :
    $bg_color = get_field('alert_background_color', 'options');
    $text_color = get_field('alert_text_color', 'options');
    $content = get_field('alert_content', 'options');

    if ( $content ): ?>
        <div id="alert-bar" class="alert-bar"
             style="background-color: <?php echo $bg_color; ?>; color: <?php echo $text_color; ?>;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="alert-bar__content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
endif; ?>
    <!-- END of Alert Bar -->

    <!-- BEGIN of header -->
    <header class="header header--fixed">
        <!-- BEGIN of partners bar - DESKTOP ONLY -->
        <?php if ( have_rows( 'partners_logos', 'options' ) ): ?>
            <div class="partners-bar d-none d-md-block">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="partners-bar__logos">
                                <?php while ( have_rows( 'partners_logos', 'options' ) ): the_row(); ?>
                                    <?php
                                    $partner_logo = get_sub_field( 'partner_logo' );
                                    $partner_text = get_sub_field( 'partner_text' );
                                    $partner_link = get_sub_field( 'partner_link' );
                                    ?>
                                    <div class="partners-bar__logo">
                                        <?php if ( $partner_link ): ?>
                                            <a href="<?php echo esc_url( $partner_link ); ?>" target="_blank" rel="noopener">
                                                <?php if ( $partner_logo ): ?>
                                                    <?php echo wp_get_attachment_image( $partner_logo['ID'], 'medium', false, array( 'alt' => $partner_logo['alt'] ) ); ?>
                                                <?php elseif ( $partner_text ): ?>
                                                    <span class="partner-text"><?php echo esc_html( $partner_text ); ?></span>
                                                <?php endif; ?>
                                            </a>
                                        <?php else: ?>
                                            <?php if ( $partner_logo ): ?>
                                                <?php echo wp_get_attachment_image( $partner_logo['ID'], 'medium', false, array( 'alt' => $partner_logo['alt'] ) ); ?>
                                            <?php elseif ( $partner_text ): ?>
                                                <span class="partner-text"><?php echo esc_html( $partner_text ); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- END of partners bar -->

        <!-- BEGIN of main header -->
        <div class="container menu-container px-0 px-md-g">
            <!-- MOBILE LAYOUT -->
            <div class="row d-md-none mobile-header-row no-gutters">
                <!-- Mobile Header Top: Logo + Burger -->
                <div class="col-12">
                    <div class="mobile-header-top">
                        <div class="logo">
                            <h1><?php show_custom_logo(); ?><span class="css-clip"><?php echo get_bloginfo( 'name' ); ?></span></h1>
                        </div>

                        <?php if ( has_nav_menu( 'header-menu' ) ) : ?>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Mobile Header Middle: Social + Phone + CTA -->
                <div class="col-12">
                    <div class="mobile-header-middle">
                        <!-- Facebook Icon -->
                        <?php if ( have_rows( 'header_social_links', 'options' ) ): ?>
                            <?php while ( have_rows( 'header_social_links', 'options' ) ): the_row(); ?>
                                <?php
                                $social_platform = get_sub_field( 'social_platform' );
                                $social_url = get_sub_field( 'social_url' );
                                if ( $social_platform === 'facebook' && $social_url ): ?>
                                    <a href="<?php echo esc_url( $social_url ); ?>" class="mobile-facebook-link" target="_blank" rel="noopener">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php endif; ?>

                        <!-- Phone -->
                        <?php if ( $phone = get_field( 'header_phone', 'options' ) ): ?>
                            <a href="tel:<?php echo sanitize_number( $phone ); ?>" class="mobile-phone-link">
                                <i class="fas fa-phone"></i>
                                <?php echo esc_html( $phone ); ?>
                            </a>
                        <?php endif; ?>

                        <!-- CTA Button -->
                        <a href="/request-quote" class="mobile-cta-button">REQUEST A QUOTE</a>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div class="col-12">
                    <?php if ( has_nav_menu( 'header-menu' ) ) : ?>
                        <div class="navbar navbar-expand-md">
                            <nav class="collapse navbar-collapse" id="mainMenu">
                                <?php wp_nav_menu( array(
                                    'theme_location' => 'header-menu',
                                    'menu_class'     => 'header-menu navbar-nav flex-wrap w-100',
                                    'container'      => false,
                                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'walker'         => new Bootstrap_Navigation(),
                                ) ); ?>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Mobile Partners Bar -->
                <?php if ( have_rows( 'partners_logos', 'options' ) ): ?>
                    <div class="col-12">
                        <div class="partners-bar-mobile">
                            <div class="partners-bar__logos">
                                <?php while ( have_rows( 'partners_logos', 'options' ) ): the_row(); ?>
                                    <?php
                                    $partner_logo = get_sub_field( 'partner_logo' );
                                    $partner_text = get_sub_field( 'partner_text' );
                                    $partner_link = get_sub_field( 'partner_link' );
                                    ?>
                                    <div class="partners-bar__logo">
                                        <?php if ( $partner_link ): ?>
                                            <a href="<?php echo esc_url( $partner_link ); ?>" target="_blank" rel="noopener">
                                                <?php if ( $partner_logo ): ?>
                                                    <?php echo wp_get_attachment_image( $partner_logo['ID'], 'medium', false, array( 'alt' => $partner_logo['alt'] ) ); ?>
                                                <?php elseif ( $partner_text ): ?>
                                                    <span class="partner-text"><?php echo esc_html( $partner_text ); ?></span>
                                                <?php endif; ?>
                                            </a>
                                        <?php else: ?>
                                            <?php if ( $partner_logo ): ?>
                                                <?php echo wp_get_attachment_image( $partner_logo['ID'], 'medium', false, array( 'alt' => $partner_logo['alt'] ) ); ?>
                                            <?php elseif ( $partner_text ): ?>
                                                <span class="partner-text"><?php echo esc_html( $partner_text ); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- DESKTOP LAYOUT -->
            <div class="row no-gutters-xs d-none d-md-flex">
                <!-- Logo Column -->
                <div class="col-lg-2 col-md-2 d-flex align-items-center">
                    <div class="logo">
                        <h1><?php show_custom_logo(); ?><span class="css-clip"><?php echo get_bloginfo( 'name' ); ?></span></h1>
                    </div>
                </div>

                <!-- Content Column (Contacts + Navigation) -->
                <div class="col-lg-10 col-md-10">
                    <div class="header-content">
                        <!-- Top row with contacts and social -->
                        <div class="header-top">
                            <div class="header-contacts">
                                <?php if ( $phone = get_field( 'header_phone', 'options' ) ): ?>
                                    <div class="header-contacts__item">
                                        <a href="tel:<?php echo sanitize_number( $phone ); ?>" class="header-contacts__phone">
                                            <i class="fas fa-phone" aria-hidden="true"></i>
                                            <?php echo esc_html( $phone ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $location_text = get_field( 'header_location_text', 'options' ) ): ?>
                                    <div class="header-contacts__item">
                                    <span class="header-contacts__location">
                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                        <?php echo esc_html( $location_text ); ?>
                                    </span>
                                    </div>
                                <?php endif; ?>

                                <?php if ( have_rows( 'header_social_links', 'options' ) ): ?>
                                    <div class="header-contacts__item">
                                        <div class="header-social">
                                            <?php while ( have_rows( 'header_social_links', 'options' ) ): the_row(); ?>
                                                <?php
                                                $social_platform = get_sub_field( 'social_platform' );
                                                $social_url = get_sub_field( 'social_url' );

                                                // Define social icons
                                                $social_icons = array(
                                                    'facebook' => 'fab fa-facebook-f',
                                                    'instagram' => 'fab fa-instagram',
                                                    'twitter' => 'fab fa-twitter',
                                                    'linkedin' => 'fab fa-linkedin-in',
                                                    'youtube' => 'fab fa-youtube',
                                                    'tiktok' => 'fab fa-tiktok'
                                                );

                                                $icon_class = isset($social_icons[$social_platform]) ? $social_icons[$social_platform] : 'fas fa-link';
                                                ?>
                                                <?php if ( $social_url ): ?>
                                                    <a href="<?php echo esc_url( $social_url ); ?>" class="header-social__link" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( ucfirst($social_platform) ); ?>">
                                                        <i class="<?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Bottom row with navigation -->
                        <div class="header-bottom">
                            <?php if ( has_nav_menu( 'header-menu' ) ) : ?>
                                <div class="navbar navbar-expand-md">
                                    <nav class="collapse navbar-collapse" id="mainMenu">
                                        <?php wp_nav_menu( array(
                                            'theme_location' => 'header-menu',
                                            'menu_class'     => 'header-menu navbar-nav flex-wrap w-100',
                                            'container'      => false,
                                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                            'walker'         => new Bootstrap_Navigation(),
                                        ) ); ?>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END of main header -->
    </header>
    <!-- END of header -->

<?php if ( ! is_front_page() && ! is_home() ): ?>
    <?php get_template_part( 'parts/hero-banner' ); ?>
<?php endif; ?>