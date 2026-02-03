<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

?>

<article class="col-md-4 mb-5" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card-loop">

		<?php $feature_img = get_the_post_thumbnail_url() ? esc_url(get_the_post_thumbnail_url()) : catch_that_image(); ?>
		<div class="box-loop">
			<a href="<?php echo esc_url(get_permalink()); ?>">
				<img class="box-loop-image" src="<?php echo esc_url($feature_img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="400" height="300" loading="lazy" />
			</a>

			<?php
			if (strtotime($post->post_date) > strtotime('-1 weeks')) {
				echo '<span class="entry-featured">New</span>';
			}
			?>
		</div>
		<header class="entry-header">
			<?php
			the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');

			$categories = get_the_category();

			if (!empty($categories)) {
				echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '"><span class="entry-cat">' . esc_html($categories[0]->name) . '</span></a>';
			}
		 ?>

		 <div class="entry-meta mb-2 small">
			<?php
				wp_guarapo_posted_on();
				echo '<span class="reading-time">' . esc_html(reading_time()) . '</span>';
			?>
		</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
