<?php
/**
 * Backwards compatibility.
 */

namespace BopTail\Compatibility;

/**
 * Prevent switching to the theme on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @return void
 */
function switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', __NAMESPACE__ . '\upgrade_notice' );
}
add_action( 'after_switch_theme', __NAMESPACE__ . '\switch_theme' );

/**
 * Displays an upgrade notice if the current WordPress or PHP version does not meet the theme requirements,
 * after an unsuccessful attempt to switch to the theme.
 *
 * @return void
 */
function upgrade_notice() {
	/* translators: %1$s: WordPress version. %2$s PHP version.*/
	$message = sprintf( esc_html__( 'This theme requires at least WordPress version 6.0 and PHP version 7.4. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', BOPTAIL_TEXT_DOMAIN ), $GLOBALS['wp_version'], PHP_VERSION );
	printf( '<div class="notice notice-error"><p>%s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Halts execution and displays a message for unsupported WordPress or PHP versions.
 *
 * Outputs an error message and a back link if the current WordPress or PHP version
 * does not meet the minimum requirements for the theme.
 *
 * @return void
 * @global mixed $wp_version WordPress version.
 */
function customize() {
	wp_die(
		sprintf(
			/* translators: %1$s: WordPress version. %2$s PHP version.*/
			esc_html__( 'This theme requires at least WordPress version 6.0 and PHP version 7.4. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', BOPTAIL_TEXT_DOMAIN ),
			esc_html( $GLOBALS['wp_version'] ),
			esc_html( PHP_VERSION )
		),
		'',
		[
			'back_link' => true,
		]
	);
}
add_action( 'load-customize.php', __NAMESPACE__ . '\customize' );

/**
 * Terminates execution if a theme preview is requested and requirements are not met.
 *
 * Displays an error message and stops script execution when the theme preview is accessed,
 * and the WordPress or PHP version does not meet the required minimum versions.
 *
 * @return void
 * @global mixed $wp_version WordPress version.
 */
function preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die(
			sprintf(
				/* translators: %1$s: WordPress version. %2$s PHP version.*/
				esc_html__( 'This theme requires at least WordPress version 6.0 and PHP version 7.4. You are running WordPress version %1$s and PHP version %2$s. Please upgrade and try again.', BOPTAIL_TEXT_DOMAIN ),
				esc_html( $GLOBALS['wp_version'] ),
				esc_html( PHP_VERSION )
			)
		);
	}
}
add_action( 'template_redirect', __NAMESPACE__ . '\preview' );
