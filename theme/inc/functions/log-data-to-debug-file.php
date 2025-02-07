<?php
/**
 * Log data to the debug.log file.
 */

namespace BopTail\Functions;

/**
 * Log data to the debug.log file.
 * Useful when getting a white screen of death or an error in general.
 *
 * @param mixed $var Data to write to the file.
 *
 * @return false|void
 */
function log_data_to_debug_file( $var ) {
	if ( empty( $var ) ) {
		return false;
	}

	ob_start();
	var_dump( $var );
	$contents = ob_get_contents();
	ob_end_clean();
	error_log( $contents );
}
