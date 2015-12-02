<aside <?php hybrid_attr( 'sidebar', 'home' ); ?>>

	<div class="widget last-news">
		<div class="wrap">
			<article class="entry">
				<?php

				$last_posts = wp_get_recent_posts( array('numberposts' => 1));
				$last_post = $last_posts[0];
				$post_id = $last_post['ID'];

				$title = apply_filters( 'the_title', $last_post['post_title']);

				//* Get excerpt or content and filter it using 'get_the_excerpt'-filter
				$content = apply_filters('get_the_excerpt', $last_post['post_excerpt']);
				if (empty($content))
					$content = apply_filters('get_the_excerpt', $last_post['post_content']);

				$link = sprintf( '<a href="%s" title="%s" class="%s" rel="bookmark" itemprop="url">%s</a>', 
							get_the_permalink( $post_id ),
							get_the_title( $post_id ),
							'button',
							'Lees verder'
						);
				?>

				<div class="entry-byline">Laatste Nieuws</div>
				
				<header class="entry-header">
					<h3 class="entry-title"><?php echo $title; ?></h3>
				</header>
				
				<div class="entry-content">
					<p><?php echo wp_trim_words( $content, 30 ); ?></p>
				</div>
				
				<footer class="entry-footer">
					<?php echo $link; ?>
				</footer>

			</article>
		</div>
	</div>

</aside><!-- #sidebar-home -->