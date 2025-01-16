<?php
/**
 * Render block background options.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

/**
 * Render a module.
 *
 * @param array $background_options Array of Background Options.
 *
 * @return string|void
 * @author BopDesign
 *
 */
function print_background_options( $background_options ) {
	if ( empty( $background_options ) ) {
		return '';
	}

	/**
	 * Setup background defaults.
	 */
	$background_defaults = [
		'class' => 'acf-block relative overflow-hidden',
	];

	$background_video_markup = $background_image_markup = $background_overlay_markup = '';

	// Only try to get the rest of the settings if the background type is set to anything.
	if ( $background_options['background_type'] ) {
		if ( 'image' === $background_options['background_type'] ) {
			$background_image      = $background_options['background_image'];
			$background_image_id   = false;
			$background_image_size = 'full';

			if ( ! empty( $background_image['background_use_featured_image'] ) && $background_image['background_use_featured_image'] && has_post_thumbnail() ) {
				$background_image_id = get_post_thumbnail_id();
			} elseif ( ! empty( $background_image['image'] ) ) {
				$background_image_id = $background_image['image']['ID'];
			}

			$background_classes = [
				'block',
				'm-0',
				'absolute',
				'top-0',
				'bottom-0',
				'start-0',
				'end-0',
				'w-full',
				'h-auto',
				'z-0',
			];

			ob_start();

			if ( ! empty( $background_image['fixed_background'] ) && $background_image['fixed_background'] ):
				array_push( $background_classes, 'bg-fixed', 'bg-cover' );
				$background_image_url = wp_get_attachment_image_url( $background_image_id, $background_image_size );

				if ( ! empty( $background_image['background_position'] ) ) {
					switch ( $background_image['background_position'] ) {
						case 'left':
							$background_classes[] = 'bg-left';
							break;
						case 'left-top':
							$background_classes[] = 'bg-left-top';
							break;
						case 'left-bottom':
							$background_classes[] = 'bg-left-bottom';
							break;
						case 'top':
							$background_classes[] = 'bg-top';
							break;
						case 'bottom':
							$background_classes[] = 'bg-bottom';
							break;
						case 'right':
							$background_classes[] = 'bg-right';
							break;
						case 'right-top':
							$background_classes[] = 'bg-right-top';
							break;
						case 'right-bottom':
							$background_classes[] = 'bg-right-bottom';
							break;
						case 'center':
						default:
							$background_classes[] = 'bg-center';
							break;
					}
				}
				$background_class = implode( ' ', $background_classes );
				?>
				<div class="<?php echo esc_attr( $background_class ); ?>" style="background-image:url(<?php echo $background_image_url; ?>);" aria-hidden="true"></div>
			<?php else:
				$image_classes = [
					'object-cover',
					'w-full',
					'h-full',
				];

				if ( ! empty( $background_image['background_position'] ) ) {
					switch ( $background_image['background_position'] ) {
						case 'left':
							$image_classes[] = 'object-left';
							break;
						case 'left-top':
							$image_classes[] = 'object-left-top';
							break;
						case 'left-bottom':
							$image_classes[] = 'object-left-bottom';
							break;
						case 'top':
							$image_classes[] = 'object-top';
							break;
						case 'bottom':
							$image_classes[] = 'object-bottom';
							break;
						case 'right':
							$image_classes[] = 'object-right';
							break;
						case 'right-top':
							$image_classes[] = 'object-right-top';
							break;
						case 'right-bottom':
							$image_classes[] = 'object-right-bottom';
							break;
						case 'center':
						default:
							$image_classes[] = 'object-center';
							break;
					}
				}

				$background_class = implode( ' ', $background_classes );
				$image_class      = implode( ' ', $image_classes );
				?>
				<picture class="<?php echo esc_attr( $background_class ); ?>" aria-hidden="true">
					<?php echo wp_get_attachment_image( $background_image_id, $background_image_size, false, array( 'class' => esc_attr( $image_class ) ) ); ?>
				</picture>
			<?php endif; ?>
			<?php
			$background_image_markup = ob_get_clean();
		}

		if ( 'video' === $background_options['background_type'] && ! empty( $background_options['background_video_mp4'] ) ) {
			$background_video = $background_options['background_video_mp4'];
			// Make sure videos stay in their containers - relative + overflow hidden.
			$background_defaults['class'] .= ' has-background video-as-background relative overflow-hidden';

			ob_start();
			?>
			<div class="background-video block h-auto w-full m-0 absolute top-0 bottom-0 start-0 end-0 object-top z-0" aria-hidden="true">
				<video id="<?php echo esc_attr( $background_options['id'] ); ?>-video" autoplay muted playsinline loop preload="none">
					<?php if ( ! empty( $background_video['url'] ) ) : ?>
						<source src="<?php echo esc_url( $background_video['url'] ); ?>" type="video/mp4">
					<?php endif; ?>
				</video>
			</div>
			<?php
			$background_video_markup = ob_get_clean();
		}

		if ( ( 'image' === $background_options['background_type'] || 'video' === $background_options['background_type'] ) && $background_options['background_add_overlay'] ) {
			$overlay_settings = $background_options['background_overlay'];
			$overlay_classes  = [
				'absolute',
				' z-1',
			];

			if ( 'color' === $overlay_settings['overlay_type'] ) {
				$overlay_color = $overlay_settings['overlay_color']['color_picker'];

				if ( '' !== $overlay_color ) {
					$overlay_classes[] = ' has-' . esc_attr( $overlay_color ) . '-background-color bg-' . esc_attr( $overlay_color );
				}
			}

			if ( 'gradient' === $overlay_settings['overlay_type'] ) {
				$overlay_gradient = $overlay_settings['overlay_gradient']['gradient_picker'];

				if ( '' !== $overlay_gradient ) {
					$overlay_classes[] = ' has-' . esc_attr( $overlay_gradient ) . '-background-gradient';
				}
			}

			if ( ! empty( $background_options['overlay_opacity'] ) && is_numeric( $background_options['overlay_opacity'] ) ) {
				// We don't use 0 and 100 values. as these mean that overlay is either black or there is none,
				// which should be utilized via overlay settings.
				switch ( $background_options['overlay_opacity'] ) {
					case 10:
						$overlay_classes[] = 'opacity-10';
						break;
					case 20:
						$overlay_classes[] = 'opacity-20';
						break;
					case 30:
						$overlay_classes[] = 'opacity-30';
						break;
					case 40:
						$overlay_classes[] = 'opacity-40';
						break;
					case 60:
						$overlay_classes[] = 'opacity-60';
						break;
					case 70:
						$overlay_classes[] = 'opacity-70';
						break;
					case 80:
						$overlay_classes[] = 'opacity-80';
						break;
					case 90:
						$overlay_classes[] = 'opacity-90';
						break;
					case '50':
					default:
						$overlay_classes[] = 'opacity-50';
						break;
				}
			}

			$overlay_class = implode( ' ', $overlay_classes );

			ob_start();
			?>
			<div class="<?php echo esc_attr( $overlay_class ); ?>" aria-hidden="true"></div>
			<?php
			$background_overlay_markup = ob_get_clean();
		}
	}

	// If we have a background image, echo our background image markup inside the block container.
	if ( $background_image_markup ) {
		echo $background_image_markup; // WPCS XSS OK.
	}

	// If we have a background video, echo our background video markup inside the block container.
	if ( $background_video_markup ) {
		echo $background_video_markup; // WPCS XSS OK.
	}

	// If we have an overlay, echo our overlay markup inside the block container.
	if ( $background_overlay_markup ) {
		echo $background_overlay_markup; // WPCS XSS OK.
	}
}
