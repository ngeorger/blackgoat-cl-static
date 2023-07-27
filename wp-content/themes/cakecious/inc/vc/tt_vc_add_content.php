<?php
/*
 * Templatation.com
 *
 *
 */

function tt_vc_add_content_fn_vc() {
    vc_map(
        array(
            'name'                    => esc_html__( 'CKC Add Content' , 'cakecious' ),
            'base'                    => 'tt_vc_add_content_shortcode',
			"icon"                    => 'tt-vc-block',
            'description'             => esc_html__( 'Add various content objects.', 'cakecious' ),
            "category" => esc_html__('Cakecious', 'cakecious'),
			"params" => array(

		                array(
							'type'			=> 'textfield',
							'heading'		=> esc_html__( 'Number of posts displayed', 'cakecious' ),
							'param_name'	=> 'posts_per_page',
							'description'	=> esc_html__( 'The number of posts you want to show.', 'cakecious' ),
							'value'			=> '5',
						),
						array(
							'type'			=> 'dropdown',
							'heading'		=> esc_html__( 'Content Type', 'cakecious' ),
							'param_name'	=> 'post_type',
							'description'	=> esc_html__( 'Not all content type will be listed here. We list only those we have template in this theme for.', 'cakecious' ),
							'admin_label'	=> true,
							'value' 		=> array(
								esc_html__(' Posts', 'cakecious')        =>  'post',
								esc_html__(' Testimonials', 'cakecious') =>  'tt_testimonial',
								esc_html__(' Gallery', 'cakecious')      =>  'tt_project',
								esc_html__(' Services', 'cakecious')     =>  'tt_portfolio',
								esc_html__(' Events', 'cakecious')       =>  'tt_team',
								esc_html__(' Products', 'cakecious')     =>  'product',
							)
						),
						array(
							'param_name' => 'enable_filter',
							'heading' => esc_html__( 'Enable Filter ?', 'cakecious' ),
							'type' => 'checkbox',
							'description' => esc_html__( 'If set to yes, the gallery is filterable by the category. Not applicable to all cases.', 'cakecious' ),
							'value'	=> 'true',
							'dependency' => array(
								'element'   => 'post_type',
								'value'     => 'tt_project',
							),
						),
						array(
							'param_name' => 'enable_all_btn',
							'heading' => esc_html__( 'Enable ALL button ?', 'cakecious' ),
							'type' => 'checkbox',
							'description' => esc_html__( 'If set to yes, All link appears first that displays all items. Not applicable to all cases.', 'cakecious' ),
							'value'	=> 'true',
							'dependency' => array(
								'element'   => 'post_type',
								'value'     => 'tt_project',
							),
						),
						array(
							'type'			=> 'dropdown',
							'heading'		=> esc_html__( 'Order by', 'cakecious' ),
							'param_name'	=> 'orderby',
							'description'	=> esc_html__( '', 'cakecious' ),
							'value' 		=> array(
								esc_html__(' Date', 'cakecious')		                => 'date',
								esc_html__(' Post ID', 'cakecious')		            => 'ID',
								esc_html__(' Author', 'cakecious')	                => 'author',
								esc_html__(' Title', 'cakecious')	                    => 'title',
								esc_html__(' Post name (post slug)', 'cakecious')		=> 'name',
								esc_html__(' Last modified date', 'cakecious')	    => 'modified',
								esc_html__(' Random order', 'cakecious')	            => 'rand',
								esc_html__(' Number of comments', 'cakecious') 	    => 'comment_count',
							)
						),
						array(
							'type'			=> 'dropdown',
							'heading'		=> esc_html__( 'Order post', 'cakecious' ),
							'param_name'	=> 'tt_order',
							'value' 		=> array(
								esc_html__(' DESC', 'cakecious')		=> 'DESC',
								esc_html__(' ASC', 'cakecious')	    => 'ASC',
							)
						),
						array(
							'type'			=> 'textfield',
							'heading'			=> esc_html__( 'Post Ids', 'cakecious' ),
							'param_name'			=> 'tt_id',
							'description'	=> esc_html__( 'If you want to display particular posts, enter their IDs comma separated. eg 101,202,300. Recommended: Leave blank', 'cakecious' ),
							'admin_label'	=> true,
						),
						array(
							'type'			=> 'dropdown',
							'heading'			=> esc_html__( 'Display Template', 'cakecious' ),
							'param_name'			=> 'tt_template',
							'description'	=> esc_html__( 'There are prebuilt templates to display certain content in this theme. You are requested not to edit this.', 'cakecious' ),
							'value' 		=> array(
								esc_html__(' Default', 'cakecious')	                => 'default',
								esc_html__(' Testimonial Carousel', 'cakecious')	=> 'testimonial',
								esc_html__(' Testimonial List', 'cakecious')	    => 'testimonial-list',
								esc_html__(' Gallery With Title', 'cakecious')	    => 'project-text',
								esc_html__(' Gallery Full width', 'cakecious')	    => 'project-full',
								esc_html__(' Product Carousel', 'cakecious')	    => 'product-carousel',
								esc_html__(' Product Carousel 2', 'cakecious')	    => 'product-carousel2',
								esc_html__(' Product Arrival Slider', 'cakecious')	=> 'product-arr-sldr',
								//esc_html__(' Service Carousel', 'cakecious')	    => 'service_carousel',
								//esc_html__(' Service List', 'cakecious')	        => 'service_list',
								//esc_html__(' Gallery 3 Col', 'cakecious')	        => 'project3-sc',
								//esc_html__(' Events', 'cakecious')	                => 'events',
							)
						),
						array(
							'param_name' => 'spl_title',
							'heading' => esc_html__( 'Title (Optional)', 'cakecious' ),
							'type' => 'textfield',
							'admin_label'	=> true,
							'description' => esc_html__( 'Enter the title for the entire block.', 'cakecious' ),
							'dependency' => array(
								'element'   => 'tt_template',
								'value'     => array('testimonial-list',  'testimonial', 'project3-sc', 'product-carousel', 'product-carousel2')
							),
						),
						array(
							"type" => "textarea",
							"class" => "",
							"heading" => esc_html__("Description (Optional)",'cakecious'),
							"param_name" => "spl_desc",
							"value" => "",
							'dependency' => array(
								'element'   => 'tt_template',
								'value'     => array('testimonial-list', 'project3-sc', 'product-carousel', 'product-carousel2')
							),
					    ),
						array(
							'param_name' => 'spl_button',
							'heading' => esc_html__( 'Button text', 'cakecious' ),
							'type' => 'textfield',
							'description' => esc_html__( 'Enter the text for button.', 'cakecious' ),
							'dependency' => array(
								'element'   => 'tt_template',
								'value'     => array('product-carousel2')
							),
						),
						array(
							'param_name' => 'spl_btn_link',
							'heading' => esc_html__( 'Button link', 'cakecious' ),
							'type' => 'textfield',
							'description' => esc_html__( 'Link for above button.', 'cakecious' ),
							'dependency' => array(
								'element'   => 'tt_template',
								'value'     => array('product-carousel2')
							),
						),
	                )
        )
    );
}
add_action( 'vc_before_init', 'tt_vc_add_content_fn_vc' );
// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_tt_vc_add_content_shortcode extends WPBakeryShortCode {

    }
}
