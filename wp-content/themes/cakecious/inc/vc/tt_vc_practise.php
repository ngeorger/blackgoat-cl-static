<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_practise_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Practise' , 'cakecious' ),
            'base'                    => 'tt_vc_practise_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Practise area block.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'cakecious' ),
                    'param_name'  => 'title',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'cakecious' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'Select image from media library. Size 250x250 preferred.', 'cakecious' ),
                ),
				array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_html__("Link",'cakecious'),
					"param_name" => "btn_link",
					"value" => "",
			    ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_practise_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_practise_shortcode extends WPBakeryShortCode {

    }
}
