<?php
/*
 * Templatation.com
 *
 *
 */

function tt_vc_video_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Video' , 'cakecious' ),
            'base'                    => 'tt_vc_video_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Add video popup on image.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(

		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Title', 'cakecious' ),
							'param_name'	=> 'title',
							'description'	=> esc_html__( 'This title appears after the play icon.', 'cakecious' ),
							'value'			=> '',
						),
		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Video link', 'cakecious' ),
							'description'	=> esc_html__( 'Enter video link, this opens in a popup.', 'cakecious' ),
							'param_name'	=> 'videolink',
							'value'	        => '',
							'admin_label'	=> true,
						),
	                )
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_video_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_video_shortcode extends WPBakeryShortCode {

    }
}