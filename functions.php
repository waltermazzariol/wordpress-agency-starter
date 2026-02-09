<?php

/**
 * wp_guarapo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp_guarapo
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('wp_guarapo_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wp_guarapo_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wp_guarapo, use a find and replace
		 * to change 'wp_guarapo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('wp_guarapo', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'wp_guarapo'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'wp_guarapo_custom_background_args',
				array(
					'default-color' => 'FDFDFD',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'wp_guarapo_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_guarapo_content_width()
{
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('wp_guarapo_content_width', 640);
}
add_action('after_setup_theme', 'wp_guarapo_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_guarapo_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Footer 1', 'wp_guarapo'),
			'id'            => 'footer_area_one',
			'description'   => esc_html__('Add widgets here.', 'wp_guarapo'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__('Footer 2', 'wp_guarapo'),
			'id'            => 'footer_area_two',
			'description'   => esc_html__('Add widgets here.', 'wp_guarapo'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__('Header 1', 'wp_guarapo'),
			'id'            => 'header_area_icons',
			'description'   => esc_html__('Add widgets here.', 'wp_guarapo'),
			'before_widget' => '<span id="%1$s" class="text-gray d-flex justify-content-end">',
			'after_widget'  => '</span>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action('widgets_init', 'wp_guarapo_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function wp_guarapo_scripts()
{
	wp_enqueue_style('wp_guarapo-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('wp_guarapo-style', 'rtl', 'replace');

	// Load jQuery in the header (false = not in footer) for inline scripts
	wp_enqueue_script('jquery');
	wp_scripts()->add_data('jquery', 'group', 0);
	wp_scripts()->add_data('jquery-core', 'group', 0);
	wp_scripts()->add_data('jquery-migrate', 'group', 0);

	wp_enqueue_script('wp_guarapo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'wp_guarapo_scripts');


/**
 * Enqueue scripts and styles from dist.
 */
function _themename_assets()
{
	$css_file = get_template_directory() . '/dist/css/bundle.css';
	$js_file = get_template_directory() . '/dist/js/bundle.js';

	$css_ver = file_exists($css_file) ? filemtime($css_file) : '1.0.0';
	$js_ver = file_exists($js_file) ? filemtime($js_file) : '1.0.0';

	wp_enqueue_style('_themename-stylesheet', get_template_directory_uri() . '/dist/css/bundle.css', array(), $css_ver, 'all');

	wp_enqueue_script('_themename-scripts', get_template_directory_uri() . '/dist/js/bundle.js', array(), $js_ver, true);
}
add_action('wp_enqueue_scripts', '_themename_assets');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

/**
 * Remove navbar
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Implement the Custom Header feature.
 * require get_template_directory() . '/inc/custom-header.php';
*/

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Incluir Bootstrap JS (bundle includes Popper)
function bootstrap_js() {
	wp_enqueue_script( 'bootstrap_js',
  					'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
  					array(),
  					'5.3.2',
  					true);
}
add_action( 'wp_enqueue_scripts', 'bootstrap_js', 20 );


// Allow SVG
function add_file_types_to_uploads($file_types)
{
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes);
	return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

/**
 * Add animaate support
 */

function add_animate_css()
{
	wp_enqueue_style('animate', get_template_directory_uri() . '/dist/assets/vendor/animate.css');

}
add_action('wp_enqueue_scripts', 'add_animate_css');

/** 
 * Delete Category word when printing category page
*/
function my_theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }
  
    return $title;
}

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );


/**
 * Add font awesome support
 */

add_action('wp_enqueue_scripts', 'tthq_add_custom_fa_css');

function tthq_add_custom_fa_css()
{
	wp_enqueue_style('custom-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
}

/**
 * Add Accent color to customize
 */
  function theme_customize_register( $wp_customize ) {    
    // Accent color
    $wp_customize->add_setting( 'accent_color', array(
      'default'   => '22577A',
      'transport' => 'refresh',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );

	$wp_customize->add_setting( 'footer_color', array(
		'default'   => 'DDDDDD',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	  ) );

	$wp_customize->add_setting( 'footer_text_color', array(
		'default'   => '000000',
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	  ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
      'section' => 'colors',
      'label'   => esc_html__( 'Accent color', 'theme' ),
    ) ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Footer color', 'theme' ),
	  ) ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Footer text color', 'theme' ),
	  ) ) );
  }

  add_action( 'customize_register', 'theme_customize_register' );

  function theme_get_customizer_css() {
    ob_start();

    $accent_color = get_theme_mod( 'accent_color', '' );
    if ( ! empty( $accent_color ) ) {
      ?>
	  	a:hover{
			color: <?php echo esc_attr($accent_color); ?>;
			text-decoration: underline;
		}
		.bg-primary{
			background-color: <?php echo esc_attr($accent_color); ?>!important;
		}
		.pagination .page-numbers{
				background-color: <?php echo esc_attr($accent_color); ?>;
		}
	
      <?php
    }

	$footer_color = get_theme_mod( 'footer_color', '' );
	$footer_text_color = get_theme_mod( 'footer_text_color', '' );

    if ( ! empty( $footer_color ) ) {
      ?>
	  	.footer{
			background-color: <?php echo esc_attr($footer_color); ?>;
			color: <?php echo esc_attr($footer_text_color); ?>;
		}
		.widget h4{
			color: <?php echo esc_attr($footer_text_color); ?>;
		}
      <?php
    }

    $css = ob_get_clean();
    return $css;
  }

/* 
* Add Leer más button
*/

  function theme_enqueue_styles() {
	wp_enqueue_style( 'theme-styles', get_stylesheet_uri() ); // This is where you enqueue your theme's main stylesheet
	$custom_css = theme_get_customizer_css();
	wp_add_inline_style( 'theme-styles', $custom_css );
  }
  
  add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

  function custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function wpdocs_excerpt_more( $more ) {
    if ( ! is_single() ) {
        $more = sprintf( '<a class="read-more d-block" href="%1$s">%2$s</a>',
            esc_url( get_permalink( get_the_ID() ) ),
            __( 'Leer más', 'textdomain' )
        );
    }

    return $more;
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * Fantastic social media share buttons by www.jonakyblog.com
 */
function my_share_buttons() {
    $url = urlencode(get_the_permalink()); /* Getting the current post link */
    $title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')); /* Get the post title */
    $media = urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full')); /* Get the current post image thumbnail */

    include( locate_template('share-buttons-template.php', false, false) );
}

// Get first image of the post
function catch_that_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
	$first_img = (isset($matches[1][0]) ? $matches[1][0] :"");
  
	if(empty($first_img)) {
	  $first_img = get_template_directory_uri() . '/dist/assets/images/default_image.jpeg';
	}
	return $first_img;
  }

  //estimated reading time
function reading_time() {
	global $post;
	$content = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	$readingtime = ceil($word_count / 200);
	
	if ($readingtime == 1) {
	$timer = " min";
	} else {
	$timer = " min";
	}
	$totalreadingtime = $readingtime . $timer;
	
	return $totalreadingtime;
	}

/**
 * AJAX handler for category filtering on front page (excludes strava-activities)
 */
function wp_guarapo_filter_posts_by_category() {
	$category_id = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
	$strava_cat = get_category_by_slug('strava-activities');
	$strava_cat_id = $strava_cat ? $strava_cat->term_id : 0;
	$run_cat = get_category_by_slug('run');
	$run_cat_id = $run_cat ? $run_cat->term_id : 0;
	$exclude_cats = array_filter(array($strava_cat_id, $run_cat_id));

	$args = array(
		'posts_per_page' => 12,
		'post_status' => 'publish',
		'category__not_in' => $exclude_cats,
	);

	if ($category_id !== 'all' && is_numeric($category_id)) {
		$args['cat'] = intval($category_id);
		unset($args['category__not_in']);
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) :
		while ($query->have_posts()) :
			$query->the_post();
			get_template_part('template-parts/content', 'loop');
		endwhile;
	else :
		echo '<div class="col-12"><p>No posts found in this category.</p></div>';
	endif;

	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_filter_posts_by_category', 'wp_guarapo_filter_posts_by_category');
add_action('wp_ajax_nopriv_filter_posts_by_category', 'wp_guarapo_filter_posts_by_category');

// recent posts shortcode
function guarapo_recent_posts_shortcode($atts, $content = null) {

	global $post;

	$atts = shortcode_atts(array(
		'cat'     => '',
		'num'     => '6',
		'order'   => 'DESC',
		'orderby' => 'post_date',
		'square'  => 'false',
		'metadata'=> 'true',
		'col'     => '3'
	), $atts, 'recent_posts');

	$cat      = $atts['cat'];
	$num      = $atts['num'];
	$order    = $atts['order'];
	$orderby  = $atts['orderby'];
	$square   = $atts['square'];
	$metadata = $atts['metadata'];
	$col      = $atts['col'];

	$args = array(
		'cat'            => $cat,
		'posts_per_page' => $num,
		'order'          => $order,
		'orderby'        => $orderby,
		'square'         => $square,
		'metadata'       => $metadata,
		'col'            => $col
	);
	
	$output = '';
	
	$posts = get_posts($args);
	
	foreach($posts as $post) {
		
		setup_postdata($post);
		$date_post = get_the_date();
		$author_post = get_the_author();
		$feature_post = ((get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() :  catch_that_image());
		$feature_aspect = (($square == "true") ? "-square" : "");
		$meta = (($metadata == "true") ? '<div class="entry-meta mb-2 small">
					<span class="byline">' . $author_post. '</span>
		 			<span class="posted-on">' . $date_post . '</span>
					<span class="reading-time">' . reading_time() . '</span>
				</div>' : "");
		$output .='<article class="col-md-'.$col.' mb-3" id="post">
						<div class="card-loop">
							<div class="box-loop' . $feature_aspect . '">
								<a href="'. esc_url(get_the_permalink()).'" class="box-loop-image">
								<img class="box-loop-image"
								src="' . esc_url($feature_post) . '" alt="'.esc_attr(get_the_title()).'" />
								</a>
							 </div>
							 <header class="entry-header">
							 	<h3 class="entry-title">
							 		<a href="' . esc_url(get_the_permalink()).'" rel="bookmark">'. esc_html(get_the_title()). '</a>
								</h3>'. $meta .'
							</header>
						</div>
					</article>';	
	}
	
	wp_reset_postdata();
	
	return '<div class="row">
						'. $output . '

				<div class="d-flex justify-content-center">
					<a class="btn-basic" href="' . esc_url(get_category_link( $cat )) . '">Ver más</a>
				</div>
			</div>';
	
}
add_shortcode('recent_posts', 'guarapo_recent_posts_shortcode');

// Responsive for youtube video
add_theme_support( 'responsive-embeds' );

// Create Shortcode related_posts_
// Shortcode: [related_posts_ number="5"]
function create_relatedposts_shortcode() {

	

	// Custom WP query relatedposts
	$args_relatedposts = array(
		'posts_per_page' => '3',
		'order' => 'DESC',
	);

	$relatedposts = new WP_Query( $args_relatedposts );

	if ( $relatedposts->have_posts() ) {
		echo '<div class="container mt-5"><div class="row"><hr><h3 class="mt-5 mb-4">Artículos Relacionados</h3>';
		while ( $relatedposts->have_posts() ) {
			$relatedposts->the_post();
			get_template_part( 'template-parts/content', 'loop' );
		}
		echo '</div></div>';
	} else {
		// not found post 
	}

	wp_reset_postdata();

}
