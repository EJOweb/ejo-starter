<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php if ( have_posts() ) : // Checks if any posts were found. ?>

	<?php locate_template( array( 'misc/header-image.php' ), true ); // Loads the misc/header-image.php template. ?>

	<?php redd_language_module(); ?>

	<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>

		<?php if ( hybrid_is_plural() ) : ?>

			<?php locate_template( array( 'misc/archive-header.php' ), true ); // Loads the misc/archive-header.php template. ?>

		<?php endif; ?>

		<?php while ( have_posts() ) : // Begins the loop through found posts. ?>

			<?php the_post(); // Loads the post data. ?>

			<?php hybrid_get_content_template(); // Loads the content/*.php template. ?>

		<?php endwhile; // End found posts loop. ?>

		<?php locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>

	<?php else : // If no posts were found. ?>

		<?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>

	<?php endif; // End check for posts. ?>
	
	<div class="team">
		<?php dynamic_sidebar( 'team' ); // Displays the team sidebar. ?>	
	</div>

	<div class="after-content">
		<?php dynamic_sidebar( 'after-content' ); // Displays the after-content sidebar. ?>	
	</div>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>