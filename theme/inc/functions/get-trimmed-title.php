<?php
/**
 * Trim the title length.
 */

namespace BopTail\Functions;

/**
 * Trim the title length.
 *
 * @param array $args Parameters include length and more.
 *
 * @return string The title.
 */
function get_trimmed_title( $args = [] ) {
	// Set defaults.
	$defaults = [
		'length' => 12,
		'more'   => '...',
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the title.
	return wp_kses_post( wp_trim_words( get_the_title( get_the_ID() ), $args['length'], $args['more'] ) );
}
