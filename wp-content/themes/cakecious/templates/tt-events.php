<?php
/*
 * Template file for testimonial shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

$single_testi_pos = $ht_event_time = $ht_event_loc = '';
?>
<section class="events_area">
    <div class="container">
        <div class="row events_row">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>
				<?php
					$single_data2 = $single_testi_pos = '';
					$single_data2 = get_post_meta( $post->ID, '_tt_meta_page_opt', true );
					if( is_array($single_data2) ) {
						if ( isset( $single_data2['_ht_event_time'] ) ) {
							$ht_event_time = $single_data2['_ht_event_time'];
						}
						if ( isset( $single_data2['_ht_event_loc'] ) ) {
							$ht_event_loc = $single_data2['_ht_event_loc'];
						}
					}
				?>

           <!-- Event Items -->
            <div class="col-lg-6">
                <div class="event">
                    <a href="<?php the_permalink(); ?>" class="event_img"><?php echo get_the_post_thumbnail( $post->ID, 'cakecious-event' ); ?></a>
                    <div class="media">
                        <h3><?php the_time('d'); ?> <span><?php the_time('M'); ?></span></h3>
                        <div class="media-body">
                            <?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
                            <span><i class="icon icon-Timer"></i><?php echo esc_html($ht_event_time); ?></span>
                            <h6><i class="fa fa-map-marker"></i><?php echo esc_html($ht_event_loc); ?></h6>
                        </div>
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