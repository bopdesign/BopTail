<?php
/**
 * ELEMENT: Content
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
	'class'   => [ 'acf-element', 'acf-element-content' ],
	'id'      => '',
	'content' => false,
];

$element_args = get_formatted_args( $args, $element_defaults );

// Make sure element should render.
if ( $element_args['content'] ) :
	// Set up element attributes.
	$element_atts = get_formatted_atts( [ 'class', 'id' ], $element_args );
	?>
	<div <?php echo $element_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $element_args['content'] ); ?></div>
<?php endif; ?>
