<?php
/**
 * Sets up custom filters and actions for the theme.  This does things like sets up sidebars, menus, scripts, 
 * and lots of other awesome stuff that WordPress themes do.
 *
 * @package    EJOweb
 * @author     Erik Joling <erik@ejoweb.nl>
 * @copyright  Copyright (c) 2015, Erik Joling
 * @link       http://www.ejoweb.nl/
 */

/* Register custom image sizes. */
add_action( 'init', 'ejo_register_image_sizes', 5 );

/* Register custom menus. */
add_action( 'init', 'ejo_register_menus', 5 );

/* Register sidebars. */
add_action( 'widgets_init', 'ejo_register_sidebars', 5 );

//* Remove styles & scripts
add_action( 'wp_print_styles', 'ejo_remove_styles_and_scripts', 99 );

//* Add custom styles & scripts
add_action( 'wp_enqueue_scripts', 'ejo_add_styles_and_scripts', 20 );

/* Add editor style */
add_action( 'admin_init', 'ejo_add_editor_styles' );

//* Filter excerpt_more
add_filter( 'excerpt_more', function() { return '...'; } );


/**
 * Registers custom image sizes for the theme. 
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ejo_register_image_sizes() 
{
	// add_image_size( 'page-header', 960, 240, true ); 
}

/**
 * Registers nav menu locations.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ejo_register_menus() 
{
	register_nav_menu( 'primary', 'Primary' );
}

/**
 * Registers sidebars.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ejo_register_sidebars() 
{
	hybrid_register_sidebar(
		array(
			'id'          => 'sidebar-primary',
			'name'        => 'Sidebar - Primary',
			'description' => 'Drag widgets to here',
		)
	);
}


/**
 * Remove scripts & stylesheets for the front end.
 */
function ejo_remove_styles_and_scripts() 
{
	/* Gets ".min" suffix. */
	$suffix = hybrid_get_min_suffix();
}

/**
 * Load scripts & styles for the front end.
 */
function ejo_add_styles_and_scripts() 
{
	$suffix = hybrid_get_min_suffix();

	//* Scripts
	wp_enqueue_script( 'ejo', THEME_JS_URI . "theme{$suffix}.js", array( 'jquery' ), THEME_VERSION, true );

	//* Styles
	/* Load Font */
	// wp_enqueue_style( 'ejo-fonts', 'https://fonts.googleapis.com/css?family=Oswald:400,700|Droid+Serif:400,400italic,700,700italic' );

	/* Load active theme stylesheet. */
	wp_enqueue_style( 'theme', THEME_CSS_URI . "theme{$suffix}.css", false, THEME_VERSION );
}

/**
 * Add editor style
 */
function ejo_add_editor_styles()
{
	$suffix = hybrid_get_min_suffix();

	/* External font */
	// $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Roboto:300,300italic,500,500italic|Roboto+Slab:700' );
	// add_editor_style( $font_url );

	/* Editor Style */
	add_editor_style( THEME_CSS_URI . "editor-style{$suffix}.css" );
}