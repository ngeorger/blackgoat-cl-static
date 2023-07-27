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

<section class="home_blog_area blog_three">
    <div class="container">
        <div class="blog_title justify-content-between d-flex">
	    <?php if( '' != $spl_field1 ) { ?>
            <h2><?php echo do_shortcode(wp_kses($spl_field1, cakecious_tt_allowed_tags())); ?></h2>
	    <?php } ?>
	    <?php if( '' != $spl_field2 ) { ?>
			<a href="<?php echo esc_url($spl_field4); ?>" <?php echo( ! empty( $spl_field3 ) ? ' target="' . $spl_field3 . '"' : '' ) ?> ><?php echo wp_kses($spl_field2, cakecious_tt_allowed_tags()); ?></a>
	    <?php } ?>
        </div>
        <div class="blog_three_inner">
			<div class="row">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>


				<div class="col-lg-4">
					<div class="h_blog_item">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="blog_img">
								<?php the_post_thumbnail('postsmall', array('class' => 'img-fluid')); ?>
								<?php echo cakecious_blv_get_cats('single'); ?>
							</div>
						<?php endif; ?>
						<div class="blog_text">
							<?php the_title( sprintf( '<a href="%s" rel="bookmark"><h3>', esc_url( get_permalink() ) ), '</h3></a>' ); ?>
							<a class="date" href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
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
    </div>
</section>