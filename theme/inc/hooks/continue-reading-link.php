<?php
/**
 * Customize the [...] on the_excerpt() and "Read More" string on <!-- more --> with the_content();
 */

namespace BopTail\Hooks;

/**
 * Create the continue reading link.
 *
 * @param string $more_string The string shown within the more link.
 *
 * @return string Read more link.
 */
function continue_reading_link( $more_string ) {
	if ( ! is_admin() ) {
		$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', BOPTAIL_TEXT_DOMAIN ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="sr-only">"', '"</span>', false )
		);

		$more_string = '<a href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}

	return $more_string;
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', __NAMESPACE__ . '\continue_reading_link' );

// Filter the content more link.
add_filter( 'the_content_more_link', __NAMESPACE__ . '\continue_reading_link' );
