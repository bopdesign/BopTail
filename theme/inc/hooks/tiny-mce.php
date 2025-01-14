<?php
/**
 * Tweak TinyMCE editor.
 *
 * @package BopTail
 */

namespace BopTail\Hooks\TinyMCE;

use function BopTail\Functions\get_theme_colors;

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 *
 * @return array
 */
function tinymce_add_class( $settings ) {
	$settings['body_class'] = BOPTAIL_TYPOGRAPHY_CLASSES;

	return $settings;
}

add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\tinymce_add_class' );

/**
 * Customize the options for the MCE4 editor.
 *
 * This function modifies the settings for the MCE4 editor in WordPress. It adds custom colors to the text color map
 * and allows for other customizations. The custom colors are generated from the theme colors array obtained using the
 * `get_theme_colors()` function.
 *
 * @param array $init The initial settings for the MCE4 editor.
 *
 * @return array The modified settings for the MCE4 editor.
 *
 * @link https://wordpress.stackexchange.com/questions/233450/how-do-you-add-custom-color-swatches-to-all-wysiwyg-editors
 * @link https://urosevic.net/wordpress/tips/custom-colours-tinymce-4-wordpress-39/
 */
function customize_mce4_options( $init ) {
	// Grab our colors array.
	$theme_colors = get_theme_colors();

	// If no color are set, bail early.
	if ( empty( $theme_colors ) ) {
		return $init;
	}

	$custom_colors = '';

	// Loop through colors.
	foreach ( $theme_colors as $key => $color ) {
		// Remove hashtag from the color string.
		$color = preg_replace( '/#/', '', $color );
		// Create display markup.
		$custom_colors .= '"' . $color . '", "' . esc_html( $key ) . '",' . "\n";
	}

	// Build colour grid default+custom colors.
	$init['textcolor_map'] = '[' . $custom_colors . ']';

	/**
	 * Other customizations.
	 *
	 * Change the number of rows in the grid if the number of colors changes.
	 * 8 swatches per row.
	 * There should be also extra swatch at the end of the color list which removes any color applied to the text.
	 *
	 * @url https://wordpress.stackexchange.com/questions/233450/how-do-you-add-custom-color-swatches-to-all-wysiwyg-editors
	 * @url https://urosevic.net/wordpress/tips/custom-colours-tinymce-4-wordpress-39/
	 */

//	$number_of_colors = count( $theme_colors );
//
//	if ( $number_of_colors % 5 === 0 ) {
//		// Adding extra row for swatch, that removes color applied.
//		$init['textcolor_rows'] = ceil( $number_of_colors / 5 ) + 1;
//	} else {
//		$init['textcolor_rows'] = ceil( $number_of_colors / 5 );
//	}
//	$init['textcolor_cols'] = 5;

	return $init;
}

add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\customize_mce4_options' );
