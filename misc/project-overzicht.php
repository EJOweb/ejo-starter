<?php 

$query_args = array(
	'post_type'  => 'page', 
	'posts_per_page' => -1,
	'post_parent' => get_the_ID(),
    'meta_query' => array( 
        array(
            'key'   => '_wp_page_template', 
            'value' => 'template-project.php'
        )
    )
);

$child_projects = new WP_Query( $query_args ); 

if ( $child_projects->have_posts() ) :

	echo '<div class="project-overzicht columns columns-3">';

	while ( $child_projects->have_posts() ) : 

		$child_projects->the_post(); 

		echo '<article class="entry">';

			get_the_image( array( 'size' => 'medium', 'link_class' => 'thumbnail-wrap' ) );

			echo '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';

		echo '</article>';

	endwhile; // End found posts loop.

	echo '</div>';

endif; // End check for posts.

wp_reset_postdata();

?>