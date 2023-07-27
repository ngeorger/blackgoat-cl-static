<?php
/**
 * Cakecious Pro module: Header Elements Plus
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Header_Elements_Plus extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'header-elements-plus';

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

		// Register new menus
		add_action( 'init', array( $this, 'register_new_menus' ) );

		// Header elements filters
		add_filter( 'cakecious/dataset/header_builder_configurations', array( $this, 'modify_header_builder_configurations' ) );
		add_filter( 'cakecious/dataset/mobile_header_builder_configurations', array( $this, 'modify_mobile_header_builder_configuratinos' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );

		// Frontend
		add_action( 'wp', array( $this, 'init_frontend' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Registers additional menu locations.
	 */
	public function register_new_menus() {
		register_nav_menus( array(
			/* translators: %d: number of Header Menu. */
			'header-menu-2' => sprintf( esc_html__( 'Header Menu %d', 'cakecious-features' ), 2 ),
			/* translators: %d: number of Header Menu. */
			'header-menu-3' => sprintf( esc_html__( 'Header Menu %d', 'cakecious-features' ), 3 ),
		) );
	}

	/**
	 * Modify header builder configurations.
	 *
	 * @param array $config
	 * @return array
	 */
	public function modify_header_builder_configurations( $config ) {
		$config = array_merge_recursive( array(
			'choices' => array(
				/* translators: %s: instance number. */
				'menu-2'                   => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Menu %s', 'cakecious-features' ), 2 ),
				/* translators: %s: instance number. */
				'menu-3'                   => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Menu %s', 'cakecious-features' ), 3 ),
				/* translators: %s: instance number. */
				'html-2'                   => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'cakecious-features' ), 2 ),
				/* translators: %s: instance number. */
				'html-3'                   => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'cakecious-features' ), 3 ),
				/* translators: %s: instance number. */
				'button-1'                 => '<span class="dashicons dashicons-share-alt2"></span>' . sprintf( esc_html__( 'Button %s', 'cakecious-features' ), 1 ),
				/* translators: %s: instance number. */
				'button-2'                 => '<span class="dashicons dashicons-share-alt2"></span>' . sprintf( esc_html__( 'Button %s', 'cakecious-features' ), 2 ),
				'contact'                  => '<span class="dashicons dashicons-phone"></span>' . esc_html__( 'Contact', 'cakecious-features' ),
			),
		), $config );

		// WooCommerce
		if ( class_exists( 'WooCommerce' ) ) {
			$config['choices'] = array_merge_recursive( $config['choices'], array(
				'shopping-cart-off-canvas' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Off Canvas', 'cakecious-features' ),
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

		// WooCommerce
		if ( class_exists( 'WooCommerce' ) ) {
			$config['choices'] = array_merge_recursive( $config['choices'], array(
				'shopping-cart-off-canvas' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Off Canvas', 'cakecious-features' ),
			) );
			$config['limitations'] = array_merge_recursive( $config['limitations'], array(
				'shopping-cart-off-canvas' => array( 'vertical_top' ),
			) );
		}

		return $config;
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--html.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--button.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--search.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--cart.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--contact.php' );
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
	 * Initialize frontend.
	 */
	public function init_frontend() {
		// Additional icons
		add_action( 'cakecious/dataset/all_icons', array( $this, 'add_icons' ) );
		add_filter( 'cakecious/frontend/svg_icon_path', array( $this, 'svg_icon_path' ), 10, 2 );

		// Header search mode: products
		if ( 'products' === cakecious_get_theme_mod( 'header_search_mode' ) && function_exists( 'get_product_search_form' ) ) {
			add_filter( 'cakecious/frontend/header_element/search-bar', array( $this, 'change_search_mode_to_products_search' ), 1);
			add_filter( 'cakecious/frontend/header_element/search-dropdown', array( $this, 'change_search_mode_to_products_search' ), 1 );
		}

		// Menu + Logo + Menu combination
		foreach ( array( 'top', 'main', 'bottom' ) as $bar ) {
			// Get the elements in the center column.
			$center_elements = cakecious_get_theme_mod( 'header_elements_' . $bar . '_center', array() );

			// Abort if center column doesn't have exactly 3 elements.
			if ( 3 !== count( $center_elements ) ) {
				continue;
			}

			// Get the combination as a string.
			$combination = implode( '-', $center_elements );
			$combination = preg_replace( '/-[\d]/', '', $combination );

			if ( 'menu-logo-menu' === $combination ) {
				add_filter( 'cakecious/frontend/header_' . $bar . '_bar_classes', array( $this, 'add_css_class_for_menu_logo_menu_combination' ) );
			}
		}

		// Cart Off Canvas
		$has_cart_off_canvas = false;
		foreach ( array( 'top_left', 'top_center', 'top_right', 'main_left', 'main_center', 'main_right', 'bottom_left', 'bottom_center', 'bottom_right', 'mobile_main_left', 'mobile_main_center', 'mobile_main_right' ) as $location ) {
			
			if ( in_array( 'shopping-cart-off-canvas', cakecious_get_theme_mod( 'header_elements_' . $location, array() ) ) ) {
				$has_cart_off_canvas = true;
				break;
			}
		}
		if ( $has_cart_off_canvas ) {
			add_action( 'cakecious/frontend/after_canvas', array( $this, 'render_cart_off_canvas_popup' ) );
		}
	}

	/**
	 * Add icons list.
	 *
	 * @param array $choices
	 * @return array
	 */
	public function add_icons( $choices ) {
		$choices['theme_icons'] = array_merge( $choices['theme_icons'], array(
			'email'   => esc_html_x( 'Email', 'icon label', 'cakecious-features' ),
			'address' => esc_html_x( 'Address', 'icon label', 'cakecious-features' ),
			'phone'   => esc_html_x( 'Phone', 'icon label', 'cakecious-features' ),
			'time'    => esc_html_x( 'Time', 'icon label', 'cakecious-features' ),
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
		if ( in_array( $key, array( 'email', 'address', 'phone', 'time' ) ) ) {
			$path = CAKECIOUS_PRO_DIR . 'assets/icons/' . $key . '.svg';
		}

		return $path;
	}

	/**
	 * Change header search mode to products search.
	 *
	 * @param string $html
	 * @return string
	 */
	public function change_search_mode_to_products_search( $html ) {
		$html = preg_replace( '/( cakecious-header-search)/', '$1 woocommerce', $html );
		$html = preg_replace( '/<form(.*?)>(.|\s)*?<\/form>/', get_product_search_form( false ), $html ); // WPCS: XSS OK

		return $html;
	}

	/**
	 * Detect if header bar contains this combination: Menu + Logo + Menu.
	 * If yes, add special CSS class to make the both menus to be the same width (logo is centered).
	 *
	 * @param array $classes
	 * @return array
	 */
	function add_css_class_for_menu_logo_menu_combination( $classes ) {
		$classes[] = 'cakecious-header-combination--center--menu-logo-menu';

		return $classes;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render header shopping cart off canvas panel.
	 */
	public function render_cart_off_canvas_popup() {
		cakecious_get_template_part( 'header-element-shopping-cart-off-canvas-popup' );
	}
}

Cakecious_Pro_Module_Header_Elements_Plus::instance();