<?php

/**
 * Returns an array of block settings.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

/**
 * Maps ACF field values to block settings structure
 *
 * @param array $block Array of block attributes.
 * @return array The mapped settings array.
 */
function get_block_settings($block)
{
	// Get block default settings
	$default_settings = get_default_block_settings();
	$settings = [];

	// Map Gutenberg settings
	if (! empty($block)) {
		// Get block align setting: none, wide, full.
		if (! empty($block['align'])) {
			$settings['align'] = $block['align'];
		} elseif (empty($block['align']) || '' === $block['align']) {
			$settings['align'] = 'none';
		}

		// Get content alignment setting
		if (! empty($block['align_content'])) {
			$settings['align_content'] = $block['align_content'];
		}

		// Get text alignment setting
		if (! empty($block['align_text'])) {
			$settings['align_text'] = $block['align_text'];
		}

		// Get block 'Full Height' setting
		$settings['full_height'] = ! empty($block['fullHeight']) && $block['fullHeight'];
	}

	// Background settings
	$settings['background'] = [
		'type'  => get_field('background_type'),
		'fixed' => get_field('background_fixed'),
	];

	// Map background settings based on type
	switch ($settings['background']['type']) {
		case 'color':
			$settings['background']['color'] = get_field('background_color');
			break;
		case 'gradient':
			$settings['background']['gradient'] = get_field('background_gradient');
			break;
		case 'image':
			$settings['background']['image'] = get_field('background_image');
			break;
		case 'video':
			$settings['background']['video'] = get_field('background_video');
			break;
	}

	// Background overlay
	if (get_field('background_add_overlay')) {
		$settings['background']['overlay'] = get_field('background_overlay');
	}

	// Background pattern
	if (get_field('background_add_pattern')) {
		$settings['background']['pattern'] = get_field('background_pattern');
	}

	// Typography settings
	$settings['typography'] = [
		'eyebrow_color' => get_field('eyebrow_color'),
		'heading_color' => get_field('heading_color'),
		'content_color' => get_field('content_color'),
	];

	// Container settings
	$settings['container'] = [
		'size'        => get_field('container_size'),
		'inner_width' => get_field('inner_width'),
	];

	// Animation
	$settings['animation'] = get_field('animation');

	// Spacing settings
	$settings['spacing'] = [
		'margin' => [
			'top'    => get_field('margin_top'),
			'bottom' => get_field('margin_bottom'),
		],
		'padding' => [
			'top'    => get_field('padding_top'),
			'bottom' => get_field('padding_bottom'),
		],
	];

	// Merge with defaults, ensuring all expected keys exist
	$settings = wp_parse_args($settings, $default_settings);

	return $settings;
}
