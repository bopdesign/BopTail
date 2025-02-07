<?php
/**
 * Safe check for ACF 6.0.
 */

namespace BopTail\Dependency;

/**
 * Checks if portable blocks can be used since it requires acf 6.0.
 *
 * @since  1.0
 */
function is_portable() {
	if ( ! function_exists( 'acf' ) || 6 > absint( acf()->version ) ) :
		return false;
	endif;

	return true;
}

/**
 * Provide a notice message if the ACF plugin has been deactivated.
 *
 * @since 1.0
 */
function acf_plugin_notice() {
	$message = sprintf( __( 'Warning: This theme will not work properly because <a href="%1$s">Advanced Custom Fields Pro (v6.0+)</a> has been deactivated. <a href="%1$s">Advanced Custom Fields Pro (v6.0+) must be active</a> in order for you to use this theme.', BOPTAIL_TEXT_DOMAIN ), admin_url( 'plugins.php' ) );
	printf( '<div class="notice notice-warning"><p>%s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput
}

function has_acf_plugin() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) || ! is_portable() ) ) {
		// If we try to activate this theme while the ACF plugin isn't active.
		if ( isset( $_GET['activate'] ) && ! wp_verify_nonce( $_GET['activate'] ) ) {
			add_action( 'admin_notices', __NAMESPACE__ . '\acf_plugin_notice' );
			// If we deactivate the ACF plugin while this theme is still active.
		} elseif ( ! isset( $_GET['activate'] ) ) {
			add_action( 'admin_notices', __NAMESPACE__ . '\acf_plugin_notice' );
		}
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\has_acf_plugin' );
