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
function setup_block_defaults( $block_defaults, $block_args = [], $block = null ) {
	// Parse the $block_args if we're rendering this with print_block() from a theme.
	if ( ! empty( $block_args ) ) :
		$block_defaults = get_formatted_args( $block_args, $block_defaults );
	endif;

	// Get block settings.
	$settings = get_block_settings( $block );

	// Merge settings with block defaults to get all settings.
	$block_settings = get_formatted_args( $settings, $block_defaults );

	// Get block classes: custom, colors, alignment, spacing, etc.
	$block_classes = [];

	if ( ! empty( $block_settings ) ) {
		$block_classes = get_block_classes( $block_settings );
	}

	if ( ! empty( $block_classes ) ) :
		$block_defaults['class'] = array_merge( $block_defaults['class'], $block_classes );
	endif;

	// Set up block attributes.
	$block_atts = get_formatted_atts( [ 'class', 'id' ], $block_defaults );

	// Get classes for our settings.
	$setting_classes = [];

	if ( ! empty( $block_settings['settings'] ) ) {
		foreach ( $block_settings['settings'] as $setting => $value ) {
			$setting_classes[ $setting ] = get_class_name_by_attribute( $setting, $value );
		}
	}

	// Get background settings.
	$background_settings = get_background_settings( $block_settings['settings'] );

	return [ $block_defaults, $block_atts, $setting_classes, $background_settings ];
}
