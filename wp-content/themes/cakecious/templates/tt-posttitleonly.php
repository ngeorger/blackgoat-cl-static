<?php
/*
 * Template file for posts shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

?>
<div class="line_news">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>
					<div class="single-post-list">
						<?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
						<h4><?php the_time( get_option( 'date_format' ) ); ?></h4>
					</div><!-- /.single-post-list -->

				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . esc_html__( 'Posts not found', 'cakecious' ) . '</h4>';
		}
	?>
</div>

