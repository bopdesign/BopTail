<?php
/**
 * ELEMENT: Arrow - Animated
 * Displays the arrow with animation on hover.
 *
 * Elements are analogous to 'Atoms' in Brad Frost's Atomic Design Methodology.
 *
 * @link    https://atomicdesign.bradfrost.com/chapter-2/#atoms
 */

use function BopTail\Helpers\get_formatted_atts;
use function BopTail\Helpers\get_formatted_args;

$element_defaults = [
	'class'         => [
		'acf-element',
		'acf-element-arrow-animated',
		'group/item',
		'inline-flex',
		'items-center',
		'justify-center',
		'w-3.5',
		'h-3',
		'relative',
		'overflow-hidden',
	],
	'direction'     => 'right',
	'aria'          => [
		'controls' => '',
		'disabled' => false,
		'expanded' => false,
		'label'    => false,
		'current'  => '',
	],
];

if ( ! empty( $args ) ) {
	$element_defaults['class'][] = ( 'right' === $args['direction'] ) ? 'ml-1' : 'mr-1';
	$element_args = get_formatted_args( $args, $element_defaults );
} else {
	$element_defaults['class'][] = 'ml-1';
	$element_args = get_formatted_args( [], $element_defaults );
}

// Set up element attributes.
$element_atts = get_formatted_atts( [ 'class', 'aria', ], $element_args );
?>
<?php if ( 'right' === $element_args['direction'] ) : ?>
	<span <?php echo $element_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<span class="shaft bg-foreground absolute top-50% w-0 h-0.5 invisible translate-x-0.75 transition-all ease-out group-hover/item:w-3 group-hover/item:visible group-hover/item:translate-x-0"></span>
		<svg xmlns="http://www.w3.org/2000/svg"
		     class="transition-transform ease-out w-auto h-full group-hover/item:translate-x-0.75" width="11.3"
		     height="16" viewBox="0 0 11.3 16">
			<path fill="currentColor" d="M0,0 4.4,0 11.3,8.2 4.4,16 0,16 7,8.3z"/>
		</svg>
	</span>
<?php else : ?>
	<span <?php echo $element_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<span class="shaft bg-foreground absolute top-50% w-0 h-0.5 invisible -translate-x-0.75 transition-all ease-out group-hover/item:w-3 group-hover/item:visible group-hover/item:translate-x-0"></span>
		<svg xmlns="http://www.w3.org/2000/svg"
		     class="transition-transform ease-out w-auto h-full group-hover/item:-translate-x-0.75" width="11.3"
		     height="16" viewBox="0 0 11.3 16">
			<path fill="#03282c" d="M11.3,0 6.9,0 0,8.2 6.9,16 11.3,16 4.4,8.3z"/>
		</svg>
	</span>
<?php endif;
