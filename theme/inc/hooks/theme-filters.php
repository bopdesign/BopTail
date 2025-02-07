<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 */

namespace BopTail\Hooks\Filters;

/**
 * Determines whether the post thumbnail can be displayed.
 *
 * @return bool Whether post featured image can be displayed or not.
 */
function can_show_post_thumbnail() {
	return apply_filters( 'boptail_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Filters WYSIWYG content with the_content filter.
 *
 * @param string $content content dump from WYSIWYG.
 *
 * @return string|bool Content string if content exists, else empty.
 */
function get_post_content( $content ) {
	return ! empty( $content ) ? $content : false;
}

add_filter( 'the_content', __NAMESPACE__ . '\get_post_content', 20 );
