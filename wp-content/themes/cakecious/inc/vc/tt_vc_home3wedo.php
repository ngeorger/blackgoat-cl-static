<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_home2wedo_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC What we do' , 'cakecious' ),
            'base'                    => 'tt_vc_home2wedo_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'What we do carousel.', 'cakecious' ),
            'as_parent'               => array('only' => 'tt_vc_home2wedo_item_shortcode'),
            'content_element'         => true,
            "js_view" => 'VcColumnView',
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
                    'type'        => 'textarea',
                    'heading'     => esc_html__( 'Description', 'cakecious' ),
                    'param_name'  => 'desc',
                ),
                array(
                    "type"       => "checkbox",
                    "heading"    => __ ( "Please click Save button below and then select its child shortcode to enter items.", 'cakecious' ),
                    "description"    => __ ( "Above field is for information purpose only.", 'cakecious' ),
                    "param_name" => "inffoo3",
                    "value"      => 'ok'
                ),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Type', 'cakecious' ),
					'param_name'	=> 'type',
					'description'	=> esc_html__( 'There are 2 type of titles in this theme, choose here.', 'cakecious' ),
					'value' 		=> array(
						esc_html__(' Default (recommended)', 'cakecious')	 => 'default',
						esc_html__(' Black Title', 'cakecious')	 => 'type2',
					)
				),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_home2wedo_fn_vc' );
// Nested Element
function tt_vc_home2wedo_item_fn_vc() {
    vc_map(
        array(
            'name'            => esc_html__('What we do items', 'cakecious'),
            'base'            => 'tt_vc_home2wedo_item_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
            'content_element' => true,
            'as_child'        => array('only' => 'tt_vc_home2wedo_shortcode'), // Use only|except attributes to limit parent (separate multiple values with comma)
            'params'          => array(
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
                    'description' => esc_html__( 'Image for this item. Size 270x290 preferred.', 'cakecious' ),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Link', 'cakecious' ),
                    'param_name'  => 'link',
                    'admin_label' => true,
                    'value'       => '',
                ),
            ),

        )
    );
}
add_action( 'vc_before_init', 'tt_vc_home2wedo_item_fn_vc' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tt_vc_home2wedo_shortcode extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_home2wedo_item_shortcode extends WPBakeryShortCode {

    }
}