<?php
/**
 * Sets up custom filters and actions for the theme.  This does things like sets up sidebars, menus, scripts, 
 * and lots of other awesome stuff that WordPress themes do.
 *
 * @package    StudioRedd
 * @author     Erik Joling <erik@ejoweb.nl>
 * @copyright  Copyright (c) 2015, Erik Joling
 * @link       http://www.ejoweb.nl/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register custom image sizes. */
add_action( 'init', 'redd_register_image_sizes', 5 );

/* Register custom menus. */
add_action( 'init', 'redd_register_menus', 5 );

/* Register sidebars. */
add_action( 'widgets_init', 'redd_register_sidebars', 5 );

//* Remove styles & scripts
add_action( 'wp_print_styles', 'redd_remove_styles_and_scripts', 99 );

//* Add custom styles & scripts
add_action( 'wp_enqueue_scripts', 'redd_add_styles_and_scripts', 5 );

//* Extensions
include_once( THEME_LIB_DIR . 'extensions/redd-blog-widget/index.php' );
include_once( THEME_LIB_DIR . 'extensions/redd-home-header-widget/index.php' );
include_once( THEME_LIB_DIR . 'extensions/redd-teammember-widget/widget-class.php' );
include_once( THEME_LIB_DIR . 'extensions/redd-post-language/redd-post-language.php' );

/**
 * Registers custom image sizes for the theme. 
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function redd_register_image_sizes() {
	add_image_size( 'Thumbnail-vierkant', 400, 400, true ); 
}

/**
 * Registers nav menu locations.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function redd_register_menus() {
	register_nav_menu( 'primary', 'Primary' );
}

/**
 * Registers sidebars.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function redd_register_sidebars() {

	hybrid_register_sidebar(
		array(
			'id'          => 'home-header-image',
			'name'        => 'Home - Header Image',
			'description' => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'home-intro',
			'name'        => 'Home - Intro',
			'description' => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'home-werkwijze',
			'name'        => 'Home - Werkwijze',
			'description' => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'home-werkwijze-img',
			'name'        => 'Home - Werkwijze Afbeeldingen',
			'description' => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'home-diensten',
			'name'        => 'Home - Diensten',
			'description' => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'home-blog',
			'name'        => 'Home - Blog',
			'description' => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'team',
			'name'        => 'Team',
			'description' => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'after-content',
			'name'        => 'After Content',
			'description' => '',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'footer',
			'name'        => 'Footer',
			'description' => 'Footer...'
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'newsletter-popup',
			'name'        => 'Nieuwsbrief Popup',
			'description' => 'Inhoud van de popup'
		)
	);
}


/**
 * Remove scripts & stylesheets for the front end.
 */
function redd_remove_styles_and_scripts() {

	/* Gets ".min" suffix. */
	$suffix = hybrid_get_min_suffix();
}

/**
 * Load scripts & styles for the front end.
 */
function redd_add_styles_and_scripts() {

	$suffix = hybrid_get_min_suffix();

	//* Scripts
	wp_register_script( 'redd', THEME_JS_URI . "theme{$suffix}.js", array( 'jquery' ), THEME_VERSION, true );
	wp_enqueue_script( 'redd' );

	//* Styles

	/* Load Font */
	// wp_enqueue_style( 'redd-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic' );
	
	/* Load active theme stylesheet. */
	// wp_enqueue_style( 'style', get_stylesheet_uri(), false, THEME_VERSION );
	wp_enqueue_style( 'theme', THEME_CSS_URI . "theme{$suffix}.css", false, THEME_VERSION );

	//* Theme version or filemtime( THEME_JS_DIR . "theme{$suffix}.js" ) for cache break
}
