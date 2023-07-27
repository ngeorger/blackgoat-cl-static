<?php
/*
 * cakecious.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_newarr_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC New Arrivals' , 'cakecious' ),
            'base'                    => 'tt_vc_newarr_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'cakecious' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library. Size 370x380 preferred.', 'cakecious' ),
					'dependency' => array(
						'element' => 'insert_graphic',
						'value' => 'image',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price', 'cakecious' ),
					'param_name' => 'price',
					'description' => esc_html__( 'Enter price of product the above image is of. Please include currency also. eg $40', 'cakecious' ),
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
                    'heading'     => esc_html__( 'Subtitle', 'cakecious' ),
                    'param_name'  => 'subtitle',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'        => 'vc_link',
                    'heading'     => esc_html__( 'Link', 'cakecious' ),
                    'param_name'  => 'btn_link',
                    'value'       => '',
                ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_newarr_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_newarr_shortcode extends WPBakeryShortCode {

    }
}
