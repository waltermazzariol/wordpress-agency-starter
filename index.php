<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

get_header();
?>

<main id="primary" class="container px-0 site-main">

	<?php if ( have_posts() ) :	
		if ( is_home() && ! is_front_page() ) :
				?>
	<header class="entry-header cover-page mt-5">
		<h1 class="entry-title"><?php single_post_title(); ?></h1>
	</header><!-- .entry-header -->
	
	<?php endif; ?>
	<div class="container mt-5">
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
			?> 
		</div>
	</div> 
		<?php
		 the_posts_pagination(array(
			'prev_text' => '<span>Anterior</span>',
			'next_text' => '<span>Siguiente</span>'
		  )); 
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
</main><!-- #main -->

<?php
get_footer();