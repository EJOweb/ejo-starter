<?php if (is_singular()) : ?>

	<div class="header-image-container">
		<?php the_post_thumbnail( 'large', array( 'class' => 'header-image' ) ); ?>
	</div>

<?php endif; ?>