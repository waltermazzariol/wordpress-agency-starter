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
			<div class="col-sm-12 col-md-4">
				<h2>WHERE CAN YOU FIND ME?</h2>
				<p>Gràcia, Barcelona 08024</p>
				<span class="social-contact">
					<a class="social-contact-item" href="https://instagram.com/waltermazzariol" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram" aria-label="icon"></i></a>
					<a class="social-contact-item" href="https://x.com/waltermazzariol" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-x-twitter" aria-label="icon"></i></a>
					<a class="social-contact-item" href="https://dribbble.com/waltermazzariol" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-dribbble" aria-label="icon"></i></a>
					<a class="social-contact-item" href="mazzariolwalter@gmail.com" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-envelope" aria-label="icon"></i></a>
					<a class="social-contact-item" href="https://www.strava.com/athletes/36809051" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-strava" aria-label="icon"></i></a>
				</span>
			</div>
			<div class="col-sm-12 col-md-4">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/map.png" alt="mapa" />
			</div>
			<div class="col-sm-12 col-md-4">
				<h2>SUBSCRIBE</h2>
				<?php dynamic_sidebar('footer_area_one'); ?>
			</div>
		</div>
	</div>
</section>
