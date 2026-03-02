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
        <div class="main-heading"><a href="/">Walter Mazzariol</a></div>
        <header class="hero">
            <img class="hero-img" src="<?php echo esc_url(get_template_directory_uri() . '/dist/assets/images/hero.jpg'); ?>" alt="Barcelona cityscape background" width="1920" height="1080" />
            <div class="hero-wrapper-big d-flex flex-column justify-content-end align-items-start" >
                <h1 class="hero-title">PRODUCT MANAGER <br/>BASED IN
                <br/>BARCELONA*
                </h1>
                <span class="hero-subtitle">©2026</span>
        </header><!-- .entry-header -->

		<div id="about" class="about container mt-5">
			<div class="row">
				<div class="col-lg-5 col-md-12">
					<div class="py-3 col-lg-12">
						<h2>* about <br>me and how <br>i work</h2>
					</div>
				</div>
				<div class="col-lg-7 col-md-12">
					<div class="mb-4">
					<p>I'm Walter; a venezuelan PM living in Barcelona. I've spent the last decade building things on the internet, first as a developer, now leading product at eDreams. This is where I write about that work, about running long distances, and about figuring things out as I go.</p>
					<p>Writing helps me think. If something here is useful or resonates with you, even better.</p>
					<p>No polish, just honest notes from the process. Start with the blog, or say hi.</p>
					</div>
				</div>
    		</div>
		</div>

		<div id="gallery" class="container">
			<div class="row">
				<div class="py-3 col-lg-12">
					<h2>Photo Journal *</h2>
				</div>
			</div>
		</div>

		<div class="gallery container-fluid">
			<div class="row g-0">
				<?php
				$gallery_path = get_template_directory() . '/dist/assets/images/gallery/';
				$gallery_url = get_template_directory_uri() . '/dist/assets/images/gallery/';
				$images = glob($gallery_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

				if ($images) {
					shuffle($images);
					$random_images = array_slice($images, 0, 4);

					foreach ($random_images as $image) :
						$filename = basename($image);
				?>
					<div class="col-6 col-md-3 g-0">
						<img src="<?php echo esc_url($gallery_url . $filename); ?>" alt="Barcelona gallery image" loading="lazy" class="gallery-img" />
					</div>
				<?php
					endforeach;
				}
				?>
			</div>
		</div>

		<!-- Gallery Lightbox -->
		<div id="gallery-lightbox" class="lightbox">
			<button class="lightbox-close" aria-label="Close lightbox">&times;</button>
			<figure class="lightbox-content">
				<img class="lightbox-img" src="" alt="Gallery image full size" />
				<figcaption class="lightbox-caption">
					<a href="https://instagram.com/waltermazzariol" target="_blank" rel="noopener noreferrer">@waltermazzariol</a>
				</figcaption>
			</figure>
		</div>


		<!-- Product Management Blog Section  -->
		<div class="container mt-5">
			<div class="row">
				<div class="py-3 col-lg-12">
					<h2>BLOG *</h2>
				</div>
			</div>
			<div class="row">
				<?php
				$blog_args = array(
					'posts_per_page' => 6,
					'category_name' => 'product-management'
				);
				$blog_posts = new WP_Query($blog_args);

				if ($blog_posts->have_posts()) :
					while ($blog_posts->have_posts()) :
						$blog_posts->the_post();
						get_template_part('template-parts/content', 'loop');
					endwhile;
				endif;
				wp_reset_postdata();
				?>
			</div>
			<div class="row justify-content-center my-5">
				<span class="col-4 text-center">
					<a class="button button-outline" href="/category/product-management/" rel="noopener noreferrer">Read more →</a>
				</span>
			</div>
		</div>


		<!-- Run Blog Section (Strava Activities) -->
		<div class="container mt-5">
			<div class="row">
				<div class="py-3 col-lg-12">
					<h2>RUN BLOG *</h2>
				</div>
			</div>
			<div class="row">
				<?php
				$strava_args = array(
					'posts_per_page' => 3,
					'category_name' => 'strava-activities'
				);
				$strava_posts = new WP_Query($strava_args);

				if ($strava_posts->have_posts()) :
					while ($strava_posts->have_posts()) :
						$strava_posts->the_post();
						set_query_var('box_style', 'square');
						get_template_part('template-parts/content', 'loop');
					endwhile;
				endif;
				wp_reset_postdata();
				?>
			</div>
			<div class="row justify-content-center my-5">
				<span class="col-4 text-center">
					<a class="button button-outline" href="/category/strava-activities/run/" rel="noopener noreferrer">Read more →</a>
				</span>
			</div>
		</div>

		<!-- Journal Blog Section (Notes) -->
		<div class="container mt-5">
			<div class="row">
				<div class="py-3 col-lg-12">
					<h2>NOTES *</h2>
				</div>
			</div>
			<div class="row">
				<?php
				$notes_args = array(
					'posts_per_page' => 3,
					'category_name' => 'notes'
				);
				$notes_posts = new WP_Query($notes_args);

				if ($notes_posts->have_posts()) :
					while ($notes_posts->have_posts()) :
						$notes_posts->the_post();
						get_template_part('template-parts/content', 'loop');
					endwhile;
				endif;
				wp_reset_postdata();
				?>
			</div>
			<div class="row justify-content-center my-5">
				<span class="col-4 text-center">
					<a class="button button-outline" href="/category/notes/" rel="noopener noreferrer">Read more →</a>
				</span>
			</div>
		</div>

</main><!-- #main -->

<?php
get_footer();
