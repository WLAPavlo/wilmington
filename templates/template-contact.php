<?php
/**
 * Template Name: Contact Page
 */

get_header(); ?>

<?php if (!is_front_page() && !is_home()): ?>
    <?php show_template('hero-banner', array('title' => get_the_title(), 'image' => get_post_thumbnail_id())); ?>
<?php endif; ?>

    <main class="main-content">
        <section class="contact">
            <?php if ( have_posts() ): ?>
                <?php while ( have_posts() ): the_post(); ?>
                    <article id="<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="contact__content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                                <?php if ( ( $contact_form = get_field( 'contact_form' ) ) && is_array( $contact_form ) ): ?>
                                    <div class="col-12">
                                        <div class="contact__form">
                                            <?php echo do_shortcode( "[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']" ); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

<?php get_footer(); ?>