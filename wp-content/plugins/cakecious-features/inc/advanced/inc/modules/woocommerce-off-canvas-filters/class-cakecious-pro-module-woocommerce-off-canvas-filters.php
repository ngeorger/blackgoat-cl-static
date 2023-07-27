<?php
/**
 * Cakecious Pro module: WooCommerce Off Canvas Filters
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_WooCommerce_Off_Canvas_Filters extends Cakecious_Pro_Module_WooCommerce {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'woocommerce-off-canvas-filters';

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
		add_filter( 'cakecious/frontend/woocommerce/pro_dynamic_css', array( $this, 'add_dynamic_css' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );
		add_filter( 'cakecious/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		// Template hooks
		add_action( 'widgets_init', array( $this, 'register_off_canvas_filters_sidebar' ) );
		add_action( 'wp', array( $this, 'init_frontend' ) );

		// Additional icons
		add_action( 'cakecious/dataset/all_icons', array( $this, 'add_icons' ) );
		add_filter( 'cakecious/frontend/svg_icon_path', array( $this, 'svg_icon_path' ), 10, 2 );
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
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--off-canvas-filters.php' );
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
	 * Register additional sidebar for Off Canvas Filters.
	 */
	public function register_off_canvas_filters_sidebar() {
		register_sidebar( array(
			'name'          => esc_html__( 'Off Canvas Filters', 'cakecious-features' ),
			'id'            => 'cakecious-woocommerce-off-canvas-filters',
			'description'   => esc_html__( 'Sidebar used when Off Canvas Filters mode is enabled (configurable at Customize > WooCommerce > Off Canvas Filters). This should contain WooCommerce filter widgets.', 'cakecious-features' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

	/**
	 * Add icons list.
	 *
	 * @param array $choices
	 * @return array
	 */
	public function add_icons( $choices ) {
		$choices['theme_icons'] = array_merge( $choices['theme_icons'], array(
			'filter' => esc_html_x( 'Filter', 'icon label', 'cakecious-features' ),
		) );

		return $choices;
	}

	/**
	 * Modify SVG icon path for some new icons.
	 *
	 * @param string $path
	 * @param string $key
	 * @return string
	 */
	public function svg_icon_path( $path, $key ) {
		if ( in_array( $key, array( 'filter' ) ) ) {
			$path = CAKECIOUS_PRO_DIR . 'assets/icons/' . $key . '.svg';
		}

		return $path;
	}

	/**
	 * Initialize frontend filters.
	 */
	public function init_frontend() {
		// Add off-canvas filters.
		if ( intval( cakecious_get_theme_mod( 'woocommerce_off_canvas_filters' ) ) ) {
			add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_off_canvas_filters_button' ), 19 );
			add_action( 'cakecious/frontend/after_canvas', array( $this, 'render_loop_off_canvas_filters_popup' ) );

			// Add selected filters after filter bar.
			if ( intval( cakecious_get_theme_mod( 'woocommerce_off_canvas_filters_selected_list' ) ) ) {
				add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_selected_filters_list' ), 110 );
			}
		}
	}
	
	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render off canvas filters button.
	 */
	public function render_loop_off_canvas_filters_button() {
		cakecious_get_template_part( 'woocommerce-off-canvas-filters-button' );
	}

	/**
	 * Render off canvas filters popup.
	 */
	public function render_loop_off_canvas_filters_popup() {
		cakecious_get_template_part( 'woocommerce-off-canvas-filters-popup' );
	}

	/**
	 * Render selected filters list after filter bar.
	 */
	public function render_loop_selected_filters_list() {
		cakecious_get_template_part( 'woocommerce-off-canvas-filters-selected' );
	}
}

Cakecious_Pro_Module_WooCommerce_Off_Canvas_Filters::instance();