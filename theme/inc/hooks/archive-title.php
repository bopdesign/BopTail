<?php
/**
 * Removes or Adjusts the prefix on category archive page titles.
 *
 * @package BopTail
 */

namespace BopTail\Hooks\ArchiveTitle;

/**
 * Removes or Adjusts the prefix on category archive page titles.
 *
 * @param string $block_title The default $block_title of the page.
 *
 * @return string The updated $block_title.
 */
function remove_archive_title_prefix( $block_title ) {
	// Get the single category title with no prefix.
	$single_cat_title = single_term_title( '', false );

	if ( is_category() || is_tag() || is_tax() ) {
		return esc_html( $single_cat_title );
	}

	return $block_title;
}

add_filter( 'get_the_archive_title', __NAMESPACE__ . '\remove_archive_title_prefix' );

/**
 * Filters the default archive titles.
 *
 * @return string The updated $block_title.
 */
function boptail_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'boptail' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'boptail' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'boptail' ) . '<span>' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'boptail' ) . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'boptail' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'boptail' ) . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'boptail' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'boptail' ) . '<span>' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$cpt   = get_post_type_object( get_queried_object()->name );
		$title = sprintf(
		/* translators: %s: Post type singular name */
			esc_html__( '%s Archives', 'boptail' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$tax   = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf(
		/* translators: %s: Taxonomy singular name */
			esc_html__( '%s Archives', 'boptail' ),
			$tax->labels->singular_name
		);
	} else {
		$title = __( 'Archives:', 'boptail' );
	}

	return $title;
}

//add_filter( 'get_the_archive_title', __NAMESPACE__ . '\boptail_get_the_archive_title' );
