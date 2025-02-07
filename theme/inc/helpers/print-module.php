<?php
/**
 * Render a module.
 */

namespace BopTail\Helpers;

/**
 * Render a module.
 *
 * @param string $module_name The name of the module.
 * @param array  $args        Args for the module.
 *
 * @return string|void
 */
function print_module( $module_name, $args ) {
	if ( empty( $module_name ) ) {
		return '';
	}

	// Extract args.
	if ( ! empty( $args ) ) {
		extract( $args ); //phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- We can use it here since we know what to expect on the arguments.
	}

	require BOPTAIL_COMPONENTS . 'modules/' . $module_name . '.php';
}
