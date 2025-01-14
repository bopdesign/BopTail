<?php
/**
 * Functions related to comments functionality.
 *
 * @package BopTail
 */

namespace BopTail\Hooks\Comments;

use WP_Comment;

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function boptail_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', __NAMESPACE__ . '\boptail_comment_form_defaults' );

/**
 * Returns the size for avatars used in the theme.
 *
 * @return int Size of the avatar.
 */
function boptail_get_avatar_size() {
	return 60;
}

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5
 * format, adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function boptail_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty( $commenter['comment_author'] );

	if ( $commenter['comment_author_email'] ) {
		$moderation_note = __( 'Your comment is awaiting moderation.', 'boptail' );
	} else {
		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'boptail' );
	}
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<footer class="comment-meta">
			<div class="comment-author vcard">
				<?php
				if ( 0 !== $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'] );
				}
				?>
				<?php
				$comment_author = get_comment_author_link( $comment );

				if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
					$comment_author = get_comment_author( $comment );
				}

				printf(
				/* translators: %s: Comment author link. */
					wp_kses_post( __( '%s <span class="says">says:</span>', 'boptail' ) ),
					sprintf( '<b class="fn">%s</b>', wp_kses_post( $comment_author ) )
				);
				?>
			</div><!-- .comment-author -->

			<div class="comment-metadata">
				<?php
				printf(
					'<a href="%s"><time datetime="%s">%s</time></a>',
					esc_url( get_comment_link( $comment, $args ) ),
					esc_attr( get_comment_time( 'c' ) ),
					esc_html(
						sprintf(
						/* translators: 1: Comment date, 2: Comment time. */
							__( '%1$s at %2$s', 'boptail' ),
							get_comment_date( '', $comment ),
							get_comment_time()
						)
					)
				);

				edit_comment_link( __( 'Edit', 'boptail' ), ' <span class="edit-link">', '</span>' );
				?>
			</div><!-- .comment-metadata -->

			<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
			<?php endif; ?>
		</footer><!-- .comment-meta -->

		<div <?php boptail_content_class( 'comment-content' ); ?>>
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<?php
		if ( '1' === $comment->comment_approved || $show_pending_links ) {
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					)
				)
			);
		}
		?>
	</article><!-- .comment-body -->
	<?php
}
