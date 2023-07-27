<?php
/*
 * cakecious.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_feature2_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Features Block' , 'cakecious' ),
            'base'                    => 'tt_vc_feature2_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Features block with icon.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
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
					"heading" => esc_html__("Link the title. Beta",'cakecious'),
					"description" => esc_html__("If you want to link the title with above link, please check this box. If you leave unchecked , the Link label(you chose in above link) with link displays on bottom of feature box. NA on type 2.",'cakecious'),
					"param_name" => "link_title",
					"value" => "",
			    ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Type", 'cakecious'),
					'description' => esc_html__( 'Type 1 is for home page.', 'cakecious' ),
					"param_name" => "type",
					"value" => array(
						'Default' => 'default',
						'Type 1' => 'type1',
						'Type 2' => 'type2',
					)
				),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_feature2_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_feature2_shortcode extends WPBakeryShortCode {

    }
}
