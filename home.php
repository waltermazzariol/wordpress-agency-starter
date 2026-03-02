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
			<div class="row">
				<div class="col-12">
					<div class="category-filters mb-4">
						<button class="button button-outline button-small filter-btn active" data-category="all">All</button>
						<?php
						$strava_cat = get_category_by_slug('strava-activities');
						$strava_cat_id = $strava_cat ? $strava_cat->term_id : 0;
						$categories = get_categories(array(
							'hide_empty' => true,
							'exclude' => $strava_cat_id ? array($strava_cat_id) : array(),
						));
						foreach ($categories as $category) :
						?>
							<button class="button button-outline button-small filter-btn" data-category="<?php echo esc_attr($category->term_id); ?>">
								<?php echo esc_html($category->name); ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="row justify-content-start">
				<div class="col-lg-12 col-12" id="blog-posts-container">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'blog' );
					endwhile;
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-12" id="blog-pagination">
					<?php the_posts_pagination( array(
						'mid_size'  => 2,
						'prev_text' => '&laquo; Prev',
						'next_text' => 'Next &raquo;',
					) ); ?>
				</div>
			</div>
		</div>

	<?php
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
</main><!-- #main -->

<?php
get_footer();
