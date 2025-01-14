<?php
/**
 * Returns an array of Background Settings extracted from the settings.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

/**
 * Returns an array of ACF fields.
 *
 * @param array $settings Array of block settings to extract from.
 */
function get_background_settings( $settings ) {
	// Background default is none.
	$background_settings = [
		'background_type' => 'none',
	];

	// If empty, bail early.
	if ( empty( $settings ) ) {
		return $background_settings;
	}

	// List of the supported background settings.
	$supported_background_settings = get_supported_settings( 'background' );

	// Get block ACF settings for background.
	foreach ( $supported_background_settings as $background_setting => $setting_value ) {
		if ( array_key_exists( $background_setting, $settings ) ) {
			$background_settings[ $background_setting ] = $settings[ $background_setting ];
		} else {
			$background_settings[ $background_setting ] = false;
		}
	}

	return $background_settings;
}
