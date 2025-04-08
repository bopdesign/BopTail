<?php

/**
 * Additional code to run independent of the block’s rendering.
 */

namespace BopTail\Blocks\Stats;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register Stats Front end scripts.
 *
 * @return void
 */
function stats_register_front_end_scripts() {
	/**
	 * Front end modules.
	 *
	 * @see "viewScript" in block.json
	 */
	wp_register_script_module(
		"module-stats-front-script", // "viewScript" entry.
		get_theme_file_uri( '/components/blocks/stats/stats.js' ), array(), null );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\stats_register_front_end_scripts' );
