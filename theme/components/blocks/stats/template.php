<?php

/**
 * BLOCK: Stats
 *
 * @link    https://developer.wordpress.org/block-editor/
 *
 * @param array        $block      The block settings and attributes.
 * @param array        $content    The block inner HTML (empty).
 * @param bool         $is_preview True during AJAX preview.
 * @param (int|string) $post_id    The post ID this block is saved to.
 */

use function BopTail\Helpers\get_acf_fields;
use function BopTail\Helpers\print_element;
use function BopTail\Blocks\setup_block_defaults;
use function BopTail\Blocks\print_background_options;

$block_args     = isset( $args ) ? $args : '';
$block_defaults = array(
	'id'                  => ! empty( $block['anchor'] ) ? $block['anchor'] : 'stats-' . $block['id'],
	'class'               => [ 'acf-block', 'block-stats', 'relative' ],
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
	'eyebrow',
	'heading',
	'content',
	'stats',
), $block['id'] );

// Extract animation class in case we want to apply to a single element.
$animation_class = $block_classes['animation'];

$container_class = join( ' ', array(
	'flex',
	'flex-col',
	'flex-wrap',
	'relative',
	$block_classes['container_size'],
) );
$column_class    = join( ' ', array(
	'stats-header',
	'relative',
	'pl-6',
	'lg:pl-10',
	$block_classes['align_text'],
	$block_classes['align_content'],
	$block_classes['inner_width'],
	$animation_class,
) );

if ( ! empty( $block['data']['_is_preview'] ) ) :
	?>
	<figure style="width: 100%;">
		<img src="<?php echo esc_url( get_theme_file_uri( '/components/blocks/stats/preview-stats.png' ) ); ?>"
		     style="width: 100%;height: 100%;object-fit: contain;object-position: center;" alt="<?php esc_html_e( 'Block Preview - Stats', BOPTAIL_TEXT_DOMAIN ); ?>">
	</figure>
<?php elseif ( ! empty( $block_content['stats'] ) ) :
	wp_enqueue_script_module( 'module-stats-front-script' );
	?>
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

				// Heading.
				if ( $block_content['heading'] ) :
					print_element( 'heading', [
						'level' => 1,
						'class' => [ $block_classes['heading_color'], 'mb-0', ],
						'text'  => $block_content['heading'],
					] );
				endif;

				// Content.
				if ( $block_content['content'] ) :
					print_element( 'content', [
						'class'   => [ $block_classes['content_color'], 'mb-8', ],
						'content' => $block_content['content'],
					] );
				endif;
				?>
			</div>
			<div class="basis-full">
				<div class="grid grid-cols-2 items-center gap-x-0 gap-y-10 lg:grid-cols-4 not-prose">
					<?php
					foreach ( $block_content['stats'] as $stat ) :
						$prefix        = $stat['prefix'];
						$stat_value    = $stat['stat_value'];
						$suffix        = $stat['suffix'];
						$description   = $stat['description'];
						$content_color = ! empty( $block_classes['content_color'] ) ? $block_classes['content_color'] : 'text-white';
					?>
						<div class="stat-item flex flex-col justify-between h-full font-bold px-6 border-l-6 border-light-blue <?php echo esc_attr( $content_color ); ?>">
							<div class="stat-wrapper text-5xl lg:text-[55px] leading-none">
								<?php printf( '<span class="prefix">%s</span><span class="stat" data-stat="%s">0</span><span class="suffix">%s</span>', $prefix, $stat_value, $suffix ); ?>
							</div>
							<p class="description text-base lg:text-xl leading-none mt-4"><?php echo $description; ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
