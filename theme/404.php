<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package BopTail
 */

get_header();
?>

	<main id="main" role="main">

		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'boptail' ); ?></h1>
		</header><!-- .page-header -->

		<div <?php boptail_content_class( 'page-content' ); ?>>
			<p><?php esc_html_e( 'This page could not be found. It might have been removed or renamed, or it may never have existed.', 'boptail' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .page-content -->

	</main><!-- #main -->

<?php
get_footer();
