<?php

/**
 * Returns arrays of defaults for a block.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

use function BopTail\Helpers\get_formatted_args;
use function BopTail\Helpers\get_formatted_atts;

/**
 * Returns arrays of Block defaults.
 *
 * @param array $block_defaults Array of defaults from the block.
 * @param array $block_args     Array of arguments from the print_block() function.
 * @param array $block          Array containing the block's values.
 */
function setup_block_defaults( $block_defaults, $block_args = [], $block = null ): array {
	// Parse the $block_args if we're rendering this with print_block() from a theme.
	if ( ! empty( $block_args ) ) :
		$block_defaults = get_formatted_args( $block_args, $block_defaults );
	endif;

	// Get block settings and merge with defaults.
	$default_settings = get_default_block_settings();
	$settings = get_block_settings( $block );
	$block_settings = array_merge( $default_settings, $settings );

	// Get Tailwind classes based on settings.
	$tailwind_classes = get_tailwind_classes( $block_settings );

	// Get custom classes for the block and/or for block settings.
	$block_classes = isset( $block ) ? get_block_classes( $block_settings, $block ) : get_block_classes( $block_settings );
	$top_level_classes = array( $tailwind_classes['align'], $tailwind_classes['full_height'] );

	if ( ! empty( $block_classes ) ) {
		$block_defaults['class'] = array_merge( $block_defaults['class'], $block_classes, $top_level_classes );
	}

	// Set up block attributes.
	$block_atts = get_formatted_atts( [ 'id', 'class' ], $block_defaults );

	return [ $block_defaults, $block_atts, $tailwind_classes, $block_settings ];
}
