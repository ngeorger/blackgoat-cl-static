<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_bforafter_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Before-after' , 'cakecious' ),
            'base'                    => 'tt_vc_bforafter_shortcode',
			"icon"                    => 'tt-vc-block',
            'description'             => esc_html__( 'Title in Cakecious theme style.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'cakecious' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'Image for this item. Size 230x290 preferred.', 'cakecious' ),
                ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Title",'cakecious'),
					"param_name" => "title",
                    'admin_label' => true,
					"value" => "",
			    ),

			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_bforafter_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_bforafter_shortcode extends WPBakeryShortCode {

    }
}
