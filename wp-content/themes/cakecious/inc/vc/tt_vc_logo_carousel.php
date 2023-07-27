<?php
/*
 * Templatation.com
 *
 *
 */

function tt_vc_logo_carousel_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Logo Carousel' , 'cakecious' ),
            'base'                    => 'tt_vc_logo_carousel_shortcode',
			"icon"     => 'tt-vc-block',
            "category" => esc_html__('Cakecious', 'cakecious'),
	'params' => array(
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'cakecious' ),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__( 'Select images from media library.', 'cakecious' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Carousel size', 'cakecious' ),
			'param_name' => 'img_size',
			'value' => 'thumbnail',
			'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size. If used slides per view, this will be used to define carousel wrapper size.', 'cakecious' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'On click action', 'cakecious' ),
			'param_name' => 'onclick',
			'value' => array(
				esc_html__( 'Open prettyPhoto', 'cakecious' ) => 'link_image',
				esc_html__( 'None', 'cakecious' ) => 'link_no',
				esc_html__( 'Open custom links', 'cakecious' ) => 'custom_link',
			),
			'description' => esc_html__( 'Select action for click event.', 'cakecious' ),
		),
		array(
			'type' => 'exploded_textarea_safe',
			'heading' => esc_html__( 'Custom links', 'cakecious' ),
			'param_name' => 'custom_links',
			'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'cakecious' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link' ),
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Custom link target', 'cakecious' ),
			'param_name' => 'custom_links_target',
			'description' => esc_html__( 'Select how to open custom links.', 'cakecious' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link' ),
			),
			'value' 		=> array(
				esc_html__( 'Same window', 'cakecious' ) => '_self',
				esc_html__( 'New window', 'cakecious' ) => '_blank',
			)
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__( 'Element ID', 'cakecious' ),
			'param_name' => 'el_id',
			'description' => sprintf( esc_html__( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'cakecious' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'cakecious' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cakecious' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'cakecious' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'cakecious' ),
		),
	),
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_logo_carousel_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_logo_carousel_shortcode extends WPBakeryShortCode {

    }
}
