<?php
/*
 * Templatation.com
 *
 *
 */

function tt_vc_comingsoon_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Coming Soon Content' , 'cakecious' ),
            'base'                    => 'tt_vc_comingsoon_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(

		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Title', 'cakecious' ),
							'param_name'	=> 'title',
							'value'			=> 'Coming',
							'admin_label'	=> true,
						),
		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Date', 'cakecious' ),
							'param_name'	=> 'date',
							'value'			=> '2019/07/12',
							'description'	=> esc_html__( 'Date of launch. in YYYY/DD/MM format.', 'cakecious' ),
							'admin_label'	=> true,
						),
						array(
							'type'			=> 'textarea',
							'heading'		=> esc_html__( 'Description', 'cakecious' ),
							'param_name'	=> 'desc',
						),
	                )
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_comingsoon_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_comingsoon_shortcode extends WPBakeryShortCode {

    }
}
