<?php
/*
 * Templatation.com
 *
 *
 */

function tt_vc_cta_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC CTA' , 'cakecious' ),
            'base'                    => 'tt_vc_cta_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Add Call to Action block.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(

		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Title', 'cakecious' ),
							'param_name'	=> 'title',
							'value'	        => '',
							'admin_label'	=> true,
						),
		                array(
							'type'			=> 'textarea',
							'heading'		=> esc_html__( 'Subtitle', 'cakecious' ),
							'param_name'	=> 'subtitle',
							'value'			=> '',
							'admin_label'	=> true,
						),
/*		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Call now text', 'cakecious' ),
							'param_name'	=> 'callnowtxt',
							'value'			=> 'Call Now :',
						),
		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Phone number', 'cakecious' ),
							'param_name'	=> 'callnowvalue',
						),
		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Or text', 'cakecious' ),
							'param_name'	=> 'ortxt',
							'value'			=> 'OR',
						),*/
						array(
							"type" => "vc_link",
							"class" => "",
							"heading" => esc_html__("Button Link",'cakecious'),
							"param_name" => "btn_link",
		                    'admin_label' => true,
							"value" => "",
					    ),
	                )
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_cta_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_cta_shortcode extends WPBakeryShortCode {

    }
}
