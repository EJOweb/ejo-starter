<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'primary-mobile' ); ?>>
		<div class="wrap">
			<div class="menu-toggle">Menu</div>

			<?php wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'       => '',
					'menu_id'         => 'menu-primary-mobile-items',
					'menu_class'      => 'menu-items menu-mobile',
					'fallback_cb'     => '',
					'items_wrap'      => '<ul id="%s" class="%s">%s</ul>'
				)
			); ?>

		</div><!-- wrap -->
	</nav><!-- #menu-primary -->

<?php endif; // End check for menu. ?>