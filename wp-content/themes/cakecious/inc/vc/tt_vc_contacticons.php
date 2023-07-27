<?php
/*
 * cakecious.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_contacticons_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Contact blocks' , 'cakecious' ),
            'base'                    => 'tt_vc_contacticons_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Contact us page blocks.', 'cakecious' ),
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
                    'admin_label' => true,
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
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_contacticons_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_contacticons_shortcode extends WPBakeryShortCode {

    }
}
