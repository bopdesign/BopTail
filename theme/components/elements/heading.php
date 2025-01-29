<?php
/**
 * ELEMENT: Heading
 *
 * Elements are analogous to 'Atoms' in Brad Frost's Atomic Design Methodology.
 *
 * @link    https://atomicdesign.bradfrost.com/chapter-2/#atoms
 *
 * @package BopTail
 */

use function BopTail\Helpers\get_formatted_atts;
use function BopTail\Helpers\get_formatted_args;

$element_defaults = [
	'level' => 2,
	'id'    => '',
	'class' => [ 'acf-element', 'acf-element-heading' ],
	'text'  => false,
];

$element_args     = get_formatted_args( $args, $element_defaults );

// Make sure element should render.
if ( $element_args['text'] ) :
	// Allow all most inline elements and strip all block level elements except blockquote.
	$kses_defaults = wp_kses_allowed_html( 'data' );
	$heading_kses = array(
		'br'   => true,
		'span' => true,
		'sup'  => true,
	);
	$allowed_tags = array_merge( $kses_defaults, $heading_kses );

	// Set up element attributes.
	$element_atts = get_formatted_atts( [ 'id', 'class' ], $element_args );
	?>
	<h<?php echo esc_attr( $element_args['level'] ); ?> <?php echo $element_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses( $element_args['text'], $allowed_tags ); ?></h<?php echo esc_attr( $element_args['level'] ); ?>>
<?php endif; ?>
