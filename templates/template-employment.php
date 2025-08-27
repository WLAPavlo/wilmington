<?php
/**
 * Template Name: Employment Page
 */
get_header();

// Get job title from URL parameter
$job_title = isset( $_GET['job-title'] ) ? sanitize_text_field( $_GET['job-title'] ) : '';
?>

    <main class="main-content template-employment" style="padding: 0;">
        <!-- Employment Form Section -->
        <section class="module module--employment-form">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if ( have_posts() ): ?>
                            <?php while ( have_posts() ): the_post(); ?>
                                <article <?php post_class('entry'); ?>>
                                    <?php if ( get_the_content() ): ?>
                                        <div class="entry__content employment-page__intro">
                                            <?php the_content( '', true ); ?>
                                        </div>
                                    <?php endif; ?>
                                </article>
                            <?php endwhile; ?>
                        <?php endif; ?>

                        <!-- Employment Form -->
                        <?php if ( $employment_form = get_field( 'employment_form' ) ): ?>
                            <div class="employment-form">
                                <?php if ( $job_title ): ?>
                                    <div class="employment-form__job-title">
                                        <h2>Apply for: <?php echo esc_html( $job_title ); ?></h2>
                                    </div>
                                <?php endif; ?>

                                <div class="employment-form__content">
                                    <?php echo do_shortcode( "[gravityform id='{$employment_form['id']}' title='false' description='false' ajax='true' field_values='job_title=" . urlencode($job_title) . "']" ); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php if ( $job_title ): ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Pre-fill job title field if it exists
            var jobTitle = '<?php echo esc_js( $job_title ); ?>';
            if (jobTitle) {
                // Try to find and fill job title field
                $('input[placeholder*="Position"], input[placeholder*="Job"], select option:contains("' + jobTitle + '")').each(function() {
                    if ($(this).is('select')) {
                        $(this).val(jobTitle);
                    } else {
                        $(this).val(jobTitle);
                    }
                });
            }
        });
    </script>
<?php endif; ?>

<?php get_footer(); ?>