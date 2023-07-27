<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_aboutme_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC About me' , 'cakecious' ),
            'base'                    => 'tt_vc_aboutme_shortcode',
			"icon"                    => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Title",'cakecious'),
					"param_name" => "title",
                    'admin_label' => true,
					"value" => "",
			    ),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => esc_html__("Bold description",'cakecious'),
					"param_name" => "bold_desc",
                    'admin_label' => true,
					"value" => "",
			    ),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => esc_html__("Normal description",'cakecious'),
					"param_name" => "desc",
					"value" => "",
			    ),
				array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_html__("Button",'cakecious'),
					"description" => esc_html__("If you want a button on the bottom, enter anchor text and link here. Leave as it is for no button.",'cakecious'),
					"param_name" => "btn_link",
					"value" => "",
			    ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'cakecious' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'Image for this item. Size 875x550 preferred.', 'cakecious' ),
                ),

			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_aboutme_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_aboutme_shortcode extends WPBakeryShortCode {

    }
}
