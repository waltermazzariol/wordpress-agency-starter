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
        <div class="main-heading typewriter"><a href="/">Walter Mazzariol</a></div>
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
					<h2>Barcelona vibes *</h2>
				</div>
			</div>
		</div>

		<div class="gallery container-fluid">
			<div class="row g-0">
				<div class="col-xs-6 col-md-3 g-0">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/dist/assets/data/images/gallery/1.jpg'); ?>" alt="Barcelona street scene with architecture" loading="lazy" />
				</div>
				<div class="col-xs-6 col-md-3 g-0">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/dist/assets/data/images/gallery/2.jpg'); ?>" alt="Barcelona coastal view"  loading="lazy" />
				</div>
				<div class="col-xs-6 col-md-3 g-0">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/dist/assets/data/images/gallery/3.jpg'); ?>" alt="Barcelona urban landscape" loading="lazy" />
				</div>
				<div class="col-xs-6 col-md-3 g-0">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/dist/assets/data/images/gallery/4.jpg'); ?>" alt="Barcelona city life" loading="lazy" />
				</div>
			</div>
		</div>


		<div class="container mt-5">
			<div class="row">
			<div class="py-3 col-lg-12">
				<h2>BLOG *</h2>
			</div>
				<?php
				$cache_key = 'wp_guarapo_frontpage_posts';
				$cache_active = false; 
				$cached_query = $cache_active ? get_transient($cache_key) : false;
				
				if (false === $cached_query) {
					$args_2 = array(
						'posts_per_page' => 12
					);
					$arr_posts = new WP_Query($args_2);
					if ($cache_active) {
						set_transient($cache_key, $arr_posts, HOUR_IN_SECONDS);
					}
				} else {
					$arr_posts = $cached_query;
				}

				if ($arr_posts->have_posts()) :
					while ($arr_posts->have_posts()) :
						$arr_posts->the_post();
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

		

</main><!-- #main -->

<?php
get_footer();
