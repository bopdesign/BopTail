<?php
/**
 * Get the site utilities bar, and display it.
 *
 * @return void
 */

namespace BopTail\Hooks\Utilities;

function output_utilities_bar() {
	$utilities_bar = get_field( 'utilities_bar', 'options' );

	if ( empty( $utilities_bar ) || empty( $utilities_bar['utilities_bar_onoff'] ) || ! $utilities_bar['utilities_bar_onoff'] ) {
		return;
	}

	$utilities_bar_color      = $utilities_bar['utilities_bar_color'];
	$utilities_bar_text_color = $utilities_bar['utilities_bar_text_color'];

	$classes = [ 'utilities-bar', 'relative', 'py-4', 'not-prose' ];

	if ( ! empty( $utilities_bar_color['color_picker'] ) ) {
		$classes[] = 'bg-' . esc_attr( $utilities_bar_color['color_picker'] );
	}

	if ( ! empty( $utilities_bar_text_color['color_picker'] ) ) {
		$classes[] = 'text-' . esc_attr( $utilities_bar_text_color['color_picker'] );
	}

	$utilities_bar_class  = implode( ' ', $classes );
	$utility_links        = ! empty( $utilities_bar['utility_links'] ) ? $utilities_bar['utility_links'] : [];
	$utility_links_output = '';

	foreach ( $utility_links as $utility_link ) {
		$link_icon          = $utility_link['link_icon'];
		$link_icon_position = $utility_link['icon_position'];
		$link_data          = $utility_link['link'];

		if ( ! empty( $link_data['url'] ) ) {
			if ( ! empty( $link_icon ) ) {
				switch ( $link_icon_position ) {
					case 'right':
						$icon_output = $link_data['title'];
						$icon_output .= '<span class="dashicons ' . esc_attr( $link_icon ) . ' ml-1"></span>';
						break;
					case 'left':
					default:
						$icon_output = '<span class="dashicons ' . esc_attr( $link_icon ) . ' mr-1"></span>';
						$icon_output .= $link_data['title'];
						break;
				}
			} else {
				$icon_output = $link_data['title'];
			}

			$utility_links_output .= sprintf( '<a href="%s" class="utilities-bar__link font-bold mr-4">%s</a>', esc_url( $link_data['url'] ), $icon_output );
		}
	}
	?>

	<div class="<?php echo esc_attr( $utilities_bar_class ); ?>">
		<div class="container">
			<div class="flex flex-1 items-center sm:justify-between">
				<div id="utility-bar-links" class="flex items-center">
					<?php
					if ( ! empty( $utility_links_output ) ) {
						echo wp_kses_post( $utility_links_output );
					}
					?>
				</div>
				<div id="utility-bar-tools" class="flex items-center">
					<a href="#language" class="utilities-bar__link font-bold mr-4">
						<span class="dashicons dashicons-location mr-1"></span>English
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php
}

// Utilities bar to be placed after opening body tag.
add_action( 'wp_body_open', __NAMESPACE__ . '\output_utilities_bar' );
