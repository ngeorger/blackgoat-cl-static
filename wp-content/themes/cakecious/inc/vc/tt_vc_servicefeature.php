<?php
/*
 * Templatation.com
 *
 */

function tt_vc_servicefeature_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Service Features' , 'cakecious' ),
            'base'                    => 'tt_vc_servicefeature_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Features block used on service single page.', 'cakecious' ),
            'as_parent'               => array('only' => 'tt_vc_servicefeature_item_shortcode'),
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
add_action( 'vc_before_init', 'tt_vc_servicefeature_fn_vc' );
// Nested Element
function tt_vc_servicefeature_item_fn_vc() {
    vc_map(
        array(
            'name'            => esc_html__('CKC Service Features Content', 'cakecious'),
            'base'            => 'tt_vc_servicefeature_item_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
            'content_element' => true,
            'as_child'        => array('only' => 'tt_vc_servicefeature_shortcode'), // Use only|except attributes to limit parent (separate multiple values with comma)
			"params" => array(
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'cakecious' ),
					'param_name' => 'icon1',
					'value' => 'fa fa-adjust', // default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'description' => esc_html__( 'Select icon from library.', 'cakecious' ),
				),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Custom icon', 'cakecious' ),
                    'description'     => esc_html__( 'This theme comes with few special icons, if you know the code, enter here. Please note if you enter anything here, the above field will no longer work.', 'cakecious' ),
                    'param_name'  => 'customicon',
                    'admin_label' => true,
                    'value'       => '',
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
					"type" => "checkbox",
					"class" => "",
					"heading" => esc_html__("Gray BG ?",'cakecious'),
					"param_name" => "gray_bg",
					"value" => "",
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
add_action( 'vc_before_init', 'tt_vc_servicefeature_item_fn_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tt_vc_servicefeature_shortcode extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_servicefeature_item_shortcode extends WPBakeryShortCode {

    }
}
