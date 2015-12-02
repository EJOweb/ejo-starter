<aside <?php hybrid_attr( 'sidebar', 'primary' ); ?>>

	<?php if ( class_exists('EJO_Dynamic_Sidebars') && is_active_sidebar( EJO_Dynamic_Sidebars::get_sidebar_id() )) : // Check if plugin is installed and if chosen sidebar is active ?>

		<?php dynamic_sidebar( EJO_Dynamic_Sidebars::get_sidebar_id() ); // Displays the selected sidebar. ?>

	<?php else : ?>

		<?php if ( is_active_sidebar( 'sidebar-primary' ) ) : // If the sidebar has widgets. ?>

				<?php dynamic_sidebar( 'sidebar-primary' ); // Displays the default sidebar. ?>

		<?php else : // If the sidebar has no widgets. ?>

			<div class="widget">
				<div class="wrap">
					<h3>Sidebar</h3>
					<p>Hier moeten widgets komen</p>
				</div>
			</div>

		<?php endif; // End widgets check. ?>

	<?php endif; // End EJO_Dynamic_Sidebars class and chosen sidebar active check. ?>

</aside><!-- #sidebar-primary -->
