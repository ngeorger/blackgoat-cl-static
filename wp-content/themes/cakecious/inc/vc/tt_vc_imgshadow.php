<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_imgshadow_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Image special' , 'cakecious' ),
            'base'                    => 'tt_vc_imgshadow_shortcode',
			"icon"                    => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(

                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'cakecious' ),
                    'param_name' => 'image',
                    'value' => '',
	                'admin_label'	=> true,
                    'description' => esc_html__( 'Image for this item. Size 300x400 preferred for Shadow image, 840x330 for default.', 'cakecious' ),
                ),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Type', 'cakecious' ),
					'param_name'	=> 'type',
					'description'	=> esc_html__( 'There are few type of image display in this theme, choose here.', 'cakecious' ),
					'value' 		=> array(
						esc_html__(' Default (recommended)', 'cakecious')	 => 'default',
						esc_html__(' With Shadow', 'cakecious')	 => 'type2',
					)
				),

			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_imgshadow_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_imgshadow_shortcode extends WPBakeryShortCode {

    }
}
