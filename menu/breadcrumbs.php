<?php 

if ( function_exists('yoast_breadcrumb') ) {

	yoast_breadcrumb(
		'<p class="breadcrumb-trail breadcrumbs">',
		'</p>'
	);

}

/*
if ( function_exists( 'breadcrumb_trail' ) ) : // Check for breadcrumb support.

	breadcrumb_trail(
		array( 
			'container'       => 'nav',
			'separator'		  => '>',
			'show_on_front'   => false,
			'show_title'      => true,
			'show_browse'     => false,
			// 'labels'          => array(),
			// 'post_taxonomy'   => array(),
		) 
	);

endif; // End check for breadcrumb support. 
*/
?>