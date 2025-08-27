<?php
/**
 * Template Name: Contact Page
 */

get_header(); ?>

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