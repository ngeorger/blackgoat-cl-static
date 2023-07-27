<?php
namespace CAKECIOUSElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Cakecious_Display_Products extends Widget_Base {

	public function get_name() {
		return sprintf( '%s-wc-display-products',get_template() );
	}

	public function get_title() {
		return sprintf( '%s Display WC Product', ucfirst(get_template() ) );
	}

	public function get_icon() {
		return 'eicon-product-related';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'related', 'similar', 'product' ];
	}


	/**
	 * Get controls list.
	 *
	 * Retrieve the global settings model controls list.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 *
	 * @return array Controls list.
	 */
	public static function get_controls_list() {

		$contents_tab = [
					'label' => sprintf( esc_html__( '%1$s Display Products', 'cakecious' ), ucfirst(get_template() ) ),
					'controls' => [
						'wc_style_warning' => [
							'type' => Controls_Manager::RAW_HTML,
							'raw' => esc_html__( 'The widget is simple one. If you want more control, it is recommended that you use Shortcode Elementor module and than build shortcode easily from this official guide https://docs.woocommerce.com/document/woocommerce-shortcodes/.', 'cakecious' ),
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
							'label' => esc_html__( 'Number of Columns', 'justshoppe' ),
							'type' => Controls_Manager::SELECT,
							'default' => '4',
							'description' => esc_html__( 'The number of columns, products are arranged in.', 'justshoppe' ),
							'options'  => [
								  '2'          =>      esc_html__(' 2', 'justshoppe'),
								  '3'          =>      esc_html__(' 3', 'justshoppe'),
								  '4'          =>      esc_html__(' 4', 'justshoppe'),
								  '5'          =>      esc_html__(' 5', 'justshoppe'),
								  '6'          =>      esc_html__(' 6', 'justshoppe'),
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
								'prod-simple'           =>  esc_html__(' Products Simple', 'cakecious'),
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

						'spl_field1' => [
							'label' => esc_html__( 'Title (Optional)', 'cakecious' ),
							'type' => Controls_Manager::TEXT,
							'description' => esc_html__( 'Enter the title for the entire block. Leave blank to disable.', 'cakecious' ),
							'label_block' => true,
							'condition' => [
								'tt_template' => [ 'none' ],
							],
						],

					],
		];

		$contents_tab = apply_filters('cakecious_prod_contents_fields', $contents_tab);

		return [
			Controls_Manager::TAB_CONTENT => [
				'Content' => $contents_tab
			],
		];
	}

	/**
	 * Register model controls.
	 *
	 * Used to add new controls to the global settings model.
	 *
	 * @since 1.6.0
	 * @access protected
	 */
	protected function _register_controls() {
		$controls_list = self::get_controls_list();

		foreach ( $controls_list as $tab_name => $sections ) {

			foreach ( $sections as $section_name => $section_data ) {

				$this->start_controls_section(
					$section_name, [
						'label' => $section_data['label'],
						'tab' => $tab_name,
					]
				);

				foreach ( $section_data['controls'] as $control_name => $control_data ) {
					$this->add_control( $control_name, $control_data );
				}

				$this->end_controls_section();
			}
		}
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$tt_template = '';

		extract( $settings );

		( ! isset( $tt_template ) || $tt_template == 'default' ) ? $template = 'blv-product-sc' : $template = $tt_template;

		if ( $tt_template != 'default' ) {
			$template = 'blv-' . $template;
		}
		cakecious_get_template_part( $template, null, $settings );

	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
	}
}