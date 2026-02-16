<?php
/**
 * The blog posts page template
 *
 * WordPress uses home.php for the blog posts page (Settings > Reading > Posts page).
 * This takes priority over index.php for the blog listing.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

get_header();
?>

<main id="primary" class="container px-0 site-main">

	<?php if ( have_posts() ) : ?>
		<div class="main-heading"><a href="/">Walter Mazzariol</a></div>
		<header class="hero">
			<img class="hero-img" src="<?php echo get_template_directory_uri() . '/dist/assets/images/hero.jpg'; ?>" alt="background"/>
			<div class="hero-wrapper d-flex flex-column justify-content-end align-items-start">
				<h1 class="hero-title">Blog*</h1>
			</div>
		</header>

		<div class="container mt-5">
			<div class="row justify-content-start">
				<div class="col-lg-12 col-12">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'blog' );
					endwhile;
					?>
				</div>
			</div>
		</div>

		<?php
		the_posts_pagination( array(
			'prev_text' => '<span>Anterior</span>',
			'next_text' => '<span>Siguiente</span>',
		) );

	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
</main><!-- #main -->

<?php
get_footer();
