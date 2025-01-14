<?php
/**
 * Returns an array of block settings.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

/**
 * Returns an array of supported settings.
 *
 * @param string $settings_type String of block settings to get. Returns all if none has been provided.
 *                              Supported values are: all | gutenberg | acf | background | other
 *
 * @return array The array of supported settings.
 */
function get_supported_settings( $settings_type = 'all' ) {
	// List of the supported Gutenberg Settings.
	$supported_gutenberg_settings = [
		'align'         => 'full',          // none | wide | full
		'align_text'    => 'left',          // left | center | right
		'align_content' => 'top left',      // (top | center | bottom) (left | center | right)
		'full_height'   => false,           // false | true
	];

	// List of the supported ACF background settings.
	$supported_acf_background_settings = [
		'background_type'        => 'none',     // none | color | gradient | image | video
		'background_color'       => false,      // false | string (theme color)
		'background_gradient'    => false,      // false | string (theme gradient)
		'background_image'       => false,      // false | array()
		'background_video'       => false,      // false | array()
		'background_add_overlay' => false,      // false | true
		'background_overlay'     => false,      // false | string (color | gradient)
		'background_add_pattern' => false,      // false | string (theme gradient)
		'background_pattern'     => false,      // false | string (theme gradient)
		'background_opacity'     => false,      // false | 10-100 (step size of 10)
	];

	// List of the supported ACF Settings.
	$supported_acf_other_settings = [
		'animation'           => 'none',         // none | animate.css classes (fadeIn | slideIn | zoomInUp | etc.)
		'container_size'      => 'container',    // container | container-fluid
		'inner_content_width' => 'full',         // auto | 3 - 11 | full (w-3/12, w-4/12, w-5/12, w-6/12, w-7/12, w-8/12, w-9/12, w-10/12, w-11/12, w-full)
		'margin_top'          => 'none',         // none | tiny | small | medium | large | x-large
		'margin_bottom'       => 'none',         // none | tiny | small | medium | large | x-large
		'padding_top'         => 'medium',       // none | tiny | small | medium | large | x-large
		'padding_bottom'      => 'medium',       // none | tiny | small | medium | large | x-large
	];

	switch ( $settings_type ) {
		case 'gutenberg':
			$block_settings = $supported_gutenberg_settings;
			break;
		case 'acf':
			$block_settings = array_merge( $supported_acf_background_settings, $supported_acf_other_settings );
			break;
		case 'background':
			$block_settings = $supported_acf_background_settings;
			break;
		case 'other':
			$block_settings = $supported_acf_other_settings;
			break;
		case 'all':
		default:
			$block_settings = array_merge( $supported_gutenberg_settings, $supported_acf_background_settings, $supported_acf_other_settings );
			break;
	}

	return $block_settings;
}
