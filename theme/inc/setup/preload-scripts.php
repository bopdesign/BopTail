<?php
/**
 * Preload styles and scripts.
 */

namespace BopTail\Setup;

/**
 * Preload styles and scripts.
 *
 * @return void
 */
function preload_scripts() {
	?>
	<link rel="preload" href="<?php echo esc_url( get_theme_file_uri( '/style.css?ver=' . BOPTAIL_VERSION ) ); ?>" as="style">
	<link rel="preload" href="<?php echo esc_url( get_theme_file_uri( '/assets/js/script.min.js?ver=' . BOPTAIL_VERSION ) ); ?>" as="script">
	<?php
}
add_action( 'wp_head', __NAMESPACE__ . '\preload_scripts', 1 );
