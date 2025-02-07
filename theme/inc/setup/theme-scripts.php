<?php
/**
 * Setup theme scripts and styles.
 */

namespace BopTail\Setup\Scripts;

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function theme_scripts() {
	wp_enqueue_style( 'boptail-style', get_template_directory_uri() . '/assets/css/app.css', array(), BOPTAIL_VERSION );
	wp_enqueue_script( 'boptail-script', get_template_directory_uri() . '/assets/js/script.min.js', array(), BOPTAIL_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\theme_scripts' );

/**
 * Enqueue the block editor script.
 *
 * @return void
 */
function enqueue_block_editor_script() {
	if ( is_admin() ) {
		wp_enqueue_script( 'boptail-editor', get_theme_file_uri( '/assets/js/block-editor.min.js' ), array(
			'wp-blocks',
			'wp-edit-post',
		), BOPTAIL_VERSION, true );
		wp_add_inline_script( 'boptail-editor', "tailwindTypographyClasses = '" . esc_attr( BOPTAIL_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}

add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_block_editor_script' );

/**
 * Enqueue a script in the WordPress admin on edit.php.
 *
 * @param string $hook Hook suffix for the current admin page.
 */
function enqueue_admin_scripts( $hook ) {
	/**
	 * Selectively enqueue scripts and styles only in the pages they are going to be used, and avoid adding script and
	 * styles to all admin dashboard unnecessarily.
	 *
	 * This adds ACF script to content editing pages and theme options only.
	 */
	if ( 'post.php' === $hook || str_contains( $hook, 'theme-settings' ) || str_contains( $hook, '_page_footer' ) ) {
		wp_enqueue_script( 'boptail-acf-script', get_theme_file_uri( '/assets/js/admin-acf.min.js' ), [ 'acf-input' ], null );
	}
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_admin_scripts' );
