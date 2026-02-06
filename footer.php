<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_guarapo
 */

?>
<section class="custom-footer py-4">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<?php dynamic_sidebar('footer_area_one'); ?>
			</div>
			<div class="col-sm-12 col-md-4">
				<?php dynamic_sidebar('footer_area_two'); ?>
			</div>
			<div class="footer col-sm-12">
				Copyright &copy; 2026 - <a href="https://guarapomedia.com" target="_blank" rel="noopener noreferrer"><img class="icon" src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/guarapo_logo.svg" alt="Guarapo Media" /></a>
			</div><!-- .site-info -->
		</div>
	</div>
</section>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
