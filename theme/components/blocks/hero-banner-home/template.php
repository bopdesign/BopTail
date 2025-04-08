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
 */

use function BopTail\Helpers\get_acf_fields;
use function BopTail\Blocks\setup_block_defaults;
use function BopTail\Blocks\print_background_options;
use function BopTail\Helpers\print_module;

$block_args     = isset( $args ) ? $args : '';
$block_defaults = array(
	'id'                  => ! empty( $block['anchor'] ) ? $block['anchor'] : 'hero-home-' . $block['id'],
	'class'               => [ 'acf-block', 'acf-block-body', 'hero-banner', 'hero-banner-home', 'relative' ],
	'allowed_innerblocks' => [ 'core/heading', 'core/paragraph' ],
	// Which blocks do we want to allow to be nested in InnerBlocks.
	'fields'              => [],
	// Fields passed via the print_block() function.
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
	'side_image',
), $block['id'] );

// Extract animation class in case we want to apply to a single element.
$animation_class = $block_classes['animation'];

$container_class = join( ' ', array(
	'relative',
//	$block_classes['align_content'],
	$block_classes['container_size'],
) );
$column_class    = join( ' ', array(
	'hero-content',
	'flex',
	'flex-col',
	'justify-center',
	'space-y-4',
	$block_classes['align_text'],
	$block_classes['inner_width'],
	$animation_class,
) );

// Our InnerBlocks template to populate when new block is inserted.
$inner_blocks_template = array(
	array(
		'core/heading',
		array(
			'level'       => 1,
			'placeholder' => 'Enter your title here',
		),
	),
	array(
		'core/paragraph',
		array(
			'placeholder' => 'Enter your content here.',
		),
	),
);

if ( ! empty( $block['data']['_is_preview'] ) ) :
	?>
	<figure style="width: 100%;">
		<img src="<?php echo esc_url( get_theme_file_uri( '/components/blocks/hero-banner-home/preview-hero-banner-home.png' ) ); ?>"
		     style="width: 100%;height: 100%;object-fit: contain;object-position: center;" alt="<?php esc_html_e( 'Block Preview - Hero Banner Home', BOPTAIL_TEXT_DOMAIN ); ?>">
	</figure>
<?php else: ?>
	<section <?php echo $block_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php print_background_options( $settings ); ?>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="grid items-center gap-6 lg:grid-cols-2 lg:gap-12">
				<div class="<?php echo esc_attr( $column_class ); ?>">
					<InnerBlocks
						class="z-10"
						orientation="horizontal"
						allowedBlocks="<?php echo esc_attr( wp_json_encode( $block_defaults['allowed_innerblocks'] ) ); ?>"
						template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>"
					/>
					<?php
					// Buttons.
					if ( $block_content['buttons'] ) :
						$block_content['buttons']['class'] = 'mt-8';

						print_module( 'buttons', $block_content['buttons'] );
					endif;
					?>
				</div>

				<div class="relative mt-8 lg:mt-0">
					<div class="relative h-[368px] w-full lg:h-[672px] lg:w-[120%]">
						<?php
						echo wp_get_attachment_image( $block_content['side_image'], 'large', false, array(
							'class'         => 'absolute w-full h-full bottom-0 object-contain object-center lg:object-right not-prose',
							'alt'           => '',
							'aria-hidden'   => 'true',
							'loading'       => 'eager',
							'fetchpriority' => 'high',
						) );
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
