<?php
/**
 * Template part for displaying the header content.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BopTail
 */

?>

<header id="masthead" role="banner" class="fixed bg-foreground text-lg text-background w-full z-50">

	<nav id="site-navigation" class="relative flex items-center justify-between" aria-label="<?php esc_attr_e( 'Main Navigation', 'boptail' ); ?>">
		<div class="container">
			<div class="relative h-20 lg:h-24 flex flex-1 items-center lg:justify-between">
				<div class="absolute inset-y-0 right-0 flex items-center lg:hidden">
					<button type="button"
					        class="relative bg-tertiary inline-flex items-center justify-center rounded-full p-2 text-foreground hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
					        aria-controls="primary-menu" aria-expanded="false">
						<span class="absolute -inset-0.5"></span>
						<span class="sr-only"><?php esc_html_e( 'Primary Menu', 'boptail' ); ?></span>
						<!--
						  Icon when menu is closed.
						  Menu open: "hidden", Menu closed: "block"
						-->
						<svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
						     stroke="currentColor" aria-hidden="true" data-slot="icon">
							<path stroke-linecap="round" stroke-linejoin="round"
							      d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
						</svg>
						<!--
						  Icon when menu is open.
						  Menu open: "block", Menu closed: "hidden"
						-->
						<svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
						     stroke="currentColor" aria-hidden="true" data-slot="icon">
							<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
						</svg>
					</button>
				</div>

				<div class="site-branding flex shrink-0 items-center">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img class="h-12 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=blue&shade=500" alt="Data Clarity">
					</a>
				</div>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'navigation-menu hidden h-full lg:flex items-center space-x-12',
					'items_wrap'     => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
					'container'      => false,
				) );
				?>
			</div>
		</div>
	</nav><!-- #site-navigation -->

</header><!-- #masthead -->
