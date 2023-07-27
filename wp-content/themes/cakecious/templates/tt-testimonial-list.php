<?php
/*
 * Template file for testimonial shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

$single_testi_pos = '';
?>

<section class="testimonials_item_area din_mod pb_100">
    <div class="container">
        <div class="testi_item_inner">
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
						if ( isset( $single_data2['_single_testi_heading'] ) ) {
							$single_testi_heading = $single_data2['_single_testi_heading'];
						}
					}
				?>
            <div class="media">
                <div class="d-flex">
                    <?php echo get_the_post_thumbnail( $post->ID, array( '80', '80' ), array( 'class' => 'rounded-circle' ) ); ?>
                    <h3>“</h3>
                </div>
                <div class="media-body">
					<?php the_content(); ?>
	                <h5>- <?php the_title(); ?></h5>
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


