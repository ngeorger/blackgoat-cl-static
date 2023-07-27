<?php
/**
 * Cakecious Pro module: Vertical Header
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Header_Vertical extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'header-vertical';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Class constructor
	 */
	protected function __construct() {
		parent::__construct();

		// Dynamic CSS
		add_filter( 'cakecious/frontend/pro_dynamic_css', array( $this, 'add_dynamic_css' ) );

		// Register new menus
		add_action( 'init', array( $this, 'register_new_menus' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );
		add_filter( 'cakecious/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );
		add_filter( 'cakecious/dataset/header_builder_configurations', array( $this, 'modify_header_builder_configurations' ) );
		add_filter( 'cakecious/dataset/mobile_header_builder_configurations', array( $this, 'modify_mobile_header_builder_configuratinos' ) );

		// Template actions
		add_action( 'cakecious/frontend/before_canvas', array( $this, 'render_vertical_header' ) );

		// Template filters
		add_filter( 'cakecious/frontend/header_vertical_classes', array( $this, 'header_vertical_classes' ), 10, 2 );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add dynamic CSS from customizer settings into the inline CSS.
	 *
	 * @param string $css
	 * @return string
	 */
	public function add_dynamic_css( $css ) {
		// Skip adding dynamic CSS on customizer preview frame.
		if ( is_customize_preview() ) {
			return $css;
		}

		$postmessages = include( CAKECIOUS_PRO_DIR . '/inc/modules/' . self::MODULE_SLUG . '/customizer/postmessages.php' );
		$defaults = include( CAKECIOUS_PRO_DIR . '/inc/modules/' . self::MODULE_SLUG . '/customizer/defaults.php' );

		$css .= Cakecious_Customizer::instance()->convert_postmessages_to_css_string( $postmessages, $defaults );

		return $css;
	}

	/**
	 * Registers additional menu locations.
	 */
	public function register_new_menus() {
		register_nav_menus( array(
			'header-vertical-menu' => esc_html__( 'Vertical Header Menu', 'cakecious-features' ),
		) );
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--vertical-bar.php' );
	}
	
	/**
	 * Add default values for all Customizer settings.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		$add = include( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/defaults.php' );

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_customizer_setting_postmessages( $postmessages = array() ) {
		$add = include( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/postmessages.php' );

		return array_merge_recursive( $postmessages, $add );
	}

	/**
	 * Add dependency contexts for some Customizer settings.
	 *
	 * @param array $contexts
	 * @return array
	 */
	public function add_customizer_control_contexts( $contexts = array() ) {
		$add = include( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/contexts.php' );

		return array_merge_recursive( $contexts, $add );
	}

	/**
	 * Modify header builder configurations.
	 *
	 * @param array $config
	 * @return array
	 */
	public function modify_header_builder_configurations( $config ) {
		$config = array_merge_recursive( array(
			'locations' => array(
				'vertical_top'    => esc_html__( 'Vertical - Top', 'cakecious-features' ),
				'vertical_middle' => esc_html__( 'Vertical - Middle', 'cakecious-features' ),
				'vertical_bottom' => esc_html__( 'Vertical - Bottom', 'cakecious-features' ),
			),
			'choices' => array(
				'vertical-menu'   => '<span class="dashicons dashicons-admin-links"></span>' . esc_html__( 'Vertical Menu', 'cakecious-features' ),
				'vertical-toggle' => '<span class="dashicons dashicons-menu"></span>' . esc_html__( 'Vertical Toggle', 'cakecious-features' ),
			),
			'limitations' => array(
				// Free elements
				'menu-1'          => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),
				'search-dropdown' => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),

				// Pro elements
				'menu-2'          => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),
				'menu-3'          => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),
				'vertical-menu'   => array( 'top_left', 'top_center', 'top_right', 'main_left', 'main_center', 'main_right', 'bottom_left', 'bottom_center', 'bottom_right' ),
				'vertical-toggle' => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),
			),
		), $config );

		// WooCommerce
		if ( class_exists( 'WooCommerce' ) ) {
			$config['limitations'] = array_merge_recursive( $config['limitations'], array(
				'shopping-cart-link'       => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),
				'shopping-cart-dropdown'   => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),
				'shopping-cart-off-canvas' => array( 'vertical_top', 'vertical_middle', 'vertical_bottom' ),
			) );
		}

		return $config;
	}

	/**
	 * Modify mobile header builder configurations.
	 *
	 * @param array $config
	 * @return array
	 */
	public function modify_mobile_header_builder_configuratinos( $config ) {
		$config = array_merge_recursive( array(
			'choices' => array(
				'html-2'   => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'cakecious-features' ), 2 ),
				'html-3'   => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'cakecious-features' ), 3 ),
				'button-1' => '<span class="dashicons dashicons-share-alt2"></span>' . sprintf( esc_html__( 'Button %s', 'cakecious-features' ), 1 ),
				'button-2' => '<span class="dashicons dashicons-share-alt2"></span>' . sprintf( esc_html__( 'Button %s', 'cakecious-features' ), 2 ),
				'contact'  => '<span class="dashicons dashicons-phone"></span>' . esc_html__( 'Contact', 'cakecious-features' ),
			),
		), $config );

		return $config;
	}

	/**
	 * Add custom classes to the array of header main bar section classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	function header_vertical_classes( $classes ) {
		$display = cakecious_get_theme_mod( 'header_vertical_bar_display' );

		$classes['display'] = esc_attr( 'cakecious-header-vertical-display-' . $display );
		$classes['position'] = esc_attr( 'cakecious-header-vertical-position-' . cakecious_get_theme_mod( 'header_vertical_bar_position' ) );

		if ( 'fixed' !== $display ) {
			$classes['popup'] = esc_attr( 'cakecious-popup' );
		}

		$classes['alignment'] = esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'header_vertical_bar_alignment' ) );

		return $classes;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render vertical header.
	 */
	public function render_vertical_header() {
		if ( intval( cakecious_get_current_page_setting( 'disable_header' ) ) ) {
			return;
		}

		cakecious_get_template_part( 'header-vertical' );
	}
}

Cakecious_Pro_Module_Header_Vertical::instance();