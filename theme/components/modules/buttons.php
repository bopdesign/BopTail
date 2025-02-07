<?php
/**
 * MODULE: Buttons Group
 * Display one or multiple buttons.
 */

use function BopTail\Helpers\print_element;
use function BopTail\Helpers\get_formatted_atts;
use function BopTail\Helpers\get_formatted_args;

$module_defaults = array(
	'class'                 => [ 'acf-module', 'acf-module-buttons', 'flex', 'flex-wrap', 'items-center' ],
	'buttons_justification' => 'start',
	'buttons'               => [],
);

$module_args = get_formatted_args( $args, $module_defaults );

switch ( $module_args['buttons_justification'] ) {
	case 'between':
		$module_args['class'][] = 'justify-between';
		break;
	case 'center':
		$module_args['class'][] = 'justify-center';
		break;
	case 'end':
		$module_args['class'][] = 'justify-end';
		break;
	case 'start':
	default:
		$module_args['class'][] = 'justify-start';
		break;
}

// Set up element attributes.
$module_atts = get_formatted_atts( [ 'class' ], $module_args );

if ( ! empty( $module_args['buttons'] ) && is_array( $module_args['buttons'] ) ) :
	?>
	<div <?php echo $module_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped?>>
		<?php
		// Loop through our buttons array.
		$i = 0;
		foreach ( $module_args['buttons'] as $button ) :
			$button_data = $button['button'];

			// Button.
			if ( ! empty( $button ) ) :
				if ( $i > 0 ) {
					$button_data['class'] = 'ml-2 lg:ml-3';
				}

				print_element( 'button', $button_data );

				$i++;
			endif;
		endforeach;
		?>
	</div>
<?php endif;
