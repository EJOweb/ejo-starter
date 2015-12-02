<aside <?php hybrid_attr( 'sidebar', 'home-contact' ); ?>>
	<div class="wrap">

		<?php if ( is_active_sidebar( 'home-contact' ) ) : // If the sidebar has widgets. ?>

			<?php dynamic_sidebar( 'home-contact' ); // Displays the home-contact sidebar. ?>

		<?php else : // If the sidebar has no widgets. ?>

			<div class="widget">
				<div class="wrap">
					<h3>Sidebar</h3>
					<p>Hier moeten widgets komen</p>
				</div>
			</div>

		<?php endif; // End widgets check. ?>

	</div>
</aside><!-- #sidebar-home-contact -->