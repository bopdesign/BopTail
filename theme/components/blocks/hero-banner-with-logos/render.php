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
use function BopTail\Blocks\setup_block_defaults;
use function BopTail\Blocks\print_background_options;
use function BopTail\Helpers\print_element;
use function BopTail\Helpers\print_module;

$block_args     = isset( $args ) ? $args : '';
$block_defaults = array(
	'id'                  => ! empty( $block['anchor'] ) ? $block['anchor'] : 'hero-logos-' . $block['id'],
	'class'               => [ 'acf-block', 'hero-banner', 'hero-banner-logos', 'relative' ],
	'allowed_innerblocks' => [ 'core/heading', 'core/paragraph' ],
	'fields'              => [], // Fields passed via the print_block() function.
);

// Returns updated $block_defaults array with classes from Gutenberg and Background Options, or from the print_block() function.
// Returns formatted attributes as $block_atts array.
[
	$block_defaults,
	$block_atts,
	$block_classes,
	$settings,
] = setup_block_defaults( $block_defaults, $block_args, $block );

// Pull in the fields from ACF, if we've not pulled them in using print_block().
$block_content = ! empty( $block_defaults['fields'] ) ? $block_defaults['fields'] : get_acf_fields( array(
	'eyebrow',
	'heading',
	'content',
	'buttons',
), $block['id'] );

// Extract animation class in case we want to apply to a single element.
$animation_class = $block_classes['animation'];

$container_class = join( ' ', array(
	'flex',
	'flex-column',
	'flex-wrap',
	'h-full',
	'relative',
	'z-20',
	$block_classes['align_content'],
	$block_classes['container_size'],
) );
$column_class    = join( ' ', array(
	'hero-content',
	'relative',
	'pl-6 lg:pl-10',
	$block_classes['align_text'],
	$block_classes['inner_width'],
	$animation_class,
) );

if ( ! empty( $block['data']['_is_preview'] ) ) :
	?>
	<figure>
		<img src="<?php echo esc_url( BOPTAIL_ROOT_URL . 'assets/images/block-previews/hero-banner-home.jpg' ); ?>"
		     alt="<?php esc_html_e( 'Block Preview - Hero Banner Home', BOPTAIL_TEXT_DOMAIN ); ?>">
	</figure>
	<h1><?php echo esc_html( $block['data']['heading'] ); ?></h1>
	<p><?php echo esc_html( $block['data']['content'] ); ?></p>
<?php elseif ( $block_content['eyebrow'] || $block_content['heading'] || $block_content['content'] ) : ?>
	<section <?php echo $block_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php print_background_options( $settings ); ?>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="<?php echo esc_attr( $column_class ); ?>">
				<div class="separator-vertical-gradient" aria-hidden="true"></div>
				<?php
				// Eyebrow.
				if ( $block_content['eyebrow'] ) :
					print_element( 'eyebrow', [
						'class' => $block_classes['eyebrow_color'],
						'text'  => $block_content['eyebrow'],
					] );
				endif;

				// Heading.
				if ( $block_content['heading'] ) :
					print_element( 'heading', [
						'level' => 1,
						'class' => $block_classes['heading_color'],
						'text'  => $block_content['heading'],
					] );
				endif;

				// Button.
				if ( $block_content['buttons'] ) :
					$block_content['buttons']['class'] = 'mt-4';

					print_module( 'buttons', $block_content['buttons'] );
				endif;
				?>
			</div>
			<div class="basis-full self-end pt-10 lg:pt-16">
				<h2 class="text-xl md:text-3xl font-light text-white uppercase flex justify-content-between align-items-end">
					<span class="inline-block pr-2 md:pr-4">Trusted by</span><span class="inline-block self-end border-b border-white flex-auto h-px"> </span>
				</h2>
				<div class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-0 gap-y-10 sm:max-w-xl sm:grid-cols-6 lg:mx-0 lg:max-w-none lg:grid-cols-5">
					<img class="col-span-2 max-h-12 w-full object-contain object-center lg:col-span-1 px-4 border-l border-white" src="https://tailwindui.com/plus/img/logos/158x48/transistor-logo-white.svg" alt="Transistor" width="158" height="48">
					<img class="col-span-2 max-h-12 w-full object-contain object-center lg:col-span-1 px-4 border-l border-white" src="https://tailwindui.com/plus/img/logos/158x48/reform-logo-white.svg" alt="Reform" width="158" height="48">
					<img class="col-span-2 max-h-12 w-full object-contain object-center lg:col-span-1 px-4 border-l border-white" src="https://tailwindui.com/plus/img/logos/158x48/tuple-logo-white.svg" alt="Tuple" width="158" height="48">
					<img class="col-span-2 max-h-12 w-full object-contain object-center lg:col-span-1 px-4 border-l border-white" src="https://tailwindui.com/plus/img/logos/158x48/savvycal-logo-white.svg" alt="SavvyCal" width="158" height="48">
					<img class="col-span-2 max-h-12 w-full object-contain object-center lg:col-span-1 px-4 border-l border-r border-white" src="https://tailwindui.com/plus/img/logos/158x48/statamic-logo-white.svg" alt="Statamic" width="158" height="48">
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
