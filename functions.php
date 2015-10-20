<?php
/**
 * @package    StudioRedd
 * @author     Erik Joling <erik@ejoweb.nl>
 * @copyright  Copyright (c) 2015, Erik Joling
 * @link       http://www.ejoweb.nl/
 * @license    ?
 */

//* Get the template directory and uri and make sure it has a trailing slash.
define( 'THEME_LIB_DIR', trailingslashit( get_template_directory() ) . '_build/' );
define( 'THEME_LIB_URI', trailingslashit( get_template_directory_uri() ) . '_build/' );

//* Set custom Hybrid location.
define( 'HYBRID_DIR', THEME_LIB_DIR . 'hybrid/' );
define( 'HYBRID_URI', THEME_LIB_URI . 'hybrid/' );

//* Load the Hybrid Core framework and theme files.
require_once( HYBRID_DIR . 'hybrid.php' );

//* Theme setup ie. menus, sidebars, image-sizes, additional scripts and styles.
require_once( THEME_LIB_DIR . 'theme.php' );

//* Launch the Hybrid Core framework.
new Hybrid();


// *** BEGIN *** //

//* Do theme setup on the 'after_setup_theme' hook.
add_action( 'after_setup_theme', 'erik_theme_setup', 5 );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function erik_theme_setup() 
{	
	//* Get & Set Version
	$theme = wp_get_theme();
	define( 'THEME_VERSION', $theme->get( 'Version' ) );

	//* Set Textdomain with stylesheet 'text-domain'
	define( 'TEXT_DOMAIN', hybrid_get_parent_textdomain() );

	//* Set paths to asset folders.
	define( 'THEME_IMG_URI', trailingslashit( HYBRID_PARENT_URI ) . 'assets/images/' );
	define( 'THEME_JS_URI', trailingslashit( HYBRID_PARENT_URI ) . 'assets/js/' );
	define( 'THEME_CSS_URI', trailingslashit( HYBRID_PARENT_URI ) . 'assets/css/' );

	//* Enable custom template hierarchy.
	add_theme_support( 'hybrid-core-template-hierarchy' );

	//* Better image grabbing
	add_theme_support( 'get-the-image' );

	//* Add breadcrumbs
	add_theme_support( 'breadcrumb-trail' );

	//* Automatically add feed links to <head>.
	// add_theme_support( 'automatic-feed-links' );

	//* Filter excerpt_more
	add_filter( 'excerpt_more', function() { return '...'; } );

	//* Set cookie when newsletter is submitted
	add_action( 'gform_after_submission', 'set_popup_cookie', 10, 2 );


	/* Backend
	--------------------------------------------- */
	//* Add custom styles to "Styles" dropdown in Visual Editor
	add_filter( 'tiny_mce_before_init', 'redd_mce_before_init' );

	//* Change crop of medium and large to 1
	ejo_change_default_image_size_crop( 'medium', 1 );
	ejo_change_default_image_size_crop( 'large', 1 );

	// add_filter('gform_init_scripts_footer', '__return_true');
}


//* Add custom styles to "Styles" dropdown
function redd_mce_before_init( $settings ) 
{
	//* Get current styles or empty array
    $style_formats = !empty($settings['style_formats']) ? json_decode( $settings['style_formats'] ) : array();

	//* Make new styles
	$new_style_formats = array(

        // array(
        //     'title' => 'Full Width',
        //     'block' => 'p',
        //     'classes' => 'full-width',
        // ),
        array(
            'title' => 'Normal Width',
            'block' => 'p',
            'classes' => 'normal-width',
        )
    );

    //* Combine new styles with current styles
    $style_formats = array_merge($style_formats, $new_style_formats);

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}

//*
function redd_language_module() {
	global $post;

	if ( !is_singular( get_post_type() ) ) // If not viewing a single post. 
		return;

	$post_language_enabled = get_post_meta( $post->ID, '_redd-post-language-enabled', true );

	if ($post_language_enabled) : // If language module is enabled for current page 

		$post_language = get_post_meta( $post->ID, '_redd-post-language', true );
   		$post_language_linked_post = get_post_meta( $post->ID, '_redd-post-language-linked-post', true );

   		if ($post_language && $post_language_linked_post) : // If language is selected and a linked post is given
       		
       		$post_translation_link = get_permalink($post_language_linked_post);
       		$current_post_link = get_permalink($post->ID);

       		if (!$post_translation_link) 
       			return; 

			echo '<div class="language-selector">';

       			//* If current post is NL then make EN a link to that post
       			if ($post_language == 'NL') {
       				$NL = '<a href="'.$current_post_link.'" class="active-language" title="Nederlandse vertaling">NL</a>';
       				$EN = '<a href="'.$post_translation_link.'" title="Engelse vertaling">EN</a>';
       			}

       			//* If current post is EN then make NL a link to that post
       			elseif ($post_language == 'EN') {
       				$NL = '<a href="'.$post_translation_link.'" title="Dutch translation">NL</a>';
       				$EN = '<a href="'.$current_post_link.'" class="active-language" title="English translation">EN</a>';
       			}

       			//* Output
       			echo $NL . ' / ' . $EN;

			echo '</div>';
       		?>

		<?php endif; ?>

	<?php endif;
}

//* Set cookie when newsletter is submitted
function set_popup_cookie( $entry, $form ) {

	//* Check if newsletter form is submitted
	if ( stristr($form['title'], 'newsletter') !== FALSE || stristr($form['title'], 'nieuwsbrief') !== FALSE ) { 
		?>
		<script type='text/javascript'>
			var cookieName = 'studioredd-newsletter-popup';
			Cookies.set( cookieName, 'submitted', { expires: 365 * 5 });
			// console.log( Cookies.get(cookieName) );
		</script>
		<?php 
	}
}