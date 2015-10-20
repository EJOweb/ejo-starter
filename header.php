<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>

<head>

<?php if ( is_active_sidebar( 'newsletter-popup' ) ) : // If newsletter-popup sidebar has widgets. ?>
	<?php gravity_form_enqueue_scripts(1, true); //* Force gravity forms javascript on each page (because of newsletter popup) ?>
<?php endif; // End widgets check. ?>

<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>

	<div id="container">

		<header <?php hybrid_attr( 'header' ); ?>> <?php // class="shrink" ?>
			<div class="wrap">

				<div <?php hybrid_attr( 'branding' ); ?>>
					<a href="<?php echo home_url( '/' ); ?>" rel="home" class="site-title"><img src="<?php echo THEME_IMG_URI; ?>logo.png"></a>
				</div><!-- #branding -->

				<!-- <span class="menu-toggle">Menu</span> -->

				<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>
			</div><!-- .wrap -->

		</header><!-- #header -->

		<?php hybrid_get_menu( 'mobile' ); // Loads the menu/primary.php template. ?>

		<div id="main" class="main">

			<div class="wrap">			
