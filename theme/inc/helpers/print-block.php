<?php
/**
 * Render a block.
 *
 * To be used from a template part to render a block.
 */

namespace BopTail\Helpers;

/**
 * Example Usage in a template part in wd_s or another theme.
 *
 * Top of file:
 * use function BopTail\Helpers\print_block;
 *
 * Prints a Call to Action Block.
 * if ( function_exists( 'Create new scratch file from selection\print_block' ) ) :
 *  print_block(
 *      'call-to-action',
 *      [
 *          'allowed_innerblocks' => [],
 *          'fields'              => [
 *              'eyebrow'     => 'CTA Eyebrow text',
 *              'heading'     => 'CTA Heading text',
 *              'content'     => '<p>Lorem ipsum dolor sit amet.</p>',
 *              'button_args' => [
 *                  'button' => [
 *                      'title'  => 'CTA Button Text',
 *                      'url'    => 'https://www.bopdesign.com/',
 *                      'target' => '',
 *                  ],
 *              ],
 *              'layout'      => 'center',
 *          ],
 *      ]
 *  );
 * endif;
 */

/**
 * Render a block.
 *
 * @param string $block_name The name of the block.
 * @param array  $args Args for the block.
 *
 * @return string|void
 */
function print_block( $block_name, $args = [] ) {
	if ( empty( $block_name ) ) {
		return '';
	}

	// Extract args.
	if ( ! empty( $args ) ) {
		extract( $args ); //phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- We can use it here since we know what to expect on the arguments.
	}

	require BOPTAIL_COMPONENTS . 'blocks/' . $block_name . '/render.php';
}
