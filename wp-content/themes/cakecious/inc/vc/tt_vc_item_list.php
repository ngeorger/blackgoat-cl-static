<?php
/*
 * cakecious.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_item_list_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Menu Item List' , 'cakecious' ),
            'base'                    => 'tt_vc_item_list_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Features block with icon.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'cakecious' ),
                    'description'     => esc_html__( 'Enter the title.', 'cakecious' ),
                    'param_name'  => 'title',
					'admin_label'	=> true,
                    'value'       => '',
                ),
                array(
                    'type'        => 'textarea_html',
                    'heading'     => esc_html__( 'Description', 'cakecious' ),
                    'param_name'  => 'content',
                    'value'       => '',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Price', 'cakecious' ),
                    'description'     => esc_html__( 'Enter the price of item. Please include the currency too. eg $6.90', 'cakecious' ),
                    'param_name'  => 'price',
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
				array(
					"type" => "checkbox",
					"class" => "",
					"heading" => esc_html__("Link the title",'cakecious'),
					"description" => esc_html__("If you want to link the title with above link, please check this box. If you leave unchecked , the Link label(you chose in above link) with link displays on bottom of feature box.",'cakecious'),
					"param_name" => "link_title",
					"value" => "",
			    ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_item_list_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_item_list_shortcode extends WPBakeryShortCode {

    }
}
