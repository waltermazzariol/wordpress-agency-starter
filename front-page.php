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
            <img class="hero-img" src="<?php echo get_template_directory_uri() . '/dist/assets/images/hero.jpg'?>" alt="background"/>
            <div class="hero-wrapper-big d-flex flex-column justify-content-end align-items-start" >
                <h1 class="hero-title">PRODUCT MANAGER <br/>BASED IN
                <br/>BARCELONA*
                </h1>
                <span class="hero-subtitle">©2024</span>
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
						<p>Agile methodologies fascinated me and how they allow teams to generate a work dynamic that reduces 'time to market’.</p>
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
				<div class="col-xs-6 col-md-3 g-0" alt= >
					<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/gallery/1.jpg'?>" alt="" />
				</div>
				<div class="col-xs-6 col-md-3 g-0" alt= >
					<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/gallery/2.jpg'?>" alt="" />
				</div>
				<div class="col-xs-6 col-md-3 g-0" alt= >
					<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/gallery/3.jpg'?>" alt="" />
				</div>
				<div class="col-xs-6 col-md-3 g-0" alt= >
					<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/gallery/4.jpg'?>" alt="" />
				</div>
			</div>
		</div>

	
		<div class="container mt-5">
			<div class="row">
			<div class="py-3 col-lg-12">
				<h2>BLOG *</h2>
			</div>
				<?php $args_2 = array(
						'posts_per_page' => 3					
						);
						
						$arr_posts = new WP_Query( $args_2 );
						if ( $arr_posts->have_posts() ) :
	
							while ( $arr_posts->have_posts() ) :
								$arr_posts->the_post();
								get_template_part( 'template-parts/content', 'loop' );

							endwhile;
						endif;
						/* Restore original Post Data */
						wp_reset_postdata();
						?>
			</div>
			<div class="row justify-content-center my-5">
				<span class="col-4 text-center">
					<a class="button button-outline" href="/blog" rel="noopener noreferrer">Read more →</a>
				</span>
			</div>
		</div> 

		<div id="portfolio" class="grid-row container">
			<div class="row">
				<div class="py-3 col-lg-12">
					<h2>Portfolio *</h2>
					<p>Helping each client to achieve their goal<br/>through digital
						products is what drives me <br/>to work and go for it. </p>
				</div>
				<div class="col-sm-4 portfolio">
					<div class="col-12" >
						<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/portfolio/7.jpg'?>" alt="" />
					</div>
					<h3 class="portfolio-box-title">
						<a class="portfolio-box" href="https://laescuelacfc.com" target="_blank" rel="noopener noreferrer">
							La Escuela
						</a>
					</h3>
					<div className="portfolio-box-subtitle">
						<a className="portfolio-box" href="https://laescuelacfc.com" target="_blank" rel="noopener noreferrer">
							<div className="mb-2">Centro de Formación</div>
						</a>
					</div>
				</div>
				<div class="col-sm-4 portfolio">
					<div class="col-12" >
						<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/portfolio/1.jpg'?>" alt="" />
					</div>
					<h3 class="portfolio-box-title">
						<a class="portfolio-box" href="https://wansite.co" target="_blank" rel="noopener noreferrer">
							Wansite.co
						</a>
					</h3>
					<div className="portfolio-box-subtitle">
						<a className="portfolio-box" href="https://wansite.co" target="_blank" rel="noopener noreferrer">
							<div className="mb-2">Create your microsite fast and easy</div>
						</a>
					</div>
				</div>
				<div class="col-sm-4 portfolio">
					<div class="col-12" >
						<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/portfolio/2.jpg'?>" alt="" />
					</div>
					<h3 class="portfolio-box-title">
						<a class="portfolio-box" href="https://guarapomedia.com" target="_blank" rel="noopener noreferrer">
							Guarapo Media
						</a>
					</h3>
					<div className="portfolio-box-subtitle">
						<a className="portfolio-box" href="https://guarapomedia.com" target="_blank" rel="noopener noreferrer">
							<div className="mb-2">Digital Agency</div>
						</a>
					</div>
				</div>
				<div class="col-sm-4 portfolio">
					<div class="col-12" >
						<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/portfolio/3.jpg'?>" alt="" />
					</div>
					<h3 class="portfolio-box-title">
						<a class="portfolio-box" href="https://guatacanights.com" target="_blank" rel="noopener noreferrer">
							Guataca Nights
						</a>
					</h3>
					<div className="portfolio-box-subtitle">
						<a className="portfolio-box" href="https://guatacanights.com" target="_blank" rel="noopener noreferrer">
							<div className="mb-2">Musical platform for emergin musicians</div>
						</a>
					</div>
				</div>
				<div class="col-sm-4 portfolio">
					<div class="col-12" >
						<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/portfolio/4.jpg'?>" alt="" />
					</div>
					<h3 class="portfolio-box-title">
						<a class="portfolio-box" href="https://barquitodepapel.es/" target="_blank" rel="noopener noreferrer">
							Barquito de papel
						</a>
					</h3>
					<div className="portfolio-box-subtitle">
						<a className="portfolio-box" href="https://barquitodepapel.es/" target="_blank" rel="noopener noreferrer">
							<div className="mb-2">Children's school</div>
						</a>
					</div>
				</div>
				<div class="col-sm-4 portfolio">
					<div class="col-12" >
						<img src="<?php echo get_template_directory_uri() . '/dist/assets/data/images/portfolio/6.jpg'?>" alt="" />
					</div>
					<h3 class="portfolio-box-title">
						<a class="portfolio-box" href="https://pieldeoro.com" target="_blank" rel="noopener noreferrer">
							Piel de oro
						</a>
					</h3>
					<div className="portfolio-box-subtitle">
						<a className="portfolio-box" href="https://pieldeoro.com" target="_blank" rel="noopener noreferrer">
							<div className="mb-2">Fast and safe spray tan</div>
						</a>
					</div>
				</div>
			</div>
			<div class="row justify-content-center my-5">
				<span class="col-4 text-center">
					<a class="button button-outline" href="https://twitter.com/messages/compose?recipient_id=2344175338" target="_blank" rel="noopener noreferrer">Get in touch →</a>
				</span>
			</div>
		</div>
		
</main><!-- #main -->

<?php
get_footer();