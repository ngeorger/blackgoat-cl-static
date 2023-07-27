<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_button_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'Cakecious Buton' , 'cakecious' ),
            'base'                    => 'tt_vc_button_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Cakecious Style Button.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
                array(
                    "type"       => "checkbox",
                    "heading"    => __ ( "Please click below button to add link and anchor text for the button.", 'cakecious' ),
                    "description"    => __ ( "This field is for information purpose only.", 'cakecious' ),
                    "param_name" => "inffoo3",
                    "value"      => 'ok'
                ),
				array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_html__("Button Link",'cakecious'),
					"param_name" => "btn_link",
                    'admin_label' => true,
					"value" => "",
			    ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_button_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_button_shortcode extends WPBakeryShortCode {

    }
}
