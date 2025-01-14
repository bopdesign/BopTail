<?php
/**
 * Hide ACF Menu Based on User Role.
 */

namespace BopTail\ACF;

function show_acf_admin( $show ) {
	return current_user_can( 'manage_options' );
}

add_filter( 'acf/settings/show_admin', __NAMESPACE__ . '\show_acf_admin' );
