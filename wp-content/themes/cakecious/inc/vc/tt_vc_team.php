<?php
/*
 * Templatation.com
 *
 * Banner with label slider for VC
 *
 */

function tt_vc_team_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Chef/Team' , 'cakecious' ),
            'base'                    => 'tt_vc_team_shortcode',
			"icon"     => 'tt-vc-block',
            'description'             => esc_html__( 'Team block.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Name', 'cakecious' ),
                    'param_name'  => 'name',
                    'admin_label' => true,
                    'value'       => '',
                ),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Post / Cover text",'cakecious'),
					"param_name" => "post",
					"description" => esc_html__("Post (or any other text) for this team member.",'cakecious'),
					"value" => "",
			    ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'cakecious' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'Image for team member. Size 270x280 preferred.', 'cakecious' ),
                ),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon 1', 'cakecious' ),
					'param_name' => 'icon1',
					'value' => 'fa fa-adjust', // default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'description' => esc_html__( 'Select icon from library.', 'cakecious' ),
					'group' => 'Social'
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 1 Link",'cakecious'),
					"param_name" => "link1",
					"description" => esc_html__("Link for above icon.",'cakecious'),
					"value" => "",
					'group' => 'Social'
			    ),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon 2', 'cakecious' ),
					'param_name' => 'icon2',
					'value' => 'fa fa-adjust', // default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'description' => esc_html__( 'Select icon from library.', 'cakecious' ),
					'group' => 'Social'
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 2 Link",'cakecious'),
					"param_name" => "link2",
					"description" => esc_html__("Link for above icon.",'cakecious'),
					"value" => "",
					'group' => 'Social'
			    ),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon 3', 'cakecious' ),
					'param_name' => 'icon3',
					'value' => 'fa fa-adjust', // default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'description' => esc_html__( 'Select icon from library.', 'cakecious' ),
					'group' => 'Social'
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 3 Link",'cakecious'),
					"param_name" => "link3",
					"description" => esc_html__("Link for above icon.",'cakecious'),
					"value" => "",
					'group' => 'Social'
			    ),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon 4', 'cakecious' ),
					'param_name' => 'icon4',
					'value' => 'fa fa-adjust', // default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'description' => esc_html__( 'Select icon from library.', 'cakecious' ),
					'group' => 'Social'
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 4 Link",'cakecious'),
					"param_name" => "link4",
					"description" => esc_html__("Link for above icon.",'cakecious'),
					"value" => "",
					'group' => 'Social'
			    ),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon 5', 'cakecious' ),
					'param_name' => 'icon5',
					'value' => 'fa fa-adjust', // default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'description' => esc_html__( 'Select icon from library.', 'cakecious' ),
					'group' => 'Social'
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Icon 5 Link",'cakecious'),
					"param_name" => "link5",
					"description" => esc_html__("Link for above icon.",'cakecious'),
					"value" => "",
					'group' => 'Social'
			    ),
			),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_team_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_team_shortcode extends WPBakeryShortCode {

    }
}
