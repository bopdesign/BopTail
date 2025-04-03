<?php
/**
 * ELEMENT: Link
 * Displays the theme link.
 *
 * Elements are analogous to 'Atoms' in Brad Frost's Atomic Design Methodology.
 *
 * @link    https://atomicdesign.bradfrost.com/chapter-2/#atoms
 */

use function BopTail\Helpers\get_formatted_atts;
use function BopTail\Helpers\get_formatted_args;
use function BopTail\Helpers\print_element;
use function BopTail\TemplateTags\print_svg;

$element_defaults = [
	'class'         => [
		'acf-element',
		'acf-element-link',
		'group/item',
		'not-prose',
		'inline-block',
		'whitespace-nowrap',
		'font-bold',
	],
	'id'            => '',
	'title'         => false,
	'url'           => false,
	'target'        => false,
	'icon'          => [],
	'icon_position' => 'after', // before | after.
	'role'          => '',
	'aria'          => [
		'controls' => '',
		'disabled' => false,
		'expanded' => false,
		'label'    => false,
		'current'  => '',
	],
];

$element_args = get_formatted_args( $args, $element_defaults );

// Make sure element should render.
if ( $element_args['title'] || $element_args['icon'] ) :
	if ( ! empty( $element_args['icon'] ) ) :
		$element_args['class'][] = 'icon';
		$element_args['class'][] = 'icon-' . $element_args['icon_position'];
	endif;

	if ( ! empty( $element_args['style'] ) ) {
		$element_args['class'][] = 'is-style-' . $element_args['style'];
	}

	// Set up element attributes.
	$element_atts = get_formatted_atts( [ 'id', 'href', 'target', 'class', 'type', 'aria', 'role' ], $element_args );
	?>
	<a <?php echo $element_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
	if ( $element_args['title'] ) :
		esc_html_e( $element_args['title'], BOPTAIL_TEXT_DOMAIN );
	endif;

	if ( ! empty( $element_args['icon'] ) ) :
		print_svg( $element_args['icon'] );
	endif;

	print_element( 'arrow-animated' );
	?>
	</a>
<?php endif; ?>
