<?php
/**
 * Template part for displaying posts in the classic blog layout
 *
 * Used by home.php for the blog posts page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

?>

<article class="blog-classic-entry" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="col-md-4">
			<?php
			$feature_img = get_the_post_thumbnail_url( null, 'large' ) ? esc_url( get_the_post_thumbnail_url( null, 'large' ) ) : catch_that_image();
			?>
			<div class="blog-classic-entry__image">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<img src="<?php echo esc_url( $feature_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
				</a>
			</div>
		</div>

		<div class="col-md-8">
			<div class="blog-classic-entry__content">
				<?php the_title( '<h2 class="blog-classic-entry__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

				<div class="blog-classic-entry__meta">
					<?php wp_guarapo_posted_on(); ?>

					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) :
						?>
						<span class="blog-classic-entry__separator">|</span>
						

					<?php if ( has_tag('es') ) : ?>
						<span class="entry-lang">🇪🇸 En español</span>
						<span class="blog-classic-entry__separator">|</span>

						<?php endif; ?>

					<span class="entry-cat">
							<?php echo esc_html( $categories[0]->name ); ?>
						</span>
					<?php endif; ?>
					<span class="blog-classic-entry__separator">|</span>
					<span class="blog-classic-entry__reading-time"><?php echo esc_html( reading_time() ); ?></span>
				</div>

				<div class="blog-classic-entry__excerpt mb-5">
					<?php
					$content = apply_filters( 'the_content', get_the_content() );
					$content = str_replace( array( '</p>', '<br />', '<br>' ), "\n\n", $content );
					$content = wp_strip_all_tags( $content );
					$content = trim( $content );
					$content = mb_strimwidth( $content, 0, 600, '...' );
					echo wpautop( $content );
					?>
				</div>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="button button-outline">Read more</a>
			</div>
		</div>
	</div>
</article>
