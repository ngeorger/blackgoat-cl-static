<?php
if ( ! defined( 'ABSPATH' ) ) exit;
add_shortcode( 'cakecious_hero', 'cakecious_hero_sc' );

if( !function_exists( 'cakecious_hero_sc' )) {
	function cakecious_hero_sc( $atts = null, $content = null ) {
		// Prepare error var
		$error = null;
		// Parse attributes
		$atts = shortcode_atts( array(
			'template'            => 'templates/cakecious-hero-sc.php',
			'heading'             => '',
			'content'             => '',
			'image'               => '',
			'color'               => '',
			'yoast_bdcmp'         => false,
			'block_padding_top'   => '',
			'block_padding_bottom'=> '',
		), $atts, 'cakecious_hero' );

		$original_atts = $atts;

		$heading                    = sanitize_text_field( $atts['heading'] );
		$content                    = esc_textarea( $atts['content'] );
		$image                      = esc_url( $atts['image'] );
		$color                      = sanitize_text_field( $atts['color'] );
		$yoast_bdcmp                = sanitize_text_field( $atts['yoast_bdcmp'] );
		$block_padding_top          = sanitize_text_field( $atts['block_padding_top'] );
		$block_padding_bottom       = sanitize_text_field( $atts['block_padding_bottom'] );

		// Save original posts
		global $posts;
		$original_posts = $posts;
		$temptt_hero_vars = array(
			'temptt_heading'               => $heading,
			'temptt_content'               => $content,
			'temptt_image'                 => $image,
			'temptt_color'                 => $color,
			'temptt_yoast_bdcmp'           => $yoast_bdcmp,
			'temptt_block_padding_top'     => $block_padding_top,
			'temptt_block_padding_bottom'  => $block_padding_bottom
		);
		set_query_var('temptt_hero_vars', $temptt_hero_vars);
		// Query posts
		//$posts = new WP_Query( $args );
		// Buffer output
		ob_start(); ?>
		<?php
		// Search for template in stylesheet directory
		if ( file_exists( STYLESHEETPATH . '/' . $atts['template'] ) ) {
			load_template( STYLESHEETPATH . '/' . $atts['template'], false );
		} // Search for template in theme directory
		elseif ( file_exists( TEMPLATEPATH . '/' . $atts['template'] ) ) {
			load_template( TEMPLATEPATH . '/' . $atts['template'], false );
		} // Search for template in plugin directory
		elseif ( path_join( dirname( __FILE__ ), 'templates/cakecious-hero-sc.php' ) ) {
			load_template( path_join( dirname( __FILE__ ), 'templates/cakecious-hero-sc.php' ), false );
		} // Template not found
		else {
			echo Su_Tools::error( __FUNCTION__, __( 'template not found', 'cakecious' ) );
		}
		?>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		// Return original posts
		$posts = $original_posts;
		// Reset the query
		wp_reset_postdata();

		return $output;
	} //cakecious_hero_sc()
} //cakecious_hero_sc()