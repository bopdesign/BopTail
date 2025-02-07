<?php
/**
 * Widget area settings.
 */

namespace BopTail\Hooks\Widgets;

/**
 * Register widget areas.
 *
 * @link   https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function widgets_init() {
	// Define sidebars.
	$sidebars = [
		'sidebar-1' => esc_html__( 'Footer', BOPTAIL_TEXT_DOMAIN ),
	];

	// Loop through each sidebar and register.
	foreach ( $sidebars as $sidebar_id => $sidebar_name ) {
		register_sidebar( array(
			'name'          => $sidebar_name,
			'id'            => $sidebar_id,
			'description'   => /* translators: the sidebar name */ sprintf( esc_html__( 'Widget area for %s', BOPTAIL_TEXT_DOMAIN ), $sidebar_name ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}

add_action( 'widgets_init', __NAMESPACE__ . '\widgets_init' );
