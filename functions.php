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
	define('_S_VERSION', '1.0.5');
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
	// Move jQuery to footer (inline scripts are now external files)
	wp_enqueue_script('jquery');
	wp_scripts()->add_data('jquery', 'group', 1);
	wp_scripts()->add_data('jquery-core', 'group', 1);
	wp_scripts()->add_data('jquery-migrate', 'group', 1);

	wp_enqueue_script('wp_guarapo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script(
			'wp-guarapo-comments',
			get_template_directory_uri() . '/dist/js/comments.js',
			array( 'jquery' ),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
}
add_action('wp_enqueue_scripts', 'wp_guarapo_scripts');

// Remove Website field from comment form; keep Name + Email + Comment
add_filter( 'comment_form_default_fields', function( $fields ) {
	unset( $fields['url'] );
	return $fields;
} );

// Auto-fill author as "Anonymous" when the name field is omitted
add_filter( 'preprocess_comment', function( $commentdata ) {
	if ( empty( $commentdata['comment_author'] ) ) {
		$commentdata['comment_author'] = 'Anonymous';
	}
	return $commentdata;
} );

/**
 * Add defer attribute to jQuery and all scripts that depend on it.
 * Defer preserves execution order, so jQuery will run before its dependents.
 */
function wp_guarapo_defer_scripts( $tag, $handle ) {
	$defer_handles = array(
		'jquery-core',
		'jquery-migrate',
		'wp-guarapo-front-page',
		'wp-guarapo-blog-filter',
		'wp-guarapo-comments',
	);
	if ( in_array( $handle, $defer_handles, true ) && strpos( $tag, ' defer' ) === false ) {
		return str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'wp_guarapo_defer_scripts', 10, 2 );

/**
 * Convert non-critical CSS to async loading via preload + onload pattern.
 */
function wp_guarapo_async_styles( $html, $handle ) {
	$async_handles = array( 'animate', 'custom-fa', 'wp-block-library', 'contact-form-7' );
	if ( in_array( $handle, $async_handles, true ) && ! is_admin() ) {
		$html = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html );
		$html .= '<noscript>' . str_replace( array( "rel='preload'", " as='style'", " onload=\"this.onload=null;this.rel='stylesheet'\"" ), array( "rel='stylesheet'", '', '' ), $html ) . '</noscript>';
	}
	return $html;
}
add_filter( 'style_loader_tag', 'wp_guarapo_async_styles', 10, 2 );

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

/**
 * Enqueue page-specific scripts with localized AJAX URL.
 */
function wp_guarapo_page_scripts() {
	if ( is_front_page() ) {
		$file = get_template_directory() . '/dist/js/front-page.js';
		$ver = file_exists( $file ) ? filemtime( $file ) : _S_VERSION;
		wp_enqueue_script( 'wp-guarapo-front-page', get_template_directory_uri() . '/dist/js/front-page.js', array( 'jquery' ), $ver, true );
		wp_localize_script( 'wp-guarapo-front-page', 'wpGuarapoAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	if ( is_home() ) {
		$file = get_template_directory() . '/dist/js/blog-filter.js';
		$ver = file_exists( $file ) ? filemtime( $file ) : _S_VERSION;
		wp_enqueue_script( 'wp-guarapo-blog-filter', get_template_directory_uri() . '/dist/js/blog-filter.js', array( 'jquery' ), $ver, true );
		wp_localize_script( 'wp-guarapo-blog-filter', 'wpGuarapoAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	if ( is_single() ) {
		$file = get_template_directory() . '/dist/js/instagram-share.js';
		$ver  = file_exists( $file ) ? filemtime( $file ) : _S_VERSION;
		wp_enqueue_script( 'wp-guarapo-instagram-share', get_template_directory_uri() . '/dist/js/instagram-share.js', array(), $ver, true );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_guarapo_page_scripts' );

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

/**
 * Add customizer inline styles to main stylesheet
 */
function theme_enqueue_customizer_styles() {
	$custom_css = theme_get_customizer_css();
	wp_add_inline_style( '_themename-stylesheet', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_customizer_styles' );

  function custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function wpdocs_excerpt_more( $more ) {
    if ( ! is_single() ) {
        $more = sprintf( '<a class="read-more d-block" href="%1$s">%2$s</a>',
            esc_url( get_permalink( get_the_ID() ) ),
            __( 'Read more', 'textdomain' )
        );
    }

    return $more;
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * Social media share buttons
 */
function my_share_buttons() {
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

/**
 * Estimated reading time
 */
function reading_time() {
	global $post;
	$content = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	$readingtime = ceil($word_count / 200);

	return $readingtime . ' min';
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

/**
 * AJAX handler for category filtering on blog page (classic layout)
 */
function wp_guarapo_filter_blog_posts() {
	$category_id    = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
	$paged          = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
	$posts_per_page = get_option('posts_per_page', 10);
	$strava_cat     = get_category_by_slug('strava-activities');
	$strava_cat_id  = $strava_cat ? $strava_cat->term_id : 0;

	$args = array(
		'posts_per_page' => $posts_per_page,
		'paged'          => $paged,
		'post_status'    => 'publish',
	);

	if ($category_id !== 'all' && is_numeric($category_id)) {
		$args['cat'] = intval($category_id);
	} // else: no category filter, show all posts

	$query = new WP_Query($args);

	ob_start();
	if ($query->have_posts()) :
		while ($query->have_posts()) :
			$query->the_post();
			get_template_part('template-parts/content', 'blog');
		endwhile;
	else :
		echo '<p>No posts found in this category.</p>';
	endif;
	$posts_html = ob_get_clean();

	$links = paginate_links( array(
		'base'      => '%_%',
		'format'    => '?paged=%#%',
		'current'   => $paged,
		'total'     => $query->max_num_pages,
		'type'      => 'plain',
		'prev_text' => '&laquo; Prev',
		'next_text' => 'Next &raquo;',
	) );

	$pagination_html = $links
		? '<nav class="navigation pagination" aria-label="Posts pagination"><h2 class="screen-reader-text">Posts pagination</h2><div class="nav-links">' . $links . '</div></nav>'
		: '';

	wp_reset_postdata();
	wp_send_json_success( array(
		'posts'      => $posts_html,
		'pagination' => $pagination_html,
	) );
}
add_action('wp_ajax_filter_blog_posts', 'wp_guarapo_filter_blog_posts');
add_action('wp_ajax_nopriv_filter_blog_posts', 'wp_guarapo_filter_blog_posts');


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

/**
 * Display related posts section
 */
function create_relatedposts_shortcode() {
	$categories = wp_get_post_categories( get_the_ID() );

	$args_relatedposts = array(
		'posts_per_page' => '3',
		'order'          => 'DESC',
		'post__not_in'   => array( get_the_ID() ),
		'category__in'   => $categories,
	);

	$relatedposts = new WP_Query( $args_relatedposts );

	if ( $relatedposts->have_posts() ) {
		echo '<div class="container mt-5"><div class="row"><hr><h3 class="mt-5 mb-4">Related posts</h3>';
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

/**
 * Category Image Meta for SEO
 */

// Enqueue media scripts on category edit pages
function wp_guarapo_category_admin_scripts($hook) {
    if ($hook === 'term.php' || $hook === 'edit-tags.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'wp_guarapo_category_admin_scripts');

// Add image field to category edit form
function wp_guarapo_category_image_field($term) {
    $image_id = get_term_meta($term->term_id, 'thumbnail_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category-image"><?php esc_html_e('Category Image', 'wp_guarapo'); ?></label></th>
        <td>
            <input type="hidden" id="category_image_id" name="category_image_id" value="<?php echo esc_attr($image_id); ?>">
            <div id="category-image-preview" style="margin-bottom: 10px;">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 300px; height: auto;">
                <?php endif; ?>
            </div>
            <button type="button" class="button" id="category-image-upload"><?php esc_html_e('Select Image', 'wp_guarapo'); ?></button>
            <button type="button" class="button" id="category-image-remove" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e('Remove Image', 'wp_guarapo'); ?></button>
            <p class="description"><?php esc_html_e('This image will be used for social sharing (Open Graph/Twitter) on category pages.', 'wp_guarapo'); ?></p>
        </td>
    </tr>
    <script>
    jQuery(document).ready(function($) {
        var mediaFrame;
        $('#category-image-upload').on('click', function(e) {
            e.preventDefault();
            if (mediaFrame) { mediaFrame.open(); return; }
            mediaFrame = wp.media({
                title: '<?php echo esc_js(__('Select Category Image', 'wp_guarapo')); ?>',
                button: { text: '<?php echo esc_js(__('Use this image', 'wp_guarapo')); ?>' },
                multiple: false
            });
            mediaFrame.on('select', function() {
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                $('#category_image_id').val(attachment.id);
                $('#category-image-preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto;">');
                $('#category-image-remove').show();
            });
            mediaFrame.open();
        });
        $('#category-image-remove').on('click', function(e) {
            e.preventDefault();
            $('#category_image_id').val('');
            $('#category-image-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}
add_action('category_edit_form_fields', 'wp_guarapo_category_image_field');

// Save category image meta
function wp_guarapo_save_category_image($term_id) {
    if (isset($_POST['category_image_id'])) {
        $image_id = absint($_POST['category_image_id']);
        if ($image_id) {
            update_term_meta($term_id, 'thumbnail_id', $image_id);
        } else {
            delete_term_meta($term_id, 'thumbnail_id');
        }
    }
}
add_action('edited_category', 'wp_guarapo_save_category_image');

/**
 * SEO Description Meta Box
 */
function wp_guarapo_seo_meta_box() {
    add_meta_box(
        'wp_guarapo_seo_description',
        esc_html__( 'SEO Description', 'wp_guarapo' ),
        'wp_guarapo_seo_meta_box_render',
        array( 'post', 'page' ),
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'wp_guarapo_seo_meta_box' );

function wp_guarapo_seo_meta_box_render( $post ) {
    wp_nonce_field( 'wp_guarapo_save_seo_description', 'wp_guarapo_seo_nonce' );
    $value = get_post_meta( $post->ID, '_seo_description', true );
    ?>
    <p>
        <label for="wp_guarapo_seo_description">
            <?php esc_html_e( 'Custom meta description for search engines. Leave blank to use the excerpt or content snippet.', 'wp_guarapo' ); ?>
        </label>
    </p>
    <textarea
        id="wp_guarapo_seo_description"
        name="wp_guarapo_seo_description"
        rows="3"
        style="width:100%;resize:vertical;"
        maxlength="160"
    ><?php echo esc_textarea( $value ); ?></textarea>
    <p id="wp_guarapo_seo_char_count" style="color:#646970;font-size:12px;">
        <?php
        $count = mb_strlen( $value );
        printf(
            esc_html__( '%d / 160 characters (recommended: 120\u2013160)', 'wp_guarapo' ),
            $count
        );
        ?>
    </p>
    <script>
    (function() {
        var textarea = document.getElementById('wp_guarapo_seo_description');
        var counter  = document.getElementById('wp_guarapo_seo_char_count');
        if (!textarea || !counter) return;
        textarea.addEventListener('input', function() {
            var len = textarea.value.length;
            var color = (len >= 120 && len <= 160) ? '#00a32a' : (len > 160 ? '#d63638' : '#646970');
            counter.style.color = color;
            counter.textContent = len + ' / 160 characters (recommended: 120\u2013160)';
        });
    })();
    </script>
    <?php
}

function wp_guarapo_seo_meta_box_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['wp_guarapo_seo_nonce'] ) ||
         ! wp_verify_nonce( $_POST['wp_guarapo_seo_nonce'], 'wp_guarapo_save_seo_description' ) ) return;

    $post_type = get_post_type( $post_id );
    $cap = ( 'page' === $post_type ) ? 'edit_page' : 'edit_post';
    if ( ! current_user_can( $cap, $post_id ) ) return;

    if ( isset( $_POST['wp_guarapo_seo_description'] ) ) {
        $new_value = sanitize_textarea_field( wp_unslash( $_POST['wp_guarapo_seo_description'] ) );
        if ( '' !== $new_value ) {
            update_post_meta( $post_id, '_seo_description', $new_value );
        } else {
            delete_post_meta( $post_id, '_seo_description' );
        }
    }
}
add_action( 'save_post', 'wp_guarapo_seo_meta_box_save' );
