<?php
/**
 * Display SVG Markup.
 */

namespace BopTail\TemplateTags;

use function BopTail\Functions\get_svg;

/**
 * Display SVG Markup.
 *
 * @author BopDesign
 *
 * @param array $args The parameters needed to get the SVG.
 */
function print_svg( $args = [] ) {
	$kses_defaults = wp_kses_allowed_html( 'post' );

	$svg_args = [
		'svg'   => [
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true, // <= Must be lowercase!
			'color'           => true,
			'stroke-width'    => true,
		],
		'g'     => [ 'color' => true ],
		'title' => [
			'title' => true,
			'id'    => true,
		],
		'path'  => [
			'd'     => true,
			'color' => true,
		],
		'use'   => [
			'xlink:href' => true,
		],
	];

	$allowed_tags = array_merge(
		$kses_defaults,
		$svg_args
	);

	echo wp_kses(
		get_svg( $args ),
		$allowed_tags
	);
}
