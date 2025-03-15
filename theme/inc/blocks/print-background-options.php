<?php

/**
 * Render block background options.
 */

namespace BopTail\Blocks;

use function BopTail\Functions\echo_data;

/**
 * Render a module.
 *
 * @param array $background_options Array of Background Options.
 *
 * @return string|void
 */
function print_background_options( $settings ) {
	if ( empty( $settings ) && empty( $settings['background'] ) ) {
		return '';
	}

	$background_options = $settings['background'];

	/**
	 * Setup background defaults.
	 */
	$background_image_markup = $background_video_markup = $background_overlay_markup = '';

	// Only try to get the rest of the settings if the background type is set to anything.
	if ( $background_options['type'] ) {
		if ( 'image' === $background_options['type'] ) {
			$background_image      = $background_options['image'];

			if ( ! empty( $background_image['use_featured_image'] ) && $background_image['use_featured_image'] && has_post_thumbnail() ) {
				$background_image_id = get_post_thumbnail_id();
			} elseif ( ! empty( $background_image['image'] ) ) {
				$background_image_id = $background_image['image']['ID'];
			} else {
				return '';
			}

			if ( empty( $background_image_id ) ) {
				return '';
			}

			$background_image_size = 'full';
			$background_classes = [
				'background-image',
				'block',
				'm-0',
				'absolute',
				'inset-0',
				'w-full',
				'h-full',
				'z-0',
			];

			ob_start();

			if ( ! empty( $background_options['fixed'] ) && $background_options['fixed'] ) :
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
				<div class="<?php echo esc_attr( $background_class ); ?>"
				     style="background-image:url(<?php echo $background_image_url; ?>);" aria-hidden="true"></div>
			<?php
			else :
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

		if ( 'video' === $background_options['type'] ) {
			$background_video   = $background_options['video'];
			$background_classes = [
				'background-video',
				'not-prose',
				'block',
				'overflow-hidden',
				'absolute',
				'inset-0',
				'w-full',
				'h-full',
				'z-0',
			];

			if ( ! empty( $background_options['fixed'] ) ) {
				$background_classes[] = 'bg-fixed';
			}

			$background_class = implode( ' ', $background_classes );

			ob_start();
			?>
			<div class="<?php echo esc_attr( $background_class ); ?>" aria-hidden="true">
				<?php
				switch ( $background_video['video_type'] ) {
					case 'file':
						$video_id = uniqid( 'bop-tail-video-' );
						if ( empty( $background_video['video_mp4'] ) && empty( $background_video['video_mp4'] ) ) {
							error_log( 'Background Options: No video selected.' );
							break;
						}
						?>
						<video id="<?php echo esc_attr( $video_id ); ?>" class="object-cover object-center m-0 w-full h-full"
						       autoplay muted playsinline loop preload="none"
							<?php if ( ! empty( $background_video['video_placeholder'] ) ) : ?>
								poster="<?php echo esc_url( wp_get_attachment_image_url( $background_video['video_placeholder'], 'full' ) ); ?>"
							<?php endif; ?>>
							<?php if ( ! empty( $background_video['video_mp4'] ) ) : ?>
								<source src="<?php echo esc_url( $background_video['video_mp4'] ); ?>" type="video/mp4">
							<?php endif; ?>
							<?php if ( ! empty( $background_video['video_webm'] ) ) : ?>
								<source src="<?php echo esc_url( $background_video['video_webm'] ); ?>"
								        type="video/webm">
							<?php endif; ?>
						</video>
						<?php
						break;

					case 'embed':
						if ( ! empty( $background_video['video_embed'] ) ) {
							echo wp_oembed_get( $background_video['video_embed'], array(
								'autoplay' => 1,
								'controls' => 0,
								'mute'     => 1,
								'loop'     => 1,
							) );
						}
						break;

					case 'script':
						if ( ! empty( $background_video['video_script'] ) ) {
							echo wp_kses_post( $background_video['video_script'] );
						}
						break;
				}
				?>
			</div>
			<?php
			$background_video_markup = ob_get_clean();
		}

		if ( ( 'image' === $background_options['type'] || 'video' === $background_options['type'] ) && ! empty( $background_options['overlay'] ) ) {
			$overlay_settings = $background_options['overlay'];
			$overlay_classes  = array(
				'absolute',
				'inset-0',
				'w-full',
				'h-auto',
				'z-10',
			);

			if ( 'color' === $overlay_settings['overlay_type'] ) {
				$overlay_color = $overlay_settings['overlay_color']['color_picker'];

				if ( '' !== $overlay_color ) {
					$overlay_classes[] = 'has-' . $overlay_color . '-background-color';
					$overlay_classes[] = 'bg-' . $overlay_color;;
				}
			}

			if ( 'gradient' === $overlay_settings['overlay_type'] ) {
//				$overlay_gradient = $overlay_settings['overlay_gradient']['gradient_picker'];
//
//				if ( '' !== $overlay_gradient ) {
//					$overlay_classes[] = 'has-' . $overlay_gradient . '-background-gradient';
//					$overlay_classes[] = "bg-$overlay_gradient";
//				}

				// Generated class example: bg-linear-0 from-color-aaa via-color-bbb to-color-ccc
				// Angles: bg-linear-45 | bg-linear-90 | bg-linear-180
				$gradient_angle = $overlay_settings['overlay_gradient']['angle'] ?? '90';
				$overlay_classes[]  = 'bg-linear-' . $gradient_angle;

				// Example: from-background | from-foreground | from-primary | from-secondary | from-tertiary | from-white | from-black
				if ( ! empty( $overlay_settings['overlay_gradient']['start_color']['color_picker'] ) ) {
					$overlay_classes[] = 'from-' . $overlay_settings['overlay_gradient']['start_color']['color_picker'];
				}
				// Example: via-background | via-foreground | via-primary | via-secondary | via-tertiary | via-white | via-black
				if ( ! empty( $overlay_settings['overlay_gradient']['via_color']['color_picker'] ) ) {
					$overlay_classes[] = 'via-' . $overlay_settings['overlay_gradient']['via_color']['color_picker'];
				}
				// Example: to-background | to-foreground | to-primary | to-secondary | to-tertiary | to-white | to-black
				if ( ! empty( $overlay_settings['overlay_gradient']['end_color']['color_picker'] ) ) {
					$overlay_classes[] = 'to-' . $overlay_settings['overlay_gradient']['end_color']['color_picker'];
				}
			}

			if ( ! empty( $overlay_settings['overlay_opacity'] ) && is_numeric( $overlay_settings['overlay_opacity'] ) ) {
				// We don't use 0 and 100 values. as these mean that overlay is either black or there is none,
				// which should be utilized via overlay settings.
				switch ( $overlay_settings['overlay_opacity'] ) {
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
					case 50:
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
