<?php
/**
 * Template Name: Full Width
 */
get_header(); ?>

<?php if (!is_front_page() && !is_home()): ?>
    <?php show_template('hero-banner', array('title' => get_the_title(), 'image' => get_post_thumbnail_id())); ?>
<?php endif; ?>

	<main class="main-content">
		<div class="container">
			<div class="row">
				<!-- BEGIN of page content -->
				<div class="col-12">
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<article <?php post_class('entry'); ?>>
								<h1 class="page-title entry__title"><?php the_title(); ?></h1>
								<?php if ( has_post_thumbnail() ) : ?>
									<div title="<?php the_title_attribute(); ?>" class="entry__thumb">
										<?php the_post_thumbnail( 'large' ); ?>
									</div>
								<?php endif; ?>
								<div class="entry__content">
									<?php the_content( '', true ); ?>
								</div>
							</article>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<!-- END of page content -->
			</div>
		</div>
	</main>

<?php get_footer(); ?>
