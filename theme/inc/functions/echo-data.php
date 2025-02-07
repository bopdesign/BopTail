<?php
/**
 * Echo data in a formatted style.
 */

namespace BopTail\Functions;

/**
 * Display data in formatted style.
 *
 * @param mixed $var Data to output.
 *
 * @return false|void
 */
function echo_data( $var ) {
	if ( empty( $var ) ) {
		return false;
	}

	echo '<pre>';
	print_r( $var );
	echo '</pre>';
}
