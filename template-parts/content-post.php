<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($class = 'mb-3'); ?>>
    <header class="container card-loop">
            <div class="row justify-content-md-center ">
                <div class="col-12">
                <div class="main-heading"><a href="/">Walter Mazzariol</a></div>
                    <hr class="center">
                </div>
                <div class="col-md-8">
                    <h1 class="cover-title text-center"><?php the_title(); ?></h1>
                    <?php	if ( 'post' === get_post_type() ) :
					?>
                    <div class="entry-meta mb-3 small text-center">
                        <?php
							wp_guarapo_posted_on();
							wp_guarapo_posted_by();
                            echo '<span class="reading-time">' . reading_time() . '</span>';
						?>
                    </div><!-- .entry-meta -->
                    <?php endif; ?>
                    <div class="mt-3">
                        <?php my_share_buttons(); ?>
                    </div>
					
                </div>
            </div>
    </header>

    <div class="container entry-content ">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <?php the_content(); ?>
            </div>

            <?php the_posts_pagination(); ?>
        </div><!-- .entry-content -->

        <div class="mt-3 text-center">
            <hr class="center">
            <small> Share this story</small></br>
            <?php my_share_buttons(); ?>
        </div>
        <div>
            <?php create_relatedposts_shortcode() ?>
        </div>

        <?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer">
        <?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'wp_guarapo' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
        </footer><!-- .entry-footer -->
        <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->