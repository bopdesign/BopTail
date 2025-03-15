<?php
/**
 * Template part for displaying pages.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BopTail
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div <?php boptail_content_class( 'entry-content' ); ?>>
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<div class="container my-4">
				<?php boptail_edit_entry_link(); ?>
			</div>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
