<aside <?php hybrid_attr( 'sidebar', 'home-featured' ); ?>>
	<div class="wrap">

		<?php if ( is_active_sidebar( 'home-featured-title' ) ) : // If the sidebar has widgets. ?>

			<div class="home-featured-title">
				<?php dynamic_sidebar( 'home-featured-title' ); // Displays the home-featured-title sidebar. ?>
			</div>

		<?php endif; // End widgets check. ?>

		<?php if ( is_active_sidebar( 'home-featured' ) ) : // If the sidebar has widgets. ?>

			<div class="home-featured">
				<?php dynamic_sidebar( 'home-featured' ); // Displays the home-featured sidebar. ?>
			</div>

		<?php else : // If the sidebar has no widgets. ?>

			<div class="widget">
				<div class="wrap">
					<h3>Sidebar</h3>
					<p>Hier moeten widgets komen</p>
				</div>
			</div>

		<?php endif; // End widgets check. ?>

	</div>
</aside><!-- #sidebar-home-featured -->