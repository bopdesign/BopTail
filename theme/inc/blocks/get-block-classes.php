<?php

/**
 * Returns an array of classes from a block's Gutenberg fields.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

/**
 * Returns an updated array of classes.
 *
 * @param array $block    Array of block attributes.
 * @param array $settings Array of block settings.
 *
 * @return array The updated array of classes.
 */
function get_block_classes( $settings, $block = null ) {
	// Setup variables.
	$block_classes = [];

	// These are top level classes and should always be auto mounted to the main block container/tag.
	if ( isset( $block ) ) {
		// Adds class(es) entered via block's setting tab: 'Advanced' -> 'ADDITIONAL CSS CLASS(ES)'.
		if ( ! empty( $block['className'] ) ) :
			$block_classes[] = $block['className'];
		endif;
	}

	if ( ! empty( $settings['background']['type'] ) ) {
		switch ( $settings['background']['type'] ) {
			case 'color':
				$block_classes[] = 'has-background';
				$block_classes[] = 'color-as-background';

				if ( $settings['background']['color']['color_picker'] ) {
					$background_color = $settings['background']['color']['color_picker'];
					$block_classes[] = "has-$background_color-background-color";
					$block_classes[] = "bg-$background_color";
				}
				break;
			case 'gradient':
				$block_classes[] = 'has-background';
				$block_classes[] = 'gradient-as-background';

				if ( $settings['background']['gradient']['gradient_picker'] ) {
					$background_gradient = $settings['background']['gradient']['gradient_picker'];
					$block_classes[] = "has-$background_gradient-background-gradient";
					$block_classes[] = $background_gradient;
				}
				break;
			case 'image':
			case 'video':
				$block_classes[] = 'has-background';
				$block_classes[] = $settings['type'] . '-as-background';

				if ( ! empty( $settings['background']['fixed'] ) && $settings['background']['fixed'] ) {
					$block_classes[] = 'has-fixed-background';
				}
				break;
			case 'none':
			default:
				$block_classes[] = 'no-background';
		}
	}

	return array_unique( $block_classes );
}
