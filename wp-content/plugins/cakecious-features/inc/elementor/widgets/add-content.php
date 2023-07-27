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
class Cakecious_Add_Content extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'cakecious-add-content';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return sprintf( '%s Add Content', ucfirst(get_template() ) );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
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
					'label' => sprintf( esc_html__( '%1$s Add Content', 'cakecious' ), ucfirst(get_template() ) ),
					'controls' => [
						'posts_per_page' => [
							'label' => esc_html__( 'Number of posts displayed', 'cakecious' ),
							'type' => Controls_Manager::TEXT,
							'default' => '5',
							'description' => esc_html__( 'The number of posts you want to show.', 'cakecious' ),
							'label_block' => true,
						],
						'post_type' => [
							'label' => esc_html__( 'Content Type', 'cakecious' ),
							'type' => Controls_Manager::SELECT,
							'description' =>esc_html__( 'Not all content type will be listed here. We list only those we have template in this theme for.', 'cakecious' ),
							'default'  => 'post',
							'options'  => [
								 'post'                 => esc_html__(' Posts', 'cakecious'),
								 'tt_testimonial'       => esc_html__(' Testimonials', 'cakecious'),
								 'tt_project'           => esc_html__(' Gallery', 'cakecious'),
								 'tt_portfolio'         => esc_html__(' Services', 'cakecious'),
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
								  'comment_count'   =>      esc_html__(' Number of comments', 'cakecious'),
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

						'tt_id' => [
							'label' => esc_html__( 'Post Ids', 'cakecious' ),
							'type' => Controls_Manager::TEXT,
							'default' => '',
							'description' => esc_html__( 'If you want to display particular posts, enter their IDs comma separated. eg 101,202,300. Recommended: Leave blank', 'cakecious' ),
							'label_block' => true,
						],

						'tt_template' => [
							'label' => esc_html__( 'Display Template', 'cakecious' ),
							'type' => Controls_Manager::SELECT,
							'description' => esc_html__( 'There are prebuilt templates to display certain content in this theme. You are requested not to edit this.', 'cakecious' ),
							'default'  => 'default',
							'options'  => [
								'default'           =>  esc_html__(' Default', 'cakecious'),
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

		$contents_tab = apply_filters('cakecious_add_contents_fields', $contents_tab);

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
		$id       = $tt_template = $enable_filter = $enable_all_btn = $posts_per_page = $post_type = $orderby = $order = $temptt_spl_vars_out = '';
		isset( $settings['tt_id'] ) ? $id = $settings['tt_id'] : $id = false;
// Creating array with vars.
		$temptt_spl_vars = array();
		if ( ! empty( $settings['spl_field1'] ) ) {
			$temptt_spl_vars['spl_field1'] = $settings['spl_field1'];
		}
		if ( ! empty( $settings['spl_field2'] ) ) {
			$temptt_spl_vars['spl_field2'] = $settings['spl_field2'];
		}
		if ( ! empty( $settings['spl_field3'] ) ) {
			$temptt_spl_vars['spl_field3'] = $settings['spl_field3'];
		}
		if ( ! empty( $settings['spl_field4'] ) ) {
			$temptt_spl_vars['spl_field4'] = $settings['spl_field4'];
		}
		if ( ! empty( $settings['spl_field5'] ) ) {
			$temptt_spl_vars['spl_field5'] = $settings['spl_field5'];
		}
		if ( ! empty( $settings['spl_field6'] ) ) {
			$temptt_spl_vars['spl_field6'] = $settings['spl_field6'];
		}

		if( !empty($temptt_spl_vars)) {
			$temptt_spl_vars     = wp_json_encode( $temptt_spl_vars );
			$temptt_spl_vars_out = "temptt_var1='" . $temptt_spl_vars . "'";
		}
		extract( $settings );

		( ! isset( $tt_template ) || $tt_template == 'default' ) ? $template = 'template-parts/blv-posts-sc.php' : $template = $tt_template;

		if ( $tt_template != 'default' ) {
			$template = 'template-parts/blv-' . $template . '.php';
		}

		if ( ! empty( $id ) ) {
			$id = 'id=' . $id;
		}
		if ( 'true' == $enable_filter ) {
			$enable_filter = 'temptt_show_filters=yes';
		}
		( 'true' == $enable_all_btn ) ? $enable_all_btn = 'temptt_filter_all=yes' : $enable_all_btn = 'temptt_filter_all=no';

		echo do_shortcode( '[cakecious_posts posts_per_page=' . $posts_per_page . ' post_type=' . $post_type . ' orderby=' . $orderby . ' order=' . $order . ' ' . $id . '  ' . $enable_filter . '  ' . $enable_all_btn . ' template=' . $template . ' ' . $temptt_spl_vars_out . ']' );

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
