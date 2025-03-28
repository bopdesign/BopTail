<?php
/**
 * Register custom blocks for the theme.
 */

namespace BopTail\Blocks;

// If ACF isn't activated, then bail.
if ( ! class_exists( 'ACF' ) ) {
	return false;
}

/**
 * Register our custom blocks.
 *
 * @return void
 */
function register_acf_blocks() {
	$blocks_path = get_theme_file_path( '/components/blocks' );

	if ( file_exists( $blocks_path ) ) {
		$block_dirs = array_filter( glob( $blocks_path . '/*' ), 'is_dir' );

		foreach ( $block_dirs as $block ) {
			register_block_type( $block );

			/**
			 * If there’s an init.php file in the block directory, load that too.
			 * Additional PHP code to run independent of the block’s rendering, i.e.:
			 * - register fields via PHP
			 * - register styles and scripts
			 */
			if ( file_exists( $block . '/init.php' ) ) {
				include_once $block . '/init.php';
			}
		}
	}
}

add_action( 'acf/init', __NAMESPACE__ . '\register_acf_blocks', 5 );
