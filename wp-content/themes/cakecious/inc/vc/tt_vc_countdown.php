<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_countdown_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Countdown' , 'cakecious' ),
            'base'                    => 'tt_vc_countdown_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Number', 'cakecious' ),
                    'param_name'  => 'number',
                    'admin_label' => true,
                    'value'       => '',
                ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Label",'cakecious'),
					"param_name" => "label",
                    'admin_label' => true,
					"value" => "",
			    ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_countdown_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_countdown_shortcode extends WPBakeryShortCode {

    }
}
