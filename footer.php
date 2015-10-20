			</div><!-- .wrap -->
		</div><!-- #main -->

		<footer <?php hybrid_attr( 'footer' ); ?>>
			<div class="wrap">

			<?php dynamic_sidebar( 'footer' ); // Displays the primary sidebar. ?>	

			</div><!-- .wrap -->
		</footer><!-- #footer -->

	</div><!-- #container -->

	<?php locate_template( array( 'misc/newsletter-popup.php' ), true ); // Loads the misc/newsletter-popup.php template. ?>

	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

	<script type='text/javascript'>
		jQuery(document).ready(function($){
			var cookieName2 = 'studioredd-newsletter-popup';
			// Cookies.set( cookieName2, true, { expires: 365 * 5 });
			console.log( Cookies.get(cookieName2) );
			// console.log( Cookies.getJSON(cookieName2) );
		});
	</script>

</body>
</html>