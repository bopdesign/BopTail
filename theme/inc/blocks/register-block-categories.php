<?php
/**
 * Register block categories.
 */

namespace BopTail\Blocks;

// If ACF isn't activated, then bail.
if ( ! class_exists( 'ACF' ) ) {
	return false;
}

/**
 * Register custom block categories.
 *
 * @link https://developer.wordpress.org/reference/hooks/block_categories_all/
 *
 * @param $block_categories
 *
 * @return mixed
 */
function register_block_category( $block_categories ) {
	// Adding a new category.
	$block_categories[] = array(
		'slug' => 'boptail',
		'title' => esc_html__( 'BopTail Blocks', BOPTAIL_TEXT_DOMAIN ),
	);

	return $block_categories;
}

add_filter( 'block_categories_all', __NAMESPACE__ . '\register_block_category', 1, 2 );
