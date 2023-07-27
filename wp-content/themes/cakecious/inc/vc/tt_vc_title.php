<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_title_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Title' , 'cakecious' ),
            'base'                    => 'tt_vc_title_shortcode',
			"icon"                    => 'tt-vc-block',
            'description'             => esc_html__( 'Title in Cakecious theme style.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Main title",'cakecious'),
					"param_name" => "title",
                    'admin_label' => true,
					"value" => "",
			    ),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => esc_html__("Description",'cakecious'),
					"param_name" => "desc",
					"value" => "",
			    ),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Type', 'cakecious' ),
					'param_name'	=> 'type',
					'description'	=> esc_html__( 'There are few type of titles in this theme, choose here.', 'cakecious' ),
					'value' 		=> array(
						esc_html__(' Default (recommended)', 'cakecious')	 => 'default',
						esc_html__(' Type 1', 'cakecious')		             => 'type1',
						esc_html__(' Type 2', 'cakecious')		             => 'type2',
						esc_html__(' Type 3', 'cakecious')		             => 'type3',
					)
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Color', 'cakecious' ),
					'param_name'	=> 'color',
					'value' 		=> array(
						esc_html__(' Default (recommended)', 'cakecious')	 => 'default',
						esc_html__(' White', 'cakecious')		             => 'white',
					),
					'dependency' => array(
						'element' => 'type',
						'value' => 'type3',
					),
				),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_title_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_title_shortcode extends WPBakeryShortCode {

    }
}
