<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BopTail
 */

$subscribe_form_group = get_field( 'subscribe_form', 'option' );
$form_heading         = $subscribe_form_group['heading'];
$form_content         = $subscribe_form_group['content'];
$form                 = $subscribe_form_group['form'];
?>

<footer id="colophon" class="site-footer pt-16 md:pt-24 pb-12 bg-foreground text-white" role="contentinfo">

	<div class="container">
		<div class="flex flex-col md:flex-row">
			<?php if ( has_nav_menu( 'footer-1' ) || has_nav_menu( 'footer-2' ) || has_nav_menu( 'footer-3' ) ) : ?>
				<nav class="footer-navigation text-lg basis-3/4 hidden md:flex flex-col md:flex-row" aria-label="<?php esc_attr_e( 'Footer Menu', BOPTAIL_TEXT_DOMAIN ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-1',
							'menu_class'     => 'footer-menu basis-1/3',
							'depth'          => 2,
							'container'      => false,
						)
					);
					wp_nav_menu(
						array(
							'theme_location' => 'footer-2',
							'menu_class'     => 'footer-menu basis-1/3',
							'depth'          => 2,
							'container'      => false,
						)
					);
					wp_nav_menu(
						array(
							'theme_location' => 'footer-3',
							'menu_class'     => 'footer-menu basis-1/3',
							'depth'          => 2,
							'container'      => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
				<aside role="complementary" class="basis-1/4 mr-0 md:mr-6" aria-label="<?php esc_attr_e( 'Footer', BOPTAIL_TEXT_DOMAIN ); ?>">
					<div class="border-s border-white pl-6">
						<?php dynamic_sidebar( 'sidebar-1' ); ?>
					</div>
				</aside>
			<?php endif; ?>
		</div>
	</div>

	<div class="site-info container pt-16 lg:pt-32 text-sm md:text-base">
		<?php if ( ! empty( $copyright['copyright_text'] ) ) : ?>
			<?php
			/* translators: 1: Copyright text. */
			printf(
				'<span class="copyright">&copy; %1$s %2$s</span>',
				esc_html( gmdate( 'Y' ) ),
				esc_html( __( $copyright['copyright_text'], BOPTAIL_TEXT_DOMAIN ) ),
			);
			?>
		<?php else: ?>
			<?php
			/* translators: 1: Copyright text. */
			printf(
				'<span class="copyright">&copy; %1$s %2$s</span>',
				esc_html( gmdate( 'Y' ) ),
				esc_html( get_bloginfo( 'name' ) . '. ' . __( 'All Rights Reserved.', BOPTAIL_TEXT_DOMAIN ) ),
			);
			?>
		<?php endif; ?>
		<?php if ( ! empty( $copyright['copyright_links'] ) ) : ?>
			<div class="inline-block">
				<?php
				foreach ( $copyright['copyright_links'] as $link ) {
					/* translators: 1: Privacy link, 2: Link title. */
					printf(
						'<a href="%1$s" class="border-s border-white ml-1 pl-2">%2$s</a>',
						esc_url( __( $link['link']['url'], BOPTAIL_TEXT_DOMAIN ) ),
						esc_html( __( $link['link']['title'], BOPTAIL_TEXT_DOMAIN ) ),
					);
				}
				?>
			</div>
		<?php endif; ?>
	</div>

</footer><!-- #colophon -->
