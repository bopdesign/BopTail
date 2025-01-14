<?php
/**
 * Returns the class value of the attribute.
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

function get_class_name_by_attribute( string $attr, $value = '' ) {
	$allowed_attributes = [
		'full_height'         => false,
		'align'               => 'full',         // none | wide | full
		'align_text'          => 'left',         // left | center | right
		'align_content'       => 'top left',     // [top|center|bottom left|center|right]
		'margin_top'          => 'none',         // none | small | medium | large
		'margin_bottom'       => 'none',         // none | small | medium | large
		'padding_top'         => 'medium',       // none | small | medium | large
		'padding_bottom'      => 'medium',       // none | small | medium | large
		'container_size'      => 'container',    // container | container-fluid
		'inner_content_width' => 'full',         // auto | 3 - 11 | full
		'animation'           => 'none',         // none | animate.css classes (fadeIn | slideIn | zoomInUp | etc.)
	];

	if ( ! array_key_exists( $attr, $allowed_attributes ) ) {
		return '';
	}

	$class_name = '';

	switch ( $attr ) {
		case 'full_height':
			if ( ! empty( $value ) && $value ) {
				$class_name = 'h-screen';
			}
			break;
		case 'align':
			if ( empty( $value ) || 'none' === $value ) {
				$class_name = 'alignnone';
			} else {
				$class_name = 'align' . esc_attr( $value );
			}
			break;
		case 'align_text':
			switch ( $value ) {
				case 'center':
					$class_name = 'text-center';
					break;
				case 'right':
					$class_name = 'text-right';
					break;
				case 'left':
				default:
					$class_name = 'text-left';
					break;
			}
			break;
		case 'align_content':
			switch ( $value ) {
				case 'top':
					$class_name = 'self-start is-position-' . sanitize_title( $value );
					break;
				case 'center':
					$class_name = 'self-center is-position-' . sanitize_title( $value );
					break;
				case 'bottom':
					$class_name = 'self-end is-position-' . sanitize_title( $value );
					break;
				case 'top left':
					$class_name = 'align-start justify-start is-position-' . sanitize_title( $value );
					break;
				case 'top center':
					$class_name = 'align-start justify-center is-position-' . sanitize_title( $value );
					break;
				case 'top right':
					$class_name = 'align-start justify-end is-position-' . sanitize_title( $value );
					break;
				case 'center left':
					$class_name = 'align-center justify-start is-position-' . sanitize_title( $value );
					break;
				case 'center center':
					$class_name = 'align-center justify-center is-position-' . sanitize_title( $value );
					break;
				case 'center right':
					$class_name = 'align-center justify-end is-position-' . sanitize_title( $value );
					break;
				case 'bottom left':
					$class_name = 'align-end justify-start is-position-' . sanitize_title( $value );
					break;
				case 'bottom center':
					$class_name = 'align-end justify-center is-position-' . sanitize_title( $value );
					break;
				case 'bottom right':
					$class_name = 'align-end justify-end is-position-' . sanitize_title( $value );
					break;
				default:
					$class_name = 'align-start justify-start is-position-top-left';
					break;
			}
			break;
		case 'container_size':
			$container_classes = ' relative';
			$class_name = esc_attr( $value ) . $container_classes;
			break;
		case 'inner_content_width':
			switch ( $value ) {
				case 'auto':
					$class_name = 'w-auto';
					break;
				case '3':
					$class_name = 'w-full md:w-3/12';
					break;
				case '4':
					$class_name = 'w-full md:w-4/12';
					break;
				case '5':
					$class_name = 'w-full md:w-5/12';
					break;
				case '6':
					$class_name = 'w-full md:w-6/12';
					break;
				case '7':
					$class_name = 'w-full md:w-7/12';
					break;
				case '8':
					$class_name = 'w-full md:w-8/12';
					break;
				case '9':
					$class_name = 'w-full md:w-9/12';
					break;
				case '10':
					$class_name = 'w-full md:w-10/12';
					break;
				case '11':
					$class_name = 'w-full md:w-11/12';
					break;
				case 'full':
				default:
					$class_name = 'w-full';
					break;
			}
			break;
		case 'margin_top':
			switch ( $value ) {
				case 'tiny':
					$class_name = 'margin-top-tiny';
					break;
				case 'small':
					$class_name = 'margin-top-small';
					break;
				case 'medium':
					$class_name = 'margin-top-medium';
					break;
				case 'large':
					$class_name = 'margin-top-large';
					break;
				case 'x-large':
					$class_name = 'margin-top-x-large';
					break;
				case 'none':
				default:
					$class_name = 'mt-0';
					break;
			}
			break;
		case 'margin_bottom':
			switch ( $value ) {
				case 'tiny':
					$class_name = 'margin-bottom-tiny';
					break;
				case 'small':
					$class_name = 'margin-bottom-small';
					break;
				case 'medium':
					$class_name = 'margin-bottom-medium';
					break;
				case 'x-large':
					$class_name = 'margin-bottom-x-large';
					break;
				case 'none':
				default:
					$class_name = 'mb-0';
					break;
			}
			break;
		case 'padding_top':
			switch ( $value ) {
				case 'tiny':
					$class_name = 'padding-top-tiny';
					break;
				case 'small':
					$class_name = 'padding-top-small';
					break;
				case 'medium':
					$class_name = 'padding-top-medium';
					break;
				case 'large':
					$class_name = 'padding-top-large';
					break;
				case 'x-large':
					$class_name = 'padding-top-x-large';
					break;
				case 'none':
				default:
					$class_name = 'pt-0';
					break;
			}
			break;
		case 'padding_bottom':
			switch ( $value ) {
				case 'tiny':
					$class_name = 'padding-bottom-tiny';
					break;
				case 'small':
					$class_name = 'padding-bottom-small';
					break;
				case 'medium':
					$class_name = 'padding-bottom-medium';
					break;
				case 'large':
					$class_name = 'padding-bottom-large';
					break;
				case 'x-large':
					$class_name = 'padding-bottom-x-large';
					break;
				case 'none':
				default:
					$class_name = 'pb-0';
					break;
			}
			break;
		case 'animation':
			// If we have an animation set a class.
			if ( ! empty( $value ) && 'none' !== $value ) {
				$class_name = 'wow animate__' . $value;
			}
			break;
	}

	return $class_name;
}
