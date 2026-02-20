<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_guarapo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Preconnect hints for performance -->
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
	<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

	<!-- Preload critical CSS -->
	<link rel="preload" href="<?php echo esc_url( get_template_directory_uri() . '/dist/css/bundle.css' ); ?>" as="style">

	<?php
	// Determine the best image for social sharing (OG & Twitter).
	$og_image = '';

	// If viewing a category archive, try to use the category image first.
	if (is_category()) {
		$term = get_queried_object();
		if ($term && isset($term->term_id)) {
			// Common pattern: image stored as attachment ID in "thumbnail_id".
			$cat_image_id = get_term_meta($term->term_id, 'thumbnail_id', true);
			if ($cat_image_id) {
				$og_image = wp_get_attachment_image_url($cat_image_id, 'large');
			}

			// Fallback: image URL stored directly in a custom term meta field "image".
			if (!$og_image) {
				$cat_image_url = get_term_meta($term->term_id, 'image', true);
				if ($cat_image_url) {
					$og_image = $cat_image_url;
				}
			}
		}
	}

	// For non-category (or if no category image), fall back to post thumbnail.
	if (!$og_image && has_post_thumbnail()) {
		$og_image = get_the_post_thumbnail_url(null, 'large');
	}

	// Final fallback: default hero image.
	if (!$og_image) {
		$og_image = get_template_directory_uri() . '/dist/assets/images/hero.jpg';
	}

	// Determine description for OG/Twitter tags
	$og_description = '';
	if (is_singular() && has_excerpt()) {
		$og_description = get_the_excerpt();
	} elseif (is_singular()) {
		$og_description = wp_trim_words(strip_shortcodes(get_the_content()), 30, '...');
	} elseif (is_category()) {
		$og_description = category_description();
	}
	if (!$og_description) {
		$og_description = get_bloginfo('description');
	}

	// Determine URL for OG tags
	if (is_singular()) {
		$og_url = get_permalink();
	} elseif (is_category()) {
		$og_url = get_category_link(get_queried_object_id());
	} elseif (is_home() || is_front_page()) {
		$og_url = home_url('/');
	} else {
		$og_url = home_url(add_query_arg(array(), $wp->request));
	}
	?>

	<!-- Open Graph Meta Tags -->
	<meta property="og:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
	<meta property="og:description" content="<?php echo esc_attr($og_description); ?>">
	<meta property="og:type" content="<?php echo is_single() ? 'article' : 'website'; ?>">
	<meta property="og:url" content="<?php echo esc_url($og_url); ?>">
	<meta property="og:image" content="<?php echo esc_url($og_image); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">

	<!-- Twitter Card Meta Tags -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr(wp_get_document_title()); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr($og_description); ?>">
	<meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'wp_guarapo'); ?></a>
		<header class="container gx-0 site-header">
			<nav class="navbar navbar-expand-lg navbar-light py-0" id="mainNav">
					<!-- Brand and toggle get grouped for better mobile display -->
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
     					 <span class="navbar-toggler-icon"></span>
					</button>
						<?php
						wp_nav_menu(array(
							'theme_location'    => 'menu-1',
							'depth'             => 2,
							'container'         => 'div',
							'container_class'   => 'collapse navbar-collapse justify-content-start',
							'container_id'      => 'navbarScroll',
							'menu_class'        => 'nav navbar-nav',
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
							'walker'            => new WP_Bootstrap_Navwalker(),
						));
						?>
					<span class="d-none d-md-block">
						<?php dynamic_sidebar('header_area_icons'); ?>
					</span>
					<div class="button button-outline d-none d-lg-block d-xl-block">
						<a href="https://twitter.com/messages/compose?recipient_id=2344175338" target="_blank" rel="noopener noreferrer">Get in touch →</a>
					</div>
					<div class="button button-outline d-sm-block d-md-block d-lg-none">
						<a href="https://twitter.com/messages/compose?recipient_id=2344175338" target="_blank" rel="noopener noreferrer">
							<i class="fab fa-x-twitter" aria-label='icon'></i>
						</a>
					</div>
			</nav>
		</header><!-- #masthead -->
