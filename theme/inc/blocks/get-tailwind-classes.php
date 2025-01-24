<?php

/**
 * Convert settings to Tailwind classes
 *
 * @param array $settings Block settings
 *
 * @return array Array of Tailwind classes
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

function get_tailwind_classes( $settings ) {
	$classes = [];

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
				$classes['align_content'] = 'align-start justify-start is-position-' . sanitize_title( $align_content );
				break;
			case 'top center':
				$classes['align_content'] = 'align-start justify-center is-position-' . sanitize_title( $align_content );
				break;
			case 'top right':
				$classes['align_content'] = 'align-start justify-end is-position-' . sanitize_title( $align_content );
				break;
			case 'center left':
				$classes['align_content'] = 'align-center justify-start is-position-' . sanitize_title( $align_content );
				break;
			case 'center center':
				$classes['align_content'] = 'align-center justify-center is-position-' . sanitize_title( $align_content );
				break;
			case 'center right':
				$classes['align_content'] = 'align-center justify-end is-position-' . sanitize_title( $align_content );
				break;
			case 'bottom left':
				$classes['align_content'] = 'align-end justify-start is-position-' . sanitize_title( $align_content );
				break;
			case 'bottom center':
				$classes['align_content'] = 'align-end justify-center is-position-' . sanitize_title( $align_content );
				break;
			case 'bottom right':
				$classes['align_content'] = 'align-end justify-end is-position-' . sanitize_title( $align_content );
				break;
			default:
				$classes['align_content'] = 'align-start justify-start is-position-top-left';
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
	if ( ! empty( $settings['background'] ) ) {
		$bg = $settings['background'];

		switch ( $bg['type'] ) {
			case 'color':
				if ( ! empty( $bg['color_picker'] ) ) {
					$bg_color = $bg['color_picker'];
					$classes[] = 'has-' . $bg_color . '-background-color';
					$classes[] = 'bg-' . $bg_color;
				}
				break;
			case 'gradient':
				if ( ! empty( $bg['gradient'] ) ) {
					// Example: bg-gradient-to-r from-blue-500 to-purple-500
					$gradient_direction = $bg['gradient']['direction'] ?? 'to-r';
					$classes[] = 'bg-gradient-' . $gradient_direction;

					if ( ! empty( $bg['gradient']['start_color'] ) ) {
						$classes[] = 'from-' . $bg['gradient']['start_color'];
					}
					if ( ! empty( $bg['gradient']['end_color'] ) ) {
						$classes[] = 'to-' . $bg['gradient']['end_color'];
					}
				}
				break;
			case 'image':
				$classes[] = 'has-background image-as-background relative overflow-hidden';

				if ( ! empty( $bg['fixed'] ) && $bg['fixed'] ) {
					$classes[] = 'has-fixed-background';
				}
				break;
			case 'video':
				$classes[] = 'has-background video-as-background relative overflow-hidden';

				if ( ! empty( $bg['fixed'] ) && $bg['fixed'] ) {
					$classes[] = 'has-fixed-background';
				}
				break;
		}

		// Overlay
		if ( ! empty( $bg['overlay'] ) && ( $bg['type'] === 'image' || $bg['type'] === 'video' ) ) {
			if ( ! empty( $bg['overlay']['color'] ) ) {
				$classes[] = 'overlay-' . $bg['overlay']['color'];
			}
			if ( ! empty( $bg['overlay']['opacity'] ) ) {
				$classes[] = 'overlay-opacity-' . $bg['overlay']['opacity'];
			}
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
	}

	// Typography classes
	if ( ! empty( $settings['typography'] ) ) {
		if ( ! empty( $settings['typography']['eyebrow_color'] ) ) {
			$classes[] = 'eyebrow-' . $settings['typography']['eyebrow_color']['color_picker'];
		}
		if ( ! empty( $settings['typography']['heading_color'] ) ) {
			$classes[] = 'heading-' . $settings['typography']['heading_color']['color_picker'];
		}
		if ( ! empty( $settings['typography']['content_color'] ) ) {
			$classes[] = 'text-' . $settings['typography']['content_color']['color_picker'];
		}
	}

	// Container classes
	if ( ! empty( $settings['container'] ) ) {
		// Container size
		if ( ! empty( $settings['container']['size'] ) ) {
			$classes['container_size'] = $settings['container']['size'];
		}

		// Inner content width
		if ( ! empty( $settings['container']['inner_width'] ) ) {
			$width_map = [ 
				'auto' => 'col-auto',                      // auto
				'3' => 'col-span-12 md:col-span-3',     // 25%
				'4' => 'col-span-12 md:col-span-4',     // 33%
				'5' => 'col-span-12 md:col-span-5',     // 42%
				'6' => 'col-span-12 md:col-span-6',     // 50%
				'7' => 'col-span-12 md:col-span-7',     // 58%
				'8' => 'col-span-12 md:col-span-8',     // 66%
				'9' => 'col-span-12 md:col-span-9',     // 75%
				'10' => 'col-span-12 md:col-span-10',    // 83%
				'11' => 'col-span-12 md:col-span-11',    // 92%
			];
			$classes['inner_width'] = $width_map[ $settings['container']['inner_width'] ] ?? 'col-span-full';
		}
	}

	// Animation classes
	$classes['animation'] = '';
	if ( ! empty( $settings['animation'] ) && $settings['animation'] !== 'none' ) {
		$classes['animation'] = 'wow animate__' . $settings['animation'];
	}

	// Spacing classes
	$spacing_map = [ 
		'none' => '0',    // mb-0, mt-0, pt-0, pb-0
		'tiny' => '2',    // mb-2, mt-2, pt-2, pb-2
		'small' => '4',    // mb-4, mt-4, pt-4, pb-4
		'medium' => '8',    // mb-8, mt-8, pt-8, pb-8
		'large' => '12',   // mb-12, mt-12, pt-12, pb-12
		'x-large' => '16',   // mb-16, mt-16, pt-16, pb-16
	];

	if ( ! empty( $settings['spacing'] ) ) {
		// Margins
		if ( ! empty( $settings['spacing']['margin'] ) ) {
			$margin = $settings['spacing']['margin'];
			if ( ! empty( $margin['top'] ) && $margin['top'] !== 'none' ) {
				$classes[] = 'mt-' . $spacing_map[ $margin['top'] ];
			}
			if ( ! empty( $margin['bottom'] ) && $margin['bottom'] !== 'none' ) {
				$classes[] = 'mb-' . $spacing_map[ $margin['bottom'] ];
			}
		}

		// Padding
		if ( ! empty( $settings['spacing']['padding'] ) ) {
			$padding = $settings['spacing']['padding'];
			if ( ! empty( $padding['top'] ) && $padding['top'] !== 'none' ) {
				$classes[] = 'pt-' . $spacing_map[ $padding['top'] ];
			}
			if ( ! empty( $padding['bottom'] ) && $padding['bottom'] !== 'none' ) {
				$classes[] = 'pb-' . $spacing_map[ $padding['bottom'] ];
			}
		}
	}

	return array_unique( $classes );
}
