<?php
/**
 * Merges the element defaults with the passed args.
 */

namespace BopTail\Helpers;

/**
 * Merges the element defaults with the passed args.
 *
 * @param array $args     Array of settings passed to the element.
 * @param array $defaults Array of default settings for the element.
 */
function get_formatted_args( $args, $defaults ) {
	if ( empty( $args ) ) {
		$args = [];
	}

	// Set the 'class' array key if it doesn't exist.
	$args['class'] = array_key_exists( 'class', $args ) ? $args['class'] : [];

	// Allow class to be passed as a string or an array.
	$args['class'] = ( $args['class'] && ! is_array( $args['class'] ) ) ? explode( ' ', $args['class'] ) : $args['class'];

	// Construct button args.
	if ( array_key_exists( 'button_link', $args ) ) {
		// Map the ACF link 'title' attribute to a 'button_link' -> 'title' attribute.
		if ( ! empty( $args['button_link']['title'] ) ) {
			$args['title'] = $args['button_link']['title'];
		}

		// Map the ACF link 'url' attribute to an 'href' attribute.
		if ( ! empty( $args['button_link']['url'] ) ) {
			$args['href'] = $args['button_link']['url'];
		}

		if ( ! empty( $args['button_link']['target'] ) ) {
			$args['target'] = $args['button_link']['target'];
		}

		if ( ! empty( $args['button_style'] ) ) {
			$args['style'] = $args['button_style'];
			$color         = $args['button_color']['color_picker'];

			// Border Colors: border-background | border-foreground | border-primary | border-secondary
			if ( 'fill' === $args['button_style'] && ! empty( $color ) ) {
				$btn_classes   = [
					'bg-' . esc_attr( $color ),
					'hover:bg-background',
					'border border-' . esc_attr( $color ),
				];
				$args['class'] = array_merge( $args['class'], $btn_classes );
			}

			if ( 'outline' === $args['button_style'] && ! empty( $color ) ) {
				$btn_classes   = [
					'bg-transparent',
					'hover:bg-secondary hover:text-foreground',
					'border border-' . esc_attr( $color ),
					'hover:border-secondary',
				];
				$args['class'] = array_merge( $args['class'], $btn_classes );
			}
		}

		if ( ! empty( $args['button_text_color']['color_picker'] ) ) {
			$color              = $args['button_text_color']['color_picker'];
			$text_color_classes = [
				'text-' . esc_attr( $color ),
				'has-' . esc_attr( $color ) . '-color',
			];
			$args['class']      = array_merge( $args['class'], $text_color_classes );
		}
	}

	if ( ! empty( $args['url'] ) ) {
		// Map the ACF link 'url' attribute to an 'href' attribute.
		$args['href'] = $args['url'];
	}

	// Merge with defaults.
	$classes = is_array( $args['class'] ) ? array_merge( $defaults['class'], $args['class'] ) : $defaults['class'];

	$formatted_args = wp_parse_args( $args, $defaults );

	$formatted_args['class'] = $classes;

	return $formatted_args;
}
