<?php
/**
 * ELEMENT: Eyebrow
 *
 * Elements are analogous to 'Atoms' in Brad Frost's Atomic Design Methodology.
 *
 * @link    https://atomicdesign.bradfrost.com/chapter-2/#atoms
 */

use function BopTail\Helpers\get_formatted_atts;
use function BopTail\Helpers\get_formatted_args;

$element_defaults = [
	'class' => [ 'acf-element', 'acf-element-eyebrow', 'mb-4' ],
	'text'  => false,
];
$element_args     = get_formatted_args( $args, $element_defaults );

// Make sure element should render.
if ( $element_args['text'] ) :
	// Allow all most inline elements and strip all block level elements except blockquote.
	$kses_defaults = wp_kses_allowed_html( 'data' );
	$eyebrow_kses = [
		'span' => true,
	];
	$allowed_tags = array_merge( $kses_defaults, $eyebrow_kses );
	// Set up element attributes.
	$element_atts = get_formatted_atts( [ 'class' ], $element_args );
	?>
	<div <?php echo $element_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses( $element_args['text'], $allowed_tags ); ?></div>
<?php endif; ?>
