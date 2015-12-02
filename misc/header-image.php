<?php if (is_singular()) : ?>

	<?php if (has_post_thumbnail()) : ?>
	
		<div class="header-image-container">
			<?php the_post_thumbnail( 'page-header', array( 'class' => 'header-image' ) ); ?>
		</div>
		
	<?php endif; ?>

<?php endif; ?>