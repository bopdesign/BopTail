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
	'id'                  => ! empty( $block['anchor'] ) ? $block['anchor'] : 'hero-home-' . $block['id'],
	'class'               => [ 'acf-block', 'side-by-side-card', 'relative' ],
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
	'header_eyebrow',
	'header_heading',
	'header_heading_size',
	'header_content',
	'content_order',
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
	<figure>
		<img src="<?php echo esc_url( BOPTAIL_ROOT_URL . 'assets/images/block-previews/hero-banner-home.jpg' ); ?>"
		     alt="<?php esc_html_e( 'Block Preview - Hero Banner Home', BOPTAIL_TEXT_DOMAIN ); ?>">
	</figure>
	<h1><?php echo esc_html( $block['data']['heading'] ); ?></h1>
	<p><?php echo esc_html( $block['data']['content'] ); ?></p>
<?php else: ?>
	<section <?php echo $block_atts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php print_background_options( $settings ); ?>
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="flex flex-row justify-start mb-8">
				<div class="<?php echo esc_attr( $column_class ); ?>">
					<?php
					// Eyebrow.
					if ( $block_content['header_eyebrow'] ) :
						print_element( 'header_eyebrow', [
							'class' => $block_classes['eyebrow_color'],
							'text'  => $block_content['header_eyebrow'],
						] );
					endif;
					?>
					<?php
					// Heading.
					if ( $block_content['header_heading'] ) :
						print_element( 'heading', [
							'level' => $block_content['header_heading_size'],
							'class' => [ $block_classes['heading_color'], 'mt-0', 'mb-0', ],
							'text'  => $block_content['header_heading'],
						] );
					endif;
					?>
					<?php
					// Content.
					if ( $block_content['header_content'] ) :
						print_element( 'content', [
							'class'   => [ $block_classes['content_color'], 'mb-8', ],
							'content' => $block_content['header_content'],
						] );
					endif;
					?>
				</div>
			</div>
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
					$card_data = $block_content['content'];

					// Heading.
					if ( $card_data['card_heading'] ) :
						print_element( 'heading', [
							'level' => 3,
							'class' => [ 'font-heading', 'text-black', 'mt-0', 'mb-8', ],
							'text'  => $card_data['card_heading'],
						] );
					endif;

					if ( ! empty( $card_data['card_content'] ) ) {
						?>
						<div class="card bg-background flex flex-col gap-6 divide-y-1 divide-beige shadow-large p-8 lg:pt-13.5 lg:pb-8.75 lg:pl-13.5 lg:pr-8">
							<?php
							foreach ( $card_data['card_content'] as $card_content_item ) {
								$card_content_heading   = $card_content_item['heading'];
								$card_content_paragraph = $card_content_item['paragraph'];
								$card_content_link      = $card_content_item['link'];
								?>
								<div class="flex flex-col">
									<?php
									if ( ! empty( $card_content_heading ) ) :
										print_element( 'heading', [
											'level' => 4,
											'class' => [ 'text-black', 'text-2xl', 'mt-0', 'mb-4', ],
											'text'  => $card_content_heading,
										] );
									endif;

									if ( ! empty( $card_content_paragraph ) ) :
										print_element( 'content', [
											'class'   => [ 'not-prose', 'text-black', 'text-base', 'mt-0', 'mb-4', 'xl:max-w-10/12', ],
											'content' => $card_content_paragraph,
										] );
									endif;

									if ( ! empty( $card_content_link ) ) :
										$card_content_link['class'] = [ 'text-black', 'text-base', 'mb-4', ];
										print_element( 'link', $card_content_link );
									endif;
									?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
					<?php
					// Buttons.
					if ( ! empty( $card_data['buttons'] ) ) :
						$buttons['class']                 = 'mt-8';
						$buttons['buttons_justification'] = $card_data['buttons_justification'];
						$buttons['buttons']               = $card_data['buttons'];

						print_module( 'buttons', $buttons );
					endif;
					?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
