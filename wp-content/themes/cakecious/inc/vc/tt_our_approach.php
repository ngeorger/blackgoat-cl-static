<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_our_approach_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Our Approach' , 'cakecious' ),
            'base'                    => 'tt_our_approach_shortcode',
			"icon"                    => 'tt-vc-block',
            'description'             => esc_html__( 'This block is used on homepage 2.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Main title",'cakecious'),
					"param_name" => "title",
                    'admin_label' => true,
					"value" => "",
			    ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'cakecious' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'This image appears on left side of the block.', 'cakecious' ),
                ),
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => esc_html__("Description",'cakecious'),
					"param_name" => "content",
					"value" => "",
			    ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Icon 1', 'cakecious' ),
                    'param_name' => 'icon1',
                    'value' => '',
                ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 1 label",'cakecious'),
					"param_name" => "label1",
					"value" => "",
			    ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 1 label line 2",'cakecious'),
					"param_name" => "label11",
					"value" => "",
			    ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Icon 2', 'cakecious' ),
                    'param_name' => 'icon2',
                    'value' => '',
                ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 2 label",'cakecious'),
					"param_name" => "label2",
					"value" => "",
			    ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 2 label line 2",'cakecious'),
					"param_name" => "label22",
					"value" => "",
			    ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Icon 3', 'cakecious' ),
                    'param_name' => 'icon3',
                    'value' => '',
                ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 3 label",'cakecious'),
					"param_name" => "label3",
					"value" => "",
			    ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 3 label line 2",'cakecious'),
					"param_name" => "label33",
					"value" => "",
			    ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_our_approach_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_our_approach_shortcode extends WPBakeryShortCode {

    }
}
