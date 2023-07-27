<?php
/**
 * Cakecious setup
 *
 * @package cakecious
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
add_filter('cakecious_prod_contents_fields', 'cakecious_theme_product_fields');

function cakecious_theme_product_fields() {

		$contents_type_fields = [
					'label' => sprintf( esc_html__( '%1$s Display Productsss', 'cakecious' ), ucfirst(get_template() ) ),
					'controls' => [
						'wc_style_warning' => [
							'type' => Controls_Manager::RAW_HTML,
							'raw' => esc_html__( 'The widget is simple one. If you want more control, it is recommended that you use Shortcode Elementor module and  build shortcode easily from this official guide https://docs.woocommerce.com/document/woocommerce-shortcodes/.', 'cakecious' ),
							'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
						],

						'posts_per_page' => [
							'label' => esc_html__( 'Number of Products displayed', 'cakecious' ),
							'type' => Controls_Manager::TEXT,
							'default' => '4',
							'description' => esc_html__( 'The number of products you want to display.', 'cakecious' ),
							'label_block' => true,
						],

						'number_cols' => [
							'label' => esc_html__( 'Number of Columns', 'cakecious' ),
							'type' => Controls_Manager::SELECT,
							'default' => '4',
							'description' => esc_html__( 'The number of columns, products are arranged in.', 'cakecious' ),
							'options'  => [
								  '2'          =>      esc_html__(' 2', 'cakecious'),
								  '3'          =>      esc_html__(' 3', 'cakecious'),
								  '4'          =>      esc_html__(' 4', 'cakecious'),
								  '5'          =>      esc_html__(' 5', 'cakecious'),
								  '6'          =>      esc_html__(' 6', 'cakecious'),
							],
						],

						'orderby' => [
							'label' => esc_html__( 'Order by', 'cakecious' ),
							'type' => Controls_Manager::SELECT,
							'description' =>esc_html__( 'Order this content by...', 'cakecious' ),
							'default'  => 'date',
							'options'  => [
								  'date'            =>      esc_html__(' Date', 'cakecious'),
								  'ID'              =>      esc_html__(' Post ID', 'cakecious'),
								  'author'          =>      esc_html__(' Author', 'cakecious'),
								  'title'           =>      esc_html__(' Title', 'cakecious'),
								  'name'            =>      esc_html__(' Post name (post slug)', 'cakecious'),
								  'modified'        =>      esc_html__(' Last modified date', 'cakecious'),
								  'rand'            =>      esc_html__(' Random order', 'cakecious'),
							],
						],

						'order' => [
							'label' => esc_html__( 'Order post', 'cakecious' ),
							'type' => Controls_Manager::SELECT,
							'default'  => 'DESC',
							'options'  => [
								  'DESC'            =>      esc_html__(' DESC', 'cakecious'),
								  'ASC'             =>      esc_html__(' ASC', 'cakecious'),
							],
						],

						'tt_template' => [
							'label' => esc_html__( 'Display Template', 'cakecious' ),
							'type' => Controls_Manager::SELECT,
							'description' => esc_html__( 'There are prebuilt templates to display certain content in this theme. You are requested not to edit this.', 'cakecious' ),
							'default'  => 'default',
							'options'  => [
								'default'           =>  esc_html__(' Default', 'cakecious'),
								'prod-simple'       =>  esc_html__(' Products Simple', 'cakecious'),
							],
						],

						'enable_filter' => [
							'label' => esc_html__( 'Enable Filter ?', 'cakecious' ),
							'type' => Controls_Manager::SWITCHER,
							'description' => esc_html__( 'If set to yes, the gallery is filterable by the category. Not applicable to all cases.', 'cakecious' ),
							'default' => 'true',
							'prefix_class' => 'elementor-',
							'label_on' => 'Yes',
							'label_off' => 'No',
							'return_value' => 'true',
							'condition' => [
								'tt_template' => [ 'project-text', 'project-text' ],
							],
						],

						'enable_all_btn' => [
							'label' => esc_html__( 'Enable ALL button ?', 'cakecious' ),
							'type' => Controls_Manager::SWITCHER,
							'description' => esc_html__( 'If set to yes, All link appears first that displays all items. Not applicable to all cases.', 'cakecious' ),
							'default' => 'true',
							'prefix_class' => 'elementor-',
							'label_on' => 'Yes',
							'label_off' => 'No',
							'return_value' => 'true',
							'condition' => [
								'tt_template' => [ 'project-text', 'project-text' ],
							],
						],

						/* The param name should not be changed. */
						/* spl_title */
						'spl_field1' => [
							'label' => esc_html__( 'Title (Optional)', 'cakecious' ),
							'type' => Controls_Manager::TEXT,
							'description' => esc_html__( 'Enter the title for the entire block. Leave blank to disable.', 'cakecious' ),
							'label_block' => true,
							'condition' => [
								'tt_template' => [ 'default' ],
							],
						],
						/* spl_button */
						'spl_field2' => [
							"label" => esc_html__("Button Label (Optional)", 'cakecious'),
							'type' => Controls_Manager::TEXT,
							'description' => esc_html__( 'Leave blank to disable button.', 'cakecious' ),
							'label_block' => true,
							'condition' => [
								'tt_template' => [ 'blog3' ],
							],
						],
						/* spl_target */
						'spl_field3' => [
							"label" => esc_html__("Open links in:",'cakecious'),
							'type' => Controls_Manager::SELECT,
							'label_block' => true,
							'options'  => [
								'_self'           =>  esc_html__(' Same window', 'cakecious'),
								'_blank'   =>  esc_html__(' New window', 'cakecious'),
							],
							'condition' => [
								'tt_template' => [ 'blog3' ],
							],
						],
						/* spl_link */
						'spl_field4' => [
							"label" => esc_html__("Button Link:",'cakecious'),
							'type' => Controls_Manager::TEXT,
							'description' => esc_html__( 'The link for the above button.', 'cakecious' ),
							'label_block' => true,
							'condition' => [
								'tt_template' => [ 'blog3' ],
							],
						],

						'spl_field5' => [
							'label' => esc_html__( 'Subtitle (Optional)', 'cakecious' ),
							'type' => Controls_Manager::TEXT,
							'description' => esc_html__( 'Enter the subtitle for the entire block. Leave blank to disable.', 'cakecious' ),
							'label_block' => true,
							'condition' => [
								'tt_template' => [ 'default' ],
							],
						],

						'spl_field6' => [
							'label' => esc_html__( 'Description (Optional)', 'cakecious' ),
							'type' => Controls_Manager::TEXTAREA,
							'description' => esc_html__( 'Enter the description for the entire block. Leave blank to disable. Plain text only, new line or html will not work.', 'cakecious' ),
							'label_block' => true,
							'condition' => [
								'tt_template' => [ 'default' ],
							],
						],

					],
		];

		return $contents_type_fields;

}
