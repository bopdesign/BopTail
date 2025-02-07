<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */

namespace BopTail\Setup\Theme;

/**
 * Set up theme defaults and register supported WordPress features.
 *
 * @return void
 */
function setup() {
	add_action( 'init', __NAMESPACE__ . '\init', apply_filters( 'boptail_init_priority', 8 ) );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\i18n' );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );
}

/**
 * Initializes the theme classes and fires an action plugins can hook into.
 *
 * @return void
 */
function init() {
	do_action( 'boptail_before_init' );

	// Add some actions here if needed.

	do_action( 'boptail_init' );
}

/**
 * Makes Theme available for translation.
 *
 * Translations can be added to the /languages directory.
 * If you're building a theme based on "boptail", change the
 * filename of '/languages/BopTail.pot' to the name of your project.
 *
 * @return void
 */
function i18n() {
	load_theme_textdomain( BOPTAIL_TEXT_DOMAIN, BOPTAIL_ROOT_PATH . '/languages' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @return void
 */
function theme_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * This feature enables plugins and themes to manage the document title tag (1).
	 * This should be used in place of wp_title() (2) function.
	 *
	 * @link https://codex.wordpress.org/Title_Tag (1)
	 *       https://developer.wordpress.org/reference/functions/wp_title/ (2)
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Register new image sizes.
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_image_size/
	 */ // add_image_size( 'rename-me', width, height );
	// add_image_size( 'rename-me-too', width, height, true ); // true if we need cropped size for consistency.
	// Add additional image sizes.
	add_image_size( 'full-width', 1920, 1080 );

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 * Remove type="text/javascript" and type="text/css" from enqueued scripts and styles.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'search-form',
		'gallery',
		'caption',
		'navigation-widgets',
		'script',
		'style',
	) );

	// Add support for responsive embedded content.
	//add_theme_support( 'responsive-embeds' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for editor styles and enqueue them.
	add_theme_support( 'editor-styles' );
	add_editor_style( array(
		'style-editor.css',
		'style-editor-extra.css',
	) );

	/**
	 * Remove support for block templates.
	 * By adding the `theme.json` file, block templates automatically get enabled.
	 * The default is to override this feature.
	 */
	remove_theme_support( 'block-templates' );

	/**
	 * Disabling the default block patterns.
	 * WordPress comes with a number of block patterns built-in, themes can opt out of the bundled patterns and
	 * provide their own set.
	 */
	remove_theme_support( 'core-block-patterns' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'  => __( 'Primary Menu', BOPTAIL_TEXT_DOMAIN ),
//		'footer'   => __( 'Footer Menu', BOPTAIL_TEXT_DOMAIN ),
		'footer-1' => __( 'Footer Column One', BOPTAIL_TEXT_DOMAIN ),
		'footer-2' => __( 'Footer Column Two', BOPTAIL_TEXT_DOMAIN ),
		'footer-3' => __( 'Footer Column Three', BOPTAIL_TEXT_DOMAIN ),
	) );
}

// Bootstrap.
setup();
