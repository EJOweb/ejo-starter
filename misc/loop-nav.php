<?php if ( is_home() || is_archive() || is_search() ) : // If viewing the blog, an archive, or search results. ?>

	<?php the_posts_pagination(
		array( 
			'prev_text' => esc_html( '&larr; Vorige' ), 
			'next_text' => esc_html( 'Volgende &rarr;' )
		) 
	); ?>

<?php endif; // End check for type of page being viewed. ?>