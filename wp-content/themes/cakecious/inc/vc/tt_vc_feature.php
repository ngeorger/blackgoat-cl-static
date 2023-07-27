<?php
/*
 * cakecious.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_feature_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Features Block' , 'cakecious' ),
            'base'                    => 'tt_vc_feature_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Features block for this theme.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Insert Graphic", 'cakecious'),
					'description' => esc_html__( 'Do you want to insert image or icon on this infobox.', 'cakecious' ),
					"param_name" => "insert_graphic",
					"value" => array(
						'No' => 'no',
						'Image only' => 'image',
						'Icon only' => 'icon',
					)
				),
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
					'dependency' => array(
						'element' => 'insert_graphic',
						'value' => 'icon',
					),
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'cakecious' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'cakecious' ),
					'dependency' => array(
						'element' => 'insert_graphic',
						'value' => 'image',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'cakecious' ),
					'param_name' => 'img_size',
					'value' => 'thumbnail',
					'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'cakecious' ),
					'dependency' => array(
						'element' => 'insert_graphic',
						'value' => array( 'image', 'featured_image' ),
					),
				),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'cakecious' ),
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
					"type" => "dropdown",
					"heading" => esc_html__("Type", 'cakecious'),
					'description' => esc_html__( 'Type 1 is for home page. .', 'cakecious' ),
					"param_name" => "type",
					"value" => array(
						'Default' => 'default',
						'Type 2' => 'type2',
						'Type 3' => 'type3',
					)
				),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_feature_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_feature_shortcode extends WPBakeryShortCode {

    }
}
