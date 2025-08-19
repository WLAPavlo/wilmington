<?php
/**
 * Footer
 */
?>

<!-- BEGIN of footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-3">
				<div class="footer__logo">
					<?php if ( $footer_logo = get_field( 'footer_logo', 'options' ) ):
						echo wp_get_attachment_image( $footer_logo['id'], 'medium' );
					else:
						show_custom_logo();
					endif; ?>
				</div>
			</div>
			<div class="col-lg-6 col-12">
				<?php
				if ( has_nav_menu( 'footer-menu' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'footer-menu', 'depth' => 1 ) );
				}
				?>
			</div>
			<div class="col-12 col-lg-3">
				<?php get_template_part('parts/socials'); // Social profiles ?>
			</div>
		</div>
	</div>

	<?php if ( $copyright = get_field( 'copyright', 'options' ) ): ?>
		<div class="footer__copy">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php echo $copyright; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</footer>
<!-- END of footer -->

<button id="back-to-top"><span class="arrow"></span></button>

<?php wp_footer(); ?>
<?php if ( $ada_script = get_field( 'ada', 'options' ) ) : ?>
    <?php echo $ada_script; ?>
<?php endif; ?>
</body>
</html>
