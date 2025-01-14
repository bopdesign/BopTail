<?php
/**
 * BopTail Theme constants and setup functions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BopTail
 */

define( 'BOPTAIL_ROOT_PATH', trailingslashit( get_template_directory() ) );
define( 'BOPTAIL_ROOT_URL', trailingslashit( get_template_directory_uri() ) );
define( 'BOPTAIL_INC', BOPTAIL_ROOT_PATH . 'inc/' );
define( 'BOPTAIL_COMPONENTS', BOPTAIL_ROOT_PATH . 'components/' );
define( 'BOPTAIL_TEXT_DOMAIN', 'boptail' );

if ( ! defined( 'BOPTAIL_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	$theme_version  = wp_get_theme()->get( 'Version' );
	$version_string = is_string( $theme_version ) ? $theme_version : null;
	define( 'BOPTAIL_VERSION', $version_string );
}

if ( ! defined( 'BOPTAIL_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `boptail_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define( 'BOPTAIL_TYPOGRAPHY_CLASSES', 'prose prose-lg prose-boptail max-w-none prose-a:text-foreground' );
}

/*
 * Check if the WordPress version is 6.0 or higher, and if the PHP version is at least 7.4.
 * If not, do not activate.
 */
if ( version_compare( $GLOBALS['wp_version'], '6.0', '<' ) || version_compare( PHP_VERSION_ID, '70400', '<' ) ) {
	require_once BOPTAIL_INC . 'compatibility.php';

	return;
}

/**
 * Check to see if ACF Pro is active. Give a warning message if not.
 */
require_once BOPTAIL_INC . 'dependency.php';

/**
 * Get all the include files for the theme.
 *
 * @return void
 */
function include_inc_files() {
	$includes = [
		'inc/setup/',           // Theme setup.
		'inc/functions/',       // Custom functions that act independently of the theme templates.
		'inc/hooks/',           // Load custom filters and hooks, which enhance the theme by hooking into WordPress.
		'inc/helpers/',         // Includes helper files.
		'inc/shortcodes/',      // Load shortcodes.
		'inc/template-tags/',   // Custom template tags for this theme.
		'inc/acf/acf.php',      // Theme ACF setup and blocks.
		'inc/blocks/',          // Includes block default settings.
		'inc/optimization.php', // Optimize theme performance. Must load last for best results.
	];

	foreach ( $includes as $include ) {
		$include = trailingslashit( BOPTAIL_ROOT_PATH ) . $include;

		// Allows inclusion of individual files or all .php files in a directory.
		if ( is_dir( $include ) ) {
			foreach ( glob( $include . '*.php' ) as $file ) {
				require_once $file;
			}
		} else {
			require_once $include;
		}
	}
}

include_inc_files();
