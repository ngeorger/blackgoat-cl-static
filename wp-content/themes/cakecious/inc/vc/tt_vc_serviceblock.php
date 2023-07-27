<?php
/*
 * cakecious.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_serviceblock_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Service Block' , 'cakecious' ),
            'base'                    => 'tt_vc_serviceblock_shortcode',
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
					'value' => 'full',
					'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 222x222 (Width x Height)). Please try to upload image in square format.', 'cakecious' ),
				),
                array(
                    'type'        => 'vc_link',
                    'heading'     => esc_html__( 'The title and Link', 'cakecious' ),
                    'param_name'  => 'btn_link',
                    'value'       => '',
                ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_serviceblock_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_serviceblock_shortcode extends WPBakeryShortCode {

    }
}
