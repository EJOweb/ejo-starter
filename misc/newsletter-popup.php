<?php if ( is_active_sidebar( 'newsletter-popup' ) ) : // If newsletter-popup sidebar has widgets. ?>
	<div id="popup-1" class="slickModal">
		<div class="window">
			<?php dynamic_sidebar( 'newsletter-popup' ); // Displays the newsletter-popup sidebar. ?>
		</div>
	</div>
<?php endif; // End widgets check. ?>