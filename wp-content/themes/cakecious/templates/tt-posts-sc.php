<?php
/*
 * Template file for posts shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

?>
<div class="row">

	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>

			<div class="col-lg-6 col-md-6">
			    <div class="l_news_item">
					<?php if ( has_post_thumbnail() ) : ?>
			        <div class="l_news_img">
			            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('cakecious-postsmall', array('class' => 'img-fluid')); ?></a>
			        </div>
					<?php endif; ?>
			        <div class="l_news_text">
			            <a href="<?php the_permalink(); ?>"><h5><?php the_time( get_option( 'date_format' ) ); ?></h5></a>
			            <?php the_title( sprintf( '<a href="%s" rel="bookmark"><h4>', esc_url( get_permalink() ) ), '</h4></a>' ); ?>
				        <?php cakecious_tt_excerpt_charlength('130'); ?>
			        </div>
			    </div>
			</div>
				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . esc_html__( 'Posts not found', 'cakecious' ) . '</h4>';
		}
	?>
</div>
