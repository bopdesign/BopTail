<?php
/**
 * BLOCK: Hero Banner - Home
 *
 * @link    https://developer.wordpress.org/block-editor/
 *
 * @param array        $block      The block settings and attributes.
 * @param array        $content    The block inner HTML (empty).
 * @param bool         $is_preview True during AJAX preview.
 * @param (int|string) $post_id    The post ID this block is saved to.
 *
 * @package BopTail
 */

use function BopTail\Helpers\get_acf_fields;
use function BopTail\Helpers\get_formatted_args;
use function BopTail\Blocks\setup_block_defaults;
use function BopTail\Blocks\print_background_options;
use function BopTail\Helpers\print_element;
use function BopTail\Helpers\print_module;

$block_args     = isset( $args ) ? $args : '';
$block_defaults = array(
	'id'       => ! empty( $block['anchor'] ) ? $block['anchor'] : 'hero-home-' . $block['id'],
	'class'    => [ 'acf-block', 'hero-banner', 'hero-banner-home', 'relative', 'overflow-x-hidden' ],
	'settings' => [
		'container_size'      => 'container relative',
		'align_text'          => 'text-left',
		'align_content'       => 'align-start justify-start is-position-top-left',
		'inner_content_width' => 'w-full',
		'animation'           => '',
	],
	'fields'   => [], // Fields passed via the print_block() function.
);

// Returns updated $block_defaults array with classes from Gutenberg and Background Options, or from the print_block() function.
// Returns formatted attributes as $block_atts array, $container_atts array.
[
	$block_defaults,
	$block_atts,
	$block_settings,
	$background_options,
] = setup_block_defaults( $block_defaults, $block_args, $block );

// Pull in the fields from ACF, if we've not pulled them in using print_block().
$block_content = ! empty( $block_defaults['fields'] ) ? $block_defaults['fields'] : get_acf_fields( array(
	'eyebrow',
	'heading',
	'content',
	'buttons',
), $block['id'] );

$block_settings = get_formatted_args( $block_settings, $block_defaults );

// Extract animation class in case we want to apply to a single element.
$animation_class = $block_settings['settings']['animation'];
$container_class = join( ' ', array(
	$block_settings['settings']['container_size'],
	$block_settings['settings']['align_text'],
	'd-flex h-100',
) );
$row_class       = join( ' ', array(
	'row',
	'h-100',
	$block_settings['settings']['align_content'],
) );
$column_class    = join( ' ', array(
	'hero-content',
	$block_settings['settings']['inner_content_width'],
	$animation_class,
) );

if ( $block_content['heading'] || $block_content['eyebrow'] || $block_content['content'] ) :
	?>
	<?php if ( ! $is_preview ) { ?>
	<section id="<?php echo esc_attr( $block['id'] ); ?>" <?php echo get_block_wrapper_attributes( array( 'class' => join( ' ', $block_defaults['class'] ) ) ); ?>>
	<?php } ?>
		<?php print_background_options( $background_options ); ?>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="<?php echo esc_attr( $row_class ); ?>">
				<div class="<?php echo esc_attr( $column_class ); ?>">
					<?php
					// Eyebrow.
					if ( $block_content['eyebrow'] ) :
						print_element( 'eyebrow', [
							'text' => $block_content['eyebrow'],
						] );
					endif;

					// Heading.
					if ( $block_content['heading'] ) :
						print_element( 'heading', [
							'text'  => $block_content['heading'],
							'level' => 1,
						] );
					endif;

					// Button.
					if ( $block_content['buttons'] ) :
						$block_content['buttons']['class'] = 'mt-4';

						print_module( 'buttons', $block_content['buttons'] );
					endif;
					?>
				</div>
			</div>
		</div>
	<?php if ( ! $is_preview ) { ?>
	</section>
	<?php } ?>
<?php endif; ?>
