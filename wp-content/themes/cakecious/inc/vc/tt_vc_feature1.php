<?php
/*
 * cakecious.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_feature1_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Home 1 Image Block' , 'cakecious' ),
            'base'                    => 'tt_vc_feature1_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
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
					'value' => '370x215',
					'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'cakecious' ),
				),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'cakecious' ),
                    'param_name'  => 'title',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Link', 'cakecious' ),
                    'param_name'  => 'link',
                    'value'       => '',
                ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_feature1_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_feature1_shortcode extends WPBakeryShortCode {

    }
}
