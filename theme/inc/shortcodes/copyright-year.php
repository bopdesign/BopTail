<?php
/**
 * Shortcode to display copyright year.
 */

namespace BopTail\Shortcodes;

/**
 * Shortcode to display copyright year.
 *
 * @param array $atts Optional attributes.
 *                    $starting_year Optional. Define starting year to show starting year and current year e.g. 2010 -
 *                    2025.
 *                    $separator Optional. Separator between starting year and current year.
 *
 * @return string Copyright year text.
 */
function shortcode_copyright_year( $atts ) {
	// Setup defaults.
	$args = shortcode_atts( [
		'starting_year' => '',
		'separator'     => ' - ',
	], $atts );

	$current_year = gmdate( 'Y' );

	// Return current year if starting year is empty.
	if ( ! $args['starting_year'] ) {
		return $current_year;
	}

	return esc_html( $args['starting_year'] . $args['separator'] . $current_year );
}

add_shortcode( 'copyright_year', __NAMESPACE__ . '\shortcode_copyright_year' );
