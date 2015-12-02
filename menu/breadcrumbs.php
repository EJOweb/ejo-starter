<?php 
if (!is_front_page()) : // check if front-page

	if ( function_exists('yoast_breadcrumb') ) {

		yoast_breadcrumb(
			'<p class="breadcrumb-trail breadcrumbs">',
			'</p>'
		);

	}
endif; // end front-page check
?>