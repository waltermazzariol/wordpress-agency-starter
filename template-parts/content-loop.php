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

		<div class="box-loop">
			<a href="<?php echo get_permalink() ?>">
				<?php
				 if (has_post_thumbnail()) {
					the_post_thumbnail('medium', array( 'class' => 'box-loop-image' ) );
				}
				else { ?>
					<img class="box-loop-image" src="<?php echo catch_that_image(); ?>" alt="feature default" />
				<?php } ?>
			</a>
		</div>
		<header class="entry-header">
			<?php
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		 ?>
		 <div class="entry-meta mb-2 small">
			<?php
				wp_guarapo_posted_by();
				wp_guarapo_posted_on();
				echo '<span class="reading-time">' . reading_time() . '</span>';
			?>
		</div><!-- .entry-meta -->
		</header><!-- .entry-header -->
		
		<?php	if ( 'post' === get_post_type() ) :
			?>
		
		<?php endif; ?>
		
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->