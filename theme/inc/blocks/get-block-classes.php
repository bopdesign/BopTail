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
 * @param array $block_settings Array of block settings.
 *
 * return array The updated array of classes.
 */
function get_block_classes( $block_settings ) {
	// Setup variables.
	$settings      = $block_settings['settings'];
	$block_classes = [];
	$block_attrs   = [];

	if ( ! empty( $block_settings['class'] ) ) :
		if ( is_array( $block_settings['class'] ) ) {
			$block_classes[] = join( ' ', $block_settings['class'] );
		} else {
			$block_classes[] = $block_settings['class'];
		}
	endif;

	if ( ! empty( $settings['background_type'] ) ) {
		switch ( $settings['background_type'] ) {
			case 'color':
				$block_classes[] = 'has-background';
				$block_classes[] = 'color-as-background';

				if ( $settings['background_color']['color_picker'] ) {
					$background_color = $settings['background_color']['color_picker'];
					$block_classes[]  = 'has-' . esc_attr( $background_color ) . '-background-color';
				}
				break;
			case 'image':
			case 'video':
				$block_classes[] = 'has-background';
				$block_classes[] = $settings['background_type'] . '-as-background';

				if ( ! empty( $settings['fixed_background'] ) && $settings['fixed_background'] ) {
					$block_classes[] = 'has-fixed-background';
				}
				break;
			case 'none':
			default:
				$block_classes[] = 'no-background';
		}
	}

	if ( ! empty( $settings['full_height'] ) && $settings['full_height'] ) {
		$block_attrs['full_height'] = $settings['full_height'];
	}

	if ( ! empty( $settings['align'] ) ) {
		$block_attrs['align'] = $settings['align'];
	} elseif ( empty( $settings['align'] ) || '' === $settings['align'] ) {
		$block_attrs['align'] = 'none';
	}

	// Set top/bottom margin for the block.
	if ( ! empty( $settings['margin_top'] ) ) {
		$block_attrs['margin_top'] = $settings['margin_top'];
	}

	if ( ! empty( $settings['margin_bottom'] ) ) {
		$block_attrs['margin_bottom'] = $settings['margin_bottom'];
	}

	// Set top/bottom padding for the block.
	if ( ! empty( $settings['padding_top'] ) ) {
		$block_attrs['padding_top'] = $settings['padding_top'];
	}

	if ( ! empty( $settings['padding_bottom'] ) ) {
		$block_attrs['padding_bottom'] = $settings['padding_bottom'];
	}

	foreach ( $block_attrs as $attr => $value ) {
		$block_classes[] = get_class_name_by_attribute( $attr, $value );
	}

	return $block_classes;
}
