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

<section class="latest_news_area">
    <div class="container">
        <div class="single_br_title">
	    <?php if( '' != $spl_field1 ) { ?>
            <h2><?php echo do_shortcode(wp_kses($spl_field1, cakecious_tt_allowed_tags())); ?></h2>
	    <?php } ?>
        </div>
        <div class="row">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>


            <div class="col-lg-4 col-md-6">
                <div class="l_news_item">
					<?php if ( has_post_thumbnail() ) : ?>
                    <div class="l_news_img">
                        <?php the_post_thumbnail('postsmall', array('class' => 'img-fluid')); ?>
                        <a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
                    </div>
					<?php endif; ?>
                    <div class="l_news_text">
                        <?php the_title( sprintf( '<a href="%s" rel="bookmark"><h4>', esc_url( get_permalink() ) ), '</h4></a>' ); ?>
                        <p><?php cakecious_blv_excerpt_charlength('130'); ?></p>
                        <a class="more_btn" href="<?php the_permalink(); ?>"><?php esc_html_e('read more', 'cakecious'); ?></a>
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