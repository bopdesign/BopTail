<?php
/**
 * Get the theme colors for this project from the theme.json.
 *
 * @return array The array of our color names and hex values.
 */

namespace BopTail\Functions;

function get_theme_colors() {
	$theme_colors    = [];
	$theme_json_file = get_theme_file_path( 'theme.json' );

	if ( file_exists( $theme_json_file ) ) {
		$theme_json_contents = file_get_contents( $theme_json_file );
		$theme_json_data     = json_decode( $theme_json_contents, true );

		if ( ! empty( $theme_json_data ) && ! empty( $theme_json_data['settings']['color']['palette'] ) ) {
			foreach ( $theme_json_data['settings']['color']['palette'] as $color ) {
				$color_name  = esc_html__( $color['name'], BOPTAIL_TEXT_DOMAIN );
				$color_value = $color['color'];

				$theme_colors[ $color_name ] = $color_value;
			}
		}

		if ( ! empty( $theme_colors ) ) {
			return $theme_colors;
		}
	}

	return $theme_colors;
}
