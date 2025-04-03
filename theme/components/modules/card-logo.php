<?php
/**
 * MODULE: Card - Logo
 * Display one logo card.
 */

use function BopTail\Helpers\print_element;
use function BopTail\Helpers\get_formatted_atts;
use function BopTail\Helpers\get_formatted_args;

$module_defaults = array(
	'class' => [
		'acf-module',
		'acf-module-card-logo',
		'group/item',
		'not-prose',
		'cursor-pointer',
		'max-w-50',
		'w-full',
		'h-22',
		'overflow-hidden',
		'relative',
		'rounded-xl',
		'shadow-card-logo',
		'transition-colors',
		'hover:bg-accent-teal',
	],
	'logo'  => false, // Expect image ID
	'link'  => [
		'class'  => [ 'card-link', 'text-foreground', ],
		'title'  => '',
		'target' => false,
		'url'    => false,
	],
);

$module_args = get_formatted_args( $args, $module_defaults );

// Set up element attributes.
$module_atts  = get_formatted_atts( [ 'class' ], $module_args );
$logo_classes = 'w-full h-full px-6 py-4.5 object-contain object-center group-hover/item:invisible';

if ( ! empty( $module_args['logo'] ) && is_numeric( $module_args['logo'] ) ) :
	?>
	<div <?php echo $module_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>>
		<?php
		echo wp_get_attachment_image( $module_args['logo'], 'medium', false, array(
			'class'       => $logo_classes,
			'alt'         => '',
			'aria-hidden' => 'true',
		) );
		?>
		<?php if ( ! empty( $module_args['link']['url'] ) && ! empty( $module_args['link']['title'] ) ) { ?>
			<div class="card-link-container flex flex-nowrap items-center justify-center absolute w-full h-full inset-0 invisible group-hover/item:visible">
				<?php
				$module_args['link']['class'] = [ 'card-link', 'text-foreground', ];
				print_element( 'link', $module_args['link'] );
				?>
			</div>
		<?php } ?>
	</div>
<?php endif;
