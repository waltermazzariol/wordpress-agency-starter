<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

get_header();
?>

<main id="primary" class="container site-main">
<div class="main-heading"><a href="/">Walter Mazzariol</a></div>
	<header class="hero">
	<?php
	$hero_image = '/dist/assets/images/hero.jpg';
	if ( is_category( 'run' ) ) {
		$hero_image = '/dist/assets/images/run.jpg';
		set_query_var( 'box_style', 'square' );
	}
	?>
	<img class="hero-img" src="<?php echo get_template_directory_uri() . $hero_image; ?>" alt="background"/>
	<div class="hero-wrapper d-flex flex-column justify-content-end align-items-start" >
		<h1 class="hero-title"><?php the_archive_title(); ?></h1>
	</div>
	</header><!-- .entry-header -->
	<?php if ( have_posts() ) : ?>
	<div class="container py-5">
		<div class="row">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'loop' );

			endwhile;

			 the_posts_pagination(array(

				'prev_text' => '<span>Anterior</span>',
				'next_text' => '<span>Siguiente</span>'
			  
			  )); 
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();