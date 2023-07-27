<?php
/*
 * Template file for posts shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */
if( is_array($temptt_t_vars) ) {
	$temptt_spl_vars2 = json_decode( $temptt_t_vars['temptt_var1'], true );
	if( is_array($temptt_spl_vars2) ) {
		extract( $temptt_spl_vars2 );
	}
}
/*
 * $spl_field1 is title.
 * $spl_field2 is button.
 * $spl_field3 is button target.
 * $spl_field4 is button link.
 */
?>

<section class="blog_grid_area">
    <div class="container">
        <div class="row grid_blog_inner">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>


            <div class="col-lg-6">
                <div class="grid_blog">
	                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="grid_img">
                        <?php the_post_thumbnail('postsmall', array('class' => 'img-fluid')); ?>
                    </div>
	                <?php endif; ?>
                    <div class="grid_text">
                        <a class="date" href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
	                    <?php the_title( sprintf( '<a href="%s" rel="bookmark"><h4>', esc_url( get_permalink() ) ), '</h4></a>' ); ?>
                        <p><?php cakecious_blv_excerpt_charlength('130'); ?></p>
	                    <a class="more_btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Continue reading', 'cakecious'); ?></a>
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
    </div>
</section>