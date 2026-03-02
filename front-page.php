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
						<p>I'm a system engineer with more than 5 years of experience as a Product Manager and more than 10 years as a web developer, taking on challenges that motivate me to develop new skills and knowledge.</p>
						<p>Currently at <u><a href="https://www.edreams.com" target="_blank" rel="noopener noreferrer">eDreams ODIGEO</a></u> working as PM in the checkout area, with incredible human capital that has made me grow. personally and professionally.</p>
						<p>Additionally, I have been running a digital agency called <u><a href="https://guarapomedia.com" target="_blank" rel="noopener noreferrer">Guarapo Media</a></u> since 2014 with two partners. From this project our most recent product <u><a href="https://wansite.co" target="_blank" rel="noopener noreferrer">wansite.co</a></u> was born, a web builder with which we help creators and artists to build microsites of their projects and services.</p>
						<p>Agile methodologies fascinated me and how they allow teams to generate a work dynamic that reduces 'time to market'.</p>
						<p>I'm constantly connected to the changes happening in the technology sector, but I am also an amateur runner so feel free to connect with me through <u><a href="https://www.strava.com/athletes/36809051" target="_blank" rel="noopener noreferrer">Strava</a></u>.</p>
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


		<!-- Corporate Blog Section -->
		<div class="container mt-5">
			<div class="row">
				<div class="py-3 col-lg-12">
					<h2>BLOG *</h2>
				</div>
				<div class="col-12">
					<div class="category-filters mb-4">
						<button class="button button-outline button-small filter-btn active" data-category="all">All</button>
						<?php
						$strava_cat = get_category_by_slug('strava-activities');
						$strava_cat_id = $strava_cat ? $strava_cat->term_id : 0;
						$run_cat = get_category_by_slug('run');
						$run_cat_id = $run_cat ? $run_cat->term_id : 0;
						$exclude_cats = array_filter(array($strava_cat_id, $run_cat_id));
						$categories = get_categories(array(
							'hide_empty' => true,
							'exclude' => $exclude_cats
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
			<div class="row" id="posts-container">
				<?php
				$blog_args = array(
					'posts_per_page' => 12,
					'category__not_in' => $exclude_cats
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
					<a class="button button-outline" href="/blog" rel="noopener noreferrer">Read more →</a>
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

</main><!-- #main -->

<?php
get_footer();
