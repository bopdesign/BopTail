<?php
/**
 * Load colors dynamically into select field from theme.json
 *
 * @param array $field field options.
 *
 * @return array new field choices.
 * @see get_theme_colors().
 */

namespace BopTail\ACF;

use function BopTail\Functions\get_theme_colors;

function acf_load_color_picker_field_choices( $field ) {
	// Reset choices.
	$field['choices'] = [];

	// Grab our colors array from theme.json.
	$colors = get_theme_colors();

	// If empty, return the field.
	if ( empty( $colors )) {
		return $field;
	}

	// Loop through colors.
	foreach ( $colors as $key => $color ) {
		// Create display markup.
		$color_output = '<div style="display: flex; align-items: center;"><span style="background-color:' . esc_attr( $color ) . '; border: 1px solid #ccc;display:inline-block; height: 15px; margin-right: 10px; width: 15px;"></span>' . esc_html( $key ) . '</div>';

		// Set values.
		$field['choices'][ sanitize_title( $key ) ] = $color_output;
	}

	// Return the field.
	return $field;
}

add_filter( 'acf/load_field/name=color_picker', __NAMESPACE__ . '\acf_load_color_picker_field_choices' );
