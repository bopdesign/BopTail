<?php
/**
 * Returns an array of block settings.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

/**
 * Returns an array of settings.
 *
 * @param array $block Array of block attributes.
 *
 * @return array The updated array of classes.
 */
function get_block_settings( $block ) {
	$block_settings = [];

	// Get block default settings.
	$block_defaults = get_supported_settings();

	// List of the supported Gutenberg settings.
	$supported_gutenberg_settings = get_supported_settings( 'gutenberg' );

	// List of the supported ACF settings.
	$supported_acf_settings = get_supported_settings( 'acf' );

	// Setup block default settings.
	$block_settings_defaults = [
		'class'    => false,
		'settings' => $block_defaults,
	];

	// Get block Gutenberg options.
	if ( isset( $block ) && ! empty( $block ) ) {
		if ( ! empty( $block['className'] ) ) {
			$block_settings['class'] = $block['className'];
		}

		// Iterate over settings that we support only and get their values.
		foreach ( $supported_gutenberg_settings as $gutenberg_setting => $value ) {
			if ( ! empty( $block[ $gutenberg_setting ] ) ) {
				$block_settings['settings'][ $gutenberg_setting ] = $block[ $gutenberg_setting ];
			}
		}
	}

	// Get block ACF settings.
	foreach ( $supported_acf_settings as $acf_setting => $value ) {
		$block_settings['settings'][ $acf_setting ] = get_field( $acf_setting );
	}

	$block_settings = wp_parse_args( $block_settings, $block_settings_defaults );

	return $block_settings;
}
