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
                    <?php $categories = get_the_category();
                    if ( ! empty( $categories ) ) :
                        ?>
                        
                        <div class="text-center mt-2">
                        <?php if ( has_tag('es') ) : ?>
                            <span class="entry-lang">🇪🇸 En español</span>
                            <span class="blog-classic-entry__separator">|</span>
                    <?php endif; ?>
                        <span class="entry-cat">
                            <?php echo esc_html( $categories[0]->name ); ?>
                        </span>
                        <?php endif; ?>
                    </div>
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

        <?php
        // Post navigation within the same category
        $prev_post = get_previous_post(true); // true = in same term (category)
        $next_post = get_next_post(true);

        if ($prev_post || $next_post) : ?>
        <nav class="post-category-nav container" aria-label="<?php esc_attr_e('Posts navigation', 'wp_guarapo'); ?>">
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <div class="post-category-nav__links">

                        <?php if ($prev_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="post-category-nav__item post-category-nav__item--prev">
                            <span class="post-category-nav__label"><?php esc_html_e('Previous', 'wp_guarapo'); ?></span>
                            <span class="post-category-nav__title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                        </a>
                        <?php endif; ?>

                        <?php if ($next_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="post-category-nav__item post-category-nav__item--next">
                            <span class="post-category-nav__label"><?php esc_html_e('Next', 'wp_guarapo'); ?></span>
                            <span class="post-category-nav__title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                        </a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </nav>
        <?php endif; ?>

        <div class="mt-3 text-center">
            <hr class="center my-5">
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