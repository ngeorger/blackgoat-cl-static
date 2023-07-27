<?php
/*
 * Templatation.com
 *
 *
 */

function tt_vc_home1contact_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Home Contact' , 'cakecious' ),
            'base'                    => 'tt_vc_home1contact_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Contact form with image.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(

		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Enter Contact form 7 shortcode.', 'cakecious' ),
							'param_name'	=> 'cf7code',
							'value'	        => '',
							'admin_label'	=> true,
						),
		                array(
		                    'type' => 'attach_image',
		                    'heading' => esc_html__( 'Image', 'cakecious' ),
		                    'param_name' => 'image',
		                    'value' => '',
		                    'description' => esc_html__( 'This image appears as background on right side. for team member. Size 845x550  preferred.', 'cakecious' ),
		                ),
		                array(
							'type'			=> 'textarea',
							'heading'		=> esc_html__( 'Enter title.', 'cakecious' ),
							'param_name'	=> 'title',
							'value'	        => '',
							'admin_label'	=> true,
						),
		                array(
							'type'			=> 'textarea',
							'heading'		=> esc_html__( 'Description. NA on Home 3.', 'cakecious' ),
							'param_name'	=> 'description',
							'value'			=> '',
							'admin_label'	=> true,
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Type", 'cakecious'),
							'description' => esc_html__( 'Different types are used on particular homepage.', 'cakecious' ),
							"param_name" => "type",
							"value" => array(
								'Default Home 1' => 'default',
								'Home 3' => 'type2',
							)
						),
	                )
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_home1contact_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_home1contact_shortcode extends WPBakeryShortCode {

    }
}
