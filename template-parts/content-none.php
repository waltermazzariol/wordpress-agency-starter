<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

?>

<section class="no-results not-found">
	<header class="container mt-5">
	<div class="d-flex justify-content-center">
		<h1><?php esc_html_e( 'No results found', 'wp_guarapo' ); ?></h1>
	</div>
	</header><!-- .page-header -->

	<div class="entry-content container mb-5 d-flex flex-column align-items-center">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'wp_guarapo' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<div class="mb-2"><?php esc_html_e( 'Lo sentimos, pero tu búsqueda no se consigue en los artículos. Intenta de nuevo.', 'wp_guarapo' ); ?></div>
			<div class="mb-2"><?php
			get_search_form(); ?> </div>
			<?php
			else :
			?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wp_guarapo' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
