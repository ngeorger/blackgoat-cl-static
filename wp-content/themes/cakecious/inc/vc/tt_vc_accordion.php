<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_accordion_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Accordion' , 'cakecious' ),
            'base'                    => 'tt_vc_accordion_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Accordion Set', 'cakecious' ),
            'as_parent'               => array('only' => 'tt_vc_accordion_item_shortcode'),
            'content_element'         => true,
            "js_view" => 'VcColumnView',
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
                    array(
                        "type"       => "checkbox",
                        "heading"    => __ ( "Please click Save button below and then select its child shortcode to enter items.", 'cakecious' ),
                        "description"    => __ ( "Above field is for information purpose only.", 'cakecious' ),
                        "param_name" => "inffoo3",
                        "value"      => 'ok'
                    ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_accordion_fn_vc' );
// Nested Element
function tt_vc_accordion_item_fn_vc() {
    vc_map(
        array(
            'name'            => esc_html__('Accordion Content', 'cakecious'),
            'base'            => 'tt_vc_accordion_item_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
            'content_element' => true,
            'as_child'        => array('only' => 'tt_vc_accordion_shortcode'), // Use only|except attributes to limit parent (separate multiple values with comma)
            'params'          => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Accordion Title', 'cakecious' ),
                    'param_name'  => 'title',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'        => 'textarea_html',
                    'heading'     => esc_html__( 'Accordion Content', 'cakecious' ),
                    'param_name'  => 'content',
                ),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Active by default', 'cakecious' ),
					'param_name'	=> 'active',
					'description'	=> esc_html__( 'Keep this open on page load? Please make sure you only choose Yes in one of the items.', 'cakecious' ),
					'value' 		=> array(
						esc_html__(' No', 'cakecious')	 => 'no',
						esc_html__(' Yes', 'cakecious')	 => 'yes',
					)
				),
            ),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_accordion_item_fn_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tt_vc_accordion_shortcode extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_accordion_item_shortcode extends WPBakeryShortCode {

    }
}