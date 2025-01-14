<?php
/**
 * Returns a string of formatted element attributes.
 *
 * @package BopTail
 */

namespace BopTail\Helpers;

/**
 * Returns a string of formatted element attributes.
 *
 * @param array $atts Array of elements to format from the args.
 * @param array $args Args for the element.
 */
function get_formatted_atts( $atts, $args ) {
	$atts_formatted = [];

	foreach ( $atts as $att ) :
		if ( array_key_exists( $att, $args ) && $args[ $att ] ) :
			// Handle aria attributes.
			if ( 'aria' === $att && is_array( $args['aria'] ) ) :
				foreach ( $args['aria'] as $key => $val ) :
					if ( $val ) :
						$atts_formatted[] = 'aria-' . $key . '="' . esc_attr( $val ) . '"';
					endif;
				endforeach;
			elseif ( 'data-wow-delay' === $att && is_string( $args['data-wow-delay'] ) ) :
				// Handle wow attributes.
				$atts_formatted[] = 'data-wow-delay="' . esc_attr( $args['data-wow-delay'] ) . 's"';
			else :
				// Handle multiple classes.
				if ( 'class' === $att && is_array( $args['class'] ) ) :
					$args['class'] = implode( ' ', $args['class'] );
				endif;

				$atts_formatted[] = $att . '="' . esc_attr( $args[ $att ] ) . '"';
			endif;
		endif;
	endforeach;

	return implode( ' ', $atts_formatted );
}
