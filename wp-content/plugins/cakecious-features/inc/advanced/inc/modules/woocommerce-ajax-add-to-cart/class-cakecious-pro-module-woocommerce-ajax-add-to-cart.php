<?php
/**
 * Cakecious Pro module: WooCommerce AJAX Add To Cart
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_WooCommerce_AJAX_Add_To_Cart extends Cakecious_Pro_Module_WooCommerce {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'woocommerce-ajax-add-to-cart';

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

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );

		// Frontend
		add_action( 'init', array( $this, 'init_frontend' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--ajax-add-to-cart.php' );
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
	 * Initialize AJAX add to cart.
	 */
	public function init_frontend() {
		// AJAX add to cart CSS class on single product form.
		if ( is_product() && intval( cakecious_get_theme_mod( 'woocommerce_single_ajax_add_to_cart' ) ) ) {
			add_filter( 'cakecious/frontend/woocommerce/add_to_cart_form_classes', array( $this, 'add_ajax_add_to_cart_class_to_product_form' ) );
		}

		// Added to cart effect.
		if ( intval( cakecious_get_theme_mod( 'woocommerce_ajax_added_to_cart_open_header_cart' ) ) ) {
			add_filter( 'body_class', array( $this, 'add_ajax_added_to_cart_effect_class_to_body' ) );
		}
	}

	/**
	 * Add AJAX add to cart CSS class on product form.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_ajax_add_to_cart_class_to_product_form( $classes ) {
		$classes['cakecious-ajax-add-to-cart-form'] = esc_attr( 'cakecious-ajax-add-to-cart-form' );

		return $classes;
	}

	/**
	 * Add added to cart effect CSS class on body tag.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_ajax_added_to_cart_effect_class_to_body( $classes ) {
		$classes['cakecious-ajax-added-to-cart-open-header-cart'] = esc_attr( 'cakecious-ajax-added-to-cart-open-header-cart' );

		return $classes;
	}
}

Cakecious_Pro_Module_WooCommerce_AJAX_Add_To_Cart::instance();