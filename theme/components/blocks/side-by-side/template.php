<?php

/**
 * BLOCK: Side by Side (Cards))
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
use function BopTail\Helpers\print_element;
use function BopTail\Helpers\print_module;

$block_args     = isset( $args ) ? $args : '';
$block_defaults = array(
	'id'                  => ! empty( $block['anchor'] ) ? $block['anchor'] : 'side-by-side-' . $block['id'],
	'class'               => [ 'acf-block', 'side-by-side', 'relative' ],
	'allowed_innerblocks' => [],
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
	'media',
	'content',
), $block['id'] );

// Extract animation class in case we want to apply to a single element.
$animation_class = $block_classes['animation'];

$container_class = join( ' ', array(
	'relative',
	$block_classes['container_size'],
) );
$column_class    = join( ' ', array(
	$block_classes['align_text'],
	$block_classes['inner_width'],
	$animation_class,
) );

// Set default order values
$content_order = $block_content['content_order'] ?? 'media-text';

$media_order         = 'order-1';
$content_order_class = 'order-2 lg:pl-16 xl:pl-32';

// If the content order is "text-media", swap the values.
if ( 'text-media' === $content_order ) {
	$media_order         = 'order-2';
	$content_order_class = 'order-1 lg:pr-16 xl:pr-32';
}

// Build the final classes.
$media_group_class   = "media-group {$media_order}";
$content_group_class = "content-group {$content_order_class}";

if ( ! empty( $block['data']['_is_preview'] ) ) :
	?>
	<figure style="width: 100%;">
		<img src="<?php echo esc_url( get_theme_file_uri( '/components/blocks/side-by-side/preview-side-by-side.png' ) ); ?>"
		     style="width: 100%;height: 100%;object-fit: contain;object-position: center;" alt="<?php esc_html_e( 'Block Preview - Side by Side', BOPTAIL_TEXT_DOMAIN ); ?>">
	</figure>
<?php else: ?>
	<section <?php echo $block_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php print_background_options( $settings ); ?>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="flex flex-col md:flex-row flex-nowrap gap-8 lg:items-center lg:justify-between">
				<div class="<?php echo esc_attr( $media_group_class ); ?> basis-1/2 h-full md:sticky top-0 lg:relative">
					<?php
					$media_group = $block_content['media'];
					$media_type  = $media_group['media_type'];

					if ( 'image' === $media_type ) {
						$image_data  = $media_group['image'];
						$image_id    = $image_data['image'];
						$image_size  = $image_data['image_size'] ?? 'large';
						$image_class = 'w-full h-full object-contain';

						echo wp_get_attachment_image( $image_id, $image_size, false, array(
							'class'       => $image_class,
							'alt'         => '',
							'aria-hidden' => 'true',
						) );
					}
					?>
				</div>
				<div class="<?php echo esc_attr( $content_group_class ); ?> basis-1/2 h-full">
					<?php
					$content = $block_content['content'];

					// Heading.
					if ( $content['content_heading'] ) :
						print_element( 'heading', [
							'level' => 2,
							'class' => [ 'text-black', 'mt-0', 'mb-8', ],
							'text'  => $content['content_heading'],
						] );
					endif;

					if ( ! empty( $content['content_copy'] ) ) :
						print_element( 'content', [
							'class'   => [ 'not-prose', 'text-black', 'text-xl', 'mt-0', 'mb-4', ],
							'content' => $content['content_copy'],
						] );
					endif;

					// Buttons.
					if ( ! empty( $content['buttons_buttons'] ) ) :
						$buttons['class']                 = 'mt-8';
						$buttons['buttons_justification'] = $content['buttons_buttons_justification'];
						$buttons['buttons']               = $content['buttons_buttons'];

						print_module( 'buttons', $buttons );
					endif;
					?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
