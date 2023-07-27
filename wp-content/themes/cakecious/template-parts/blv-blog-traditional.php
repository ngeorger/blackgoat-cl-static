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
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
	?>
		<?php get_template_part( 'inc/theme-helpers/overrides/entry-excerpt' ); ?>

<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . esc_html__( 'Posts not found', 'cakecious' ) . '</h4>';
		}
	?>


