<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_splrecipe_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Special Recipe' , 'cakecious' ),
            'base'                    => 'tt_vc_splrecipe_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Can be used to display any kind of data', 'cakecious' ),
            'as_parent'               => array('only' => 'tt_vc_splrecipe_item_shortcode'),
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
add_action( 'vc_before_init', 'tt_vc_splrecipe_fn_vc' );
// Nested Element
function tt_vc_splrecipe_item_fn_vc() {
    vc_map(
        array(
            'name'            => esc_html__('CKC Special Recipe Content', 'cakecious'),
            'base'            => 'tt_vc_splrecipe_item_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
            'content_element' => true,
            'as_child'        => array('only' => 'tt_vc_splrecipe_shortcode'), // Use only|except attributes to limit parent (separate multiple values with comma)
            'params'          => array(
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'cakecious' ),
                    'param_name' => 'image',
                    'value' => '',
	                'admin_label'	=> true,
                    'description' => esc_html__( 'Image for this item. Size 300x400 preferred for Shadow image, 840x330 for default.', 'cakecious' ),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'cakecious' ),
                    'description'     => esc_html__( 'On few types, the below button Label also appears as title.', 'cakecious' ),
                    'param_name'  => 'title',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'        => 'textarea_html',
                    'heading'     => esc_html__( 'Description', 'cakecious' ),
                    'param_name'  => 'content',
                    'value'       => '',
                ),
				array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_html__("Link",'cakecious'),
					"description" => esc_html__("If you want a link on the bottom, enter anchor text and link here. Leave as it is for no link.",'cakecious'),
					"param_name" => "btn_link",
					"value" => "",
			    ),
            ),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_splrecipe_item_fn_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tt_vc_splrecipe_shortcode extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_splrecipe_item_shortcode extends WPBakeryShortCode {

    }
}