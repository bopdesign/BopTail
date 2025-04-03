<?php

/**
 * Convert settings to Tailwind classes
 *
 * @param array $settings Block settings
 *
 * @return array Array of Tailwind classes
 */

namespace BopTail\Blocks;

function get_tailwind_classes( $settings ) {
	// Gutenberg classes.
	if ( empty( $settings['align'] ) || 'none' === $settings['align'] ) {
		$classes['align'] = 'alignnone';
	} else {
		$classes['align'] = 'align' . $settings['align'];
	}

	// Content alignment.
	if ( ! empty( $settings['align_content'] ) ) {
		$align_content = $settings['align_content'];

		switch ( $align_content ) {
			case 'top':
				$classes['align_content'] = 'self-start is-position-' . sanitize_title( $align_content );
				break;
			case 'center':
				$classes['align_content'] = 'self-center is-position-' . sanitize_title( $align_content );
				break;
			case 'bottom':
				$classes['align_content'] = 'self-end is-position-' . sanitize_title( $align_content );
				break;
			case 'top left':
				$classes['align_content'] = 'items-start justify-start is-position-' . sanitize_title( $align_content );
				break;
			case 'top center':
				$classes['align_content'] = 'items-start justify-center is-position-' . sanitize_title( $align_content );
				break;
			case 'top right':
				$classes['align_content'] = 'items-start justify-end is-position-' . sanitize_title( $align_content );
				break;
			case 'center left':
				$classes['align_content'] = 'items-center justify-start is-position-' . sanitize_title( $align_content );
				break;
			case 'center center':
				$classes['align_content'] = 'items-center justify-center is-position-' . sanitize_title( $align_content );
				break;
			case 'center right':
				$classes['align_content'] = 'items-center justify-end is-position-' . sanitize_title( $align_content );
				break;
			case 'bottom left':
				$classes['align_content'] = 'items-end justify-start is-position-' . sanitize_title( $align_content );
				break;
			case 'bottom center':
				$classes['align_content'] = 'items-end justify-center is-position-' . sanitize_title( $align_content );
				break;
			case 'bottom right':
				$classes['align_content'] = 'items-end justify-end is-position-' . sanitize_title( $align_content );
				break;
			default:
				$classes['align_content'] = 'items-start justify-start is-position-top-left';
				break;
		}
	}

	// Text alignment.
	if ( ! empty( $settings['align_text'] ) ) {
		switch ( $settings['align_text'] ) {
			case 'center':
				$classes['align_text'] = 'text-center';
				break;
			case 'right':
				$classes['align_text'] = 'text-right';
				break;
			case 'left':
			default:
				$classes['align_text'] = 'text-left';
				break;
		}
	}

	// Is full height.
	$classes['full_height'] = '';
	if ( ! empty( $settings['full_height'] ) && $settings['full_height'] ) {
		$classes['full_height'] = 'h-screen';
	}

	// Background classes.
	$classes['background'] = '';

	if ( ! empty( $settings['background'] ) && ! empty( $settings['background']['type'] && 'none' !== $settings['background']['type'] ) ) {
		$bg           = $settings['background'];
		$bg_classes[] = 'has-background';

		switch ( $bg['type'] ) {
			case 'color':
				// Background Colors: bg-background | bg-foreground | bg-primary | bg-secondary
				if ( ! empty( $bg['color']['color_picker'] ) ) {
					$bg_classes[] = 'color-as-background';
					$bg_classes[] = 'has-' . $bg['color']['color_picker'] . '-background-color';
					$bg_classes[] = 'bg-' . $bg['color']['color_picker'];
				}
				break;
			case 'gradient':
				if ( ! empty( $bg['gradient'] ) ) {
					$bg_classes[] = 'gradient-as-background';

					// Example: bg-linear-0 from-color-aaa via-color-bbb to-color-ccc
					// Angles: bg-linear-45 | bg-linear-90 | bg-linear-180
					$gradient_angle = $bg['gradient']['angle'] ?? '90';
					$bg_classes[]   = 'bg-linear-' . $gradient_angle;

					if ( ! empty( $bg['gradient']['start_color'] ) ) {
						$bg_classes[] = 'from-' . $bg['gradient']['start_color']['color_picker'];
					}
					if ( ! empty( $bg['gradient']['via_color'] ) ) {
						$bg_classes[] = 'via-' . $bg['gradient']['via_color']['color_picker'];
					}
					if ( ! empty( $bg['gradient']['end_color'] ) ) {
						$bg_classes[] = 'to-' . $bg['gradient']['end_color']['color_picker'];
					} else {
						$bg_classes[] = 'to-transparent';
					}
				}
				break;
			case 'image':
				$bg_classes[] = 'image-as-background overflow-hidden';

				if ( ! empty( $bg['fixed'] ) && $bg['fixed'] ) {
					$bg_classes[] = 'has-fixed-background';
				}
				break;
			case 'video':
				$bg_classes[] = 'video-as-background overflow-hidden';
				break;
		}

		// Overlay
		if ( ( 'image' === $bg['type'] || 'video' === $bg['type'] ) && ! empty( $bg['overlay'] ) ) {
			$bg_classes[] = 'has-overlay';
			$bg_classes[] = 'has-overlay-' . $bg['overlay']['overlay_type'];
		}

		// Pattern
		if ( ! empty( $bg['pattern'] ) ) {
			if ( ! empty( $bg['pattern']['type'] ) ) {
				$classes[] = 'pattern-' . $bg['pattern']['type'];
			}
			if ( ! empty( $bg['pattern']['color'] ) ) {
				$classes[] = 'pattern-' . $bg['pattern']['color'];
			}
			if ( ! empty( $bg['pattern']['opacity'] ) ) {
				$classes[] = 'pattern-opacity-' . $bg['pattern']['opacity'];
			}
		}

		$classes['background'] = join( ' ', $bg_classes );
	}

	// Typography classes
	// Text Colors: text-background | text-foreground | text-primary | text-secondary
	$classes['eyebrow_color'] = '';
	$classes['heading_color'] = '';
	$classes['content_color'] = '';

	if ( ! empty( $settings['typography'] ) ) {
		if ( ! empty( $settings['typography']['eyebrow_color'] ) ) {
			$classes['eyebrow_color'] = 'text-' . $settings['typography']['eyebrow_color']['color_picker'];
		}
		if ( ! empty( $settings['typography']['heading_color'] ) ) {
			$classes['heading_color'] = 'text-' . $settings['typography']['heading_color']['color_picker'];
		}
		if ( ! empty( $settings['typography']['content_color'] ) ) {
			$classes['content_color'] = 'text-' . $settings['typography']['content_color']['color_picker'];
		}
	}

	// Container classes
	if ( ! empty( $settings['container'] ) ) {
		// Container size
		if ( ! empty( $settings['container']['size'] ) ) {
			switch ( $settings['container']['size'] ) {
				case 'contained':
					$classes['container_size'] = 'container';
					break;
				case 'full':
					$classes['container_size'] = 'container-full px-4 lg:px-8';
					break;
			}
		}

		// Inner content width
		if ( ! empty( $settings['container']['inner_width'] ) ) {
			$width_map              = [
				'auto' => 'basis-auto',                // auto
				'3'    => 'basis-full md:basis-3/12',  // 25%
				'4'    => 'basis-full md:basis-4/12',  // 33%
				'5'    => 'basis-full md:basis-5/12',  // 42%
				'6'    => 'basis-full md:basis-6/12',  // 50%
				'7'    => 'basis-full md:basis-7/12',  // 58%
				'8'    => 'basis-full md:basis-8/12',  // 66%
				'9'    => 'basis-full md:basis-9/12',  // 75%
				'10'   => 'basis-full md:basis-10/12', // 83%
				'11'   => 'basis-full md:basis-11/12', // 92%
			];
			$classes['inner_width'] = $width_map[ $settings['container']['inner_width'] ] ?? 'basis-full';
		}
	}

	// Animation classes
	$classes['animation'] = '';

	if ( ! empty( $settings['animation'] ) && 'none' !== $settings['animation'] ) {
		$classes['animation'] = 'wow animate__' . $settings['animation'];
	}

	// Spacing classes
	$spacing_map        = array(
		'none'    => '0',    // mb-0 | mt-0 | pt-0 | pb-0
		'tiny'    => '8',    // mb-8 | mt-8 | pt-8 | pb-8
		'small'   => '16',   // mb-16 | mt-16 | pt-16 | pb-16
		'medium'  => '32',   // mb-32 | mt-32 | pt-32 | pb-32
		'large'   => '48',   // mb-48 | mt-48 | pt-48 | pb-48
		'x-large' => '64',   // mb-64 | mt-64 | pt-64 | pb-64
	);
	$classes['spacing'] = array();

	if ( ! empty( $settings['spacing'] ) ) {
		// Margins
		if ( ! empty( $settings['spacing']['margin'] ) ) {
			$margin = $settings['spacing']['margin'];
			if ( ! empty( $margin['top'] ) && $margin['top'] !== 'none' ) {
				$classes['spacing'][] = 'mt-' . $spacing_map[ $margin['top'] ];
			}
			if ( ! empty( $margin['bottom'] ) && $margin['bottom'] !== 'none' ) {
				$classes['spacing'][] = 'mb-' . $spacing_map[ $margin['bottom'] ];
			}
		}

		// Padding
		if ( ! empty( $settings['spacing']['padding'] ) ) {
			$padding = $settings['spacing']['padding'];
			if ( ! empty( $padding['top'] ) && $padding['top'] !== 'none' ) {
				$classes['spacing'][] = 'pt-' . $spacing_map[ $padding['top'] ];
			}
			if ( ! empty( $padding['bottom'] ) && $padding['bottom'] !== 'none' ) {
				$classes['spacing'][] = 'pb-' . $spacing_map[ $padding['bottom'] ];
			}
		}

		$classes['spacing'] = join( ' ', $classes['spacing'] );
	}

	/*
	 * These are top level classes applied to the block container, i.e.:
	 * <section id="block-xyz" class="<block_classes>">.
	*/
	$classes['block_classes'] = join( ' ', array(
		$classes['align'],
		$classes['full_height'],
		$classes['background'],
		$classes['spacing'],
	), );

	return $classes;
}
