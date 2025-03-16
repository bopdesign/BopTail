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
use function BopTail\Helpers\print_element;
use function BopTail\Helpers\print_module;

$block_args     = isset( $args ) ? $args : '';
$block_defaults = array(
	'id'                  => ! empty( $block['anchor'] ) ? $block['anchor'] : 'hero-home-' . $block['id'],
	'class'               => [ 'acf-block', 'acf-block-body', 'hero-banner', 'hero-banner-home', 'relative' ],
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
	'flex-row',
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
				<?php
				// Eyebrow.
				if ( $block_content['eyebrow'] ) :
					print_element( 'eyebrow', [
						'class' => $block_classes['eyebrow_color'],
						'text'  => $block_content['eyebrow'],
					] );
				endif;
				?>
				<?php
				// Heading.
				if ( $block_content['heading'] ) :
					print_element( 'heading', [
						'level' => 1,
						'class' => [ $block_classes['heading_color'], 'mb-0',],
						'text'  => $block_content['heading'],
					] );
				endif;
				?>
				<?php
				// Content.
				if ( $block_content['content'] ) :
					print_element( 'content', [
						'class'   => [ $block_classes['content_color'], 'mb-8', ],
						'content' => $block_content['content'],
					] );
				endif;
				?>
				<?php
				// Buttons.
				if ( $block_content['buttons'] ) :
					$block_content['buttons']['class'] = 'mt-4';

					print_module( 'buttons', $block_content['buttons'] );
				endif;
				?>
			</div>
		</div>
	</section>
<?php endif; ?>
