<?php
/**
 * Category
 *
 * Standard loop for the category page
 */
get_header(); ?>
<main class="main-content">
	<div class="container">
		<div class="row posts-list">
			<div class="col-12 col-sm-12">
				<h2 class="page-title page-title--category"><?php echo get_the_archive_title(); ?></h2>
			</div>
			<!-- BEGIN Category Content -->
			<div class="col-lg-8 col-md-8 col-sm-12 col-12">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?><!-- BEGIN of Post -->
						<?php get_template_part( 'parts/loop', 'post' ); // Post item ?>
					<?php endwhile; ?>
				<?php endif; ?>
				<!-- BEGIN of pagination -->
				<?php bootstrap_pagination(); ?>
				<!-- END of pagination -->
			</div>
			<!-- END Category Content -->
			<!-- BEGIN of Sidebar -->
			<div class="col-lg-4 col-md-4 col-sm-12 col-12 sidebar">
				<?php get_sidebar( 'right' ); ?>
			</div>
			<!-- END of Sidebar -->
		</div>
	</div>
</main>
<?php get_footer(); ?>
