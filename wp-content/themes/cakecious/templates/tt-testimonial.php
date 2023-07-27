<?php
/*
 * Template file for testimonial shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

$single_testi_pos = '';
?>
<div class="client_says_inner">
    <div class="c_says_title">
        <h2><?php echo esc_html($temptt_t_vars['temptt_var1']); ?></h2>
    </div>
    <div class="client_says_slider owl-carousel">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>
				<?php
					$single_data2 = $single_testi_pos = '';
					if( !empty($post->ID)) {
						$single_data2 = get_post_meta( $post->ID, '_tt_meta_page_opt', true );
					}
					if( is_array($single_data2) ) {
						if ( isset( $single_data2['_single_testi_heading'] ) ) {
							$single_testi_heading = $single_data2['_single_testi_heading'];
						}
					}
				?>

        <div class="item">
            <div class="media">
                <div class="d-flex">
	                <?php if( !empty($post->ID) && has_post_thumbnail($post->ID)) { ?>
                    <?php the_post_thumbnail( '', array( '80', '80' ), array( 'class' => 'rounded-circle' ) ); ?>
	                <?php } ?>
                    <h3>“</h3>
                </div>
                <div class="media-body">
					<?php the_content(); ?>
	                <h5>- <?php the_title(); ?></h5>
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
