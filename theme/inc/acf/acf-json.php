<?php
/**
 * Place ACF JSON in field-groups directory.
 * Save fields as JSON, allow syncing.
 */

namespace BopTail\ACF;

function acf_json_filename( $filename, $post, $load_path ) {
	$filename = str_replace( array(
			' ',
			'_',
			':',
		), array(
			'-',
			'-',
			'',
		), $post['title'] );

	$filename = strtolower( $filename ) . '.json';

	return $filename;
}

add_filter( 'acf/json/save_file_name', __NAMESPACE__ . '\acf_json_filename', 10, 3 );

// Set all ACF field groups to save into a specific folder.
function acf_field_groups_save_folder( $path ) {
	return BOPTAIL_ROOT_PATH . 'acf-json/field-groups';
}

add_filter( 'acf/settings/save_json/type=acf-field-group', __NAMESPACE__ . '\acf_field_groups_save_folder' );

// Set all ACF options pages to save into a specific folder.
function acf_options_pages_save_folder( $path ) {
	return BOPTAIL_ROOT_PATH . 'acf-json/options-pages';
}

add_filter( 'acf/settings/save_json/type=acf-ui-options-page', __NAMESPACE__ . '\acf_options_pages_save_folder' );

// Set all ACF custom post types to save into a specific folder.
function acf_cpt_save_folder( $path ) {
	return BOPTAIL_ROOT_PATH . 'acf-json/post-types';
}

add_filter( 'acf/settings/save_json/type=acf-post-type', __NAMESPACE__ . '\acf_cpt_save_folder' );

// Set all ACF taxonomies to save into a specific folder.
function acf_taxonomy_save_folder( $path ) {
	return BOPTAIL_ROOT_PATH . 'acf-json/taxonomies';
}

add_filter( 'acf/settings/save_json/type=acf-taxonomy', __NAMESPACE__ . '\acf_taxonomy_save_folder' );

// Add a new load point (folder) for ACF to look in.
function acf_json_load_point( $paths ) {
	// Remove the original path (optional).
	unset( $paths[0] );

	// Append the new paths and return them.
	$paths[] = BOPTAIL_ROOT_PATH . 'acf-json/field-groups';
	$paths[] = BOPTAIL_ROOT_PATH . 'acf-json/options-pages';
	$paths[] = BOPTAIL_ROOT_PATH . 'acf-json/post-types';
	$paths[] = BOPTAIL_ROOT_PATH . 'acf-json/taxonomies';

	return $paths;
}

add_filter( 'acf/settings/load_json', __NAMESPACE__ . '\acf_json_load_point' );
