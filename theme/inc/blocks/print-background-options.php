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
 * @author BopDesign
 *
 * @param array  $background_options Array of Background Options.
 *
 * @return string|void
 */
function print_background_options( $background_options ) {
	if ( empty( $background_options ) ) {
		return '';
	}

	/**
	 * Setup background defaults.
	 */
	$background_defaults = [
		'class' => 'acf-block position-relative overflow-hidden',
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

			$background_class = 'image-background d-block w-100 h-auto m-0 position-absolute top-0 bottom-0 start-0 end-0 z-0';

			ob_start();

			if ( ! empty( $background_image['fixed_background'] ) && $background_image['fixed_background'] ):
				$background_class .= ' bg-fixed bg-cover';
				$background_image_url = wp_get_attachment_image_url( $background_image_id, $background_image_size );

				if ( ! empty( $background_image['background_position'] ) && $background_image['background_position'] ) {
					$background_class .= ' bg-' . $background_image['background_position'];
				}
				?>
				<figure class="<?php echo esc_attr( $background_class ); ?>" style="background-image:url(<?php echo $background_image_url; ?>);" aria-hidden="true"></figure>
			<?php else:
				$image_class = 'w-100 h-100 object-cover';

				if ( ! empty( $background_image['background_position'] ) && $background_image['background_position'] ) {
					$image_class .= ' object-' . $background_image['background_position'];
				}
				?>
				<figure class="<?php echo esc_attr( $background_class ); ?>" aria-hidden="true">
					<?php echo wp_get_attachment_image( $background_image_id, $background_image_size, false, array( 'class' => $image_class ) ); ?>
				</figure>
			<?php endif; ?>
			<?php
			$background_image_markup = ob_get_clean();
		}

		if ( 'video' === $background_options['background_type'] && ! empty( $background_options['background_video_mp4'] ) ) {
			$background_video = $background_options['background_video_mp4'];
			// Make sure videos stay in their containers - relative + overflow hidden.
			$background_defaults['class'] .= ' has-background video-as-background position-relative overflow-hidden';

			ob_start();
			?>
			<figure class="video-background d-block h-auto w-100 m-0 position-absolute top-0 bottom-0 start-0 end-0 object-top z-0" aria-hidden="true">
				<video id="<?php echo esc_attr( $background_options['id'] ); ?>-video" autoplay muted playsinline loop preload="none">
					<?php if ( $background_video['url'] ) : ?>
						<source src="<?php echo esc_url( $background_video['url'] ); ?>" type="video/mp4">
					<?php endif; ?>
				</video>
			</figure>
			<?php
			$background_video_markup = ob_get_clean();
		}

		if ( ( 'image' === $background_options['background_type'] || 'video' === $background_options['background_type'] ) && $background_options['background_add_overlay'] ) {
			$overlay_settings = $background_options['background_overlay'];
			$overlay_class    = 'position-absolute z-1 has-background-dim';

			if ( 'color' === $overlay_settings['overlay_type'] ) {
				$overlay_color = $overlay_settings['overlay_color']['color_picker'];

				if ( '' !== $overlay_color ) {
					$overlay_class .= ' has-' . esc_attr( $overlay_color ) . '-background-color';
				}
			}

			if ( 'gradient' === $overlay_settings['overlay_type'] ) {
				$overlay_gradient = $overlay_settings['overlay_gradient']['gradient_picker'];

				if ( '' !== $overlay_gradient ) {
					$overlay_class .= ' has-' . esc_attr( $overlay_gradient ) . '-background-gradient';
				}
			}

			if ( ! empty( $background_options['overlay_opacity'] ) && is_numeric( $background_options['overlay_opacity'] ) ) {
				$overlay_class .= ' has-background-dim-' . esc_attr( $background_options['overlay_opacity'] );
			}

			ob_start();
			?>
			<span class="<?php esc_attr_e( $overlay_class ); ?>" aria-hidden="true"></span>
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
