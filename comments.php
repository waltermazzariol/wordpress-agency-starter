<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_guarapo
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title"><?php esc_html_e( 'Responses', 'wp_guarapo' ); ?></h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 40,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wp_guarapo' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form( array(
		'comment_notes_before' => '',
		'title_reply'          => have_comments() ? '' : esc_html__( 'Responses', 'wp_guarapo' ),
		'title_reply_to'       => esc_html__( 'Response to %s', 'wp_guarapo' ),
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'wp_guarapo' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . esc_attr__( 'What are your thoughts?', 'wp_guarapo' ) . '" required></textarea></p><input type="hidden" name="author" value="Anonymous">',
	) );
	?>

</div><!-- #comments -->
