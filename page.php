<?php
/**
 * Page
 */
get_header(); ?>

<main class="main-content">
	<div class="container">
		<div class="row">
			<!-- BEGIN of page content -->
			<div class="col-lg-8 col-md-8 col-sm-12 col-12">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<article <?php post_class( 'entry' ); ?>>
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
			
			<!-- BEGIN of sidebar -->
			<div class="col-lg-4 col-md-4 col-sm-12 col-12 sidebar">
				<?php get_sidebar( 'right' ); ?>
			</div>
			<!-- END of sidebar -->
		</div>
	</div>
</main>

<?php get_footer(); ?>
