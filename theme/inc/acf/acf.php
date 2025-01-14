<?php
/**
 * Custom ACF functions.
 *
 * A place to custom functionality related to Advanced Custom Fields.
 *
 * @package BopTail
 */

namespace BopTail\ACF;

// If ACF isn't activated, then bail.
if ( ! class_exists( 'ACF' ) ) {
	return false;
}

/**
 * Get all the ACF include files for the theme.
 *
 * @return void
 */
function include_acf_files() {
	$acf_path  = BOPTAIL_INC . '/acf';
	$acf_files = [
		'disable-ui.php', // Hide ACF Menu Based on User Role.
		'acf-json.php', // Place ACF JSON in field-groups directory.
		'acf-load-color-picker-field-choices.php', // Adds theme colors to the ACF color picker.
//		'acf-load-gradient-picker-field-choices.php', // Adds theme gradients to the ACF color picker.
//		'search-custom-fields.php', // Extend WordPress search to include custom fields.
	];

	foreach ( $acf_files as $acf_include ) {
		$include = trailingslashit( $acf_path ) . $acf_include;

		// Allows inclusion of individual files or all .php files in a directory.
		if ( is_dir( $include ) ) {
			foreach ( glob( $include . '*.php' ) as $file ) {
				require $file;
			}
		} else {
			require $include;
		}
	}
}

include_acf_files();
