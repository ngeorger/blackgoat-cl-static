<?php
/**
 * Cakecious Pro module: WooCommerce Checkout Optimization
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_WooCommerce_Checkout_Optimization extends Cakecious_Pro_Module_WooCommerce {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'woocommerce-checkout-optimization';

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

		// Template hooks
		add_action( 'wp', array( $this, 'modify_template_hooks_based_on_page_type' ) );
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

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--cart.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--checkout.php' );
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
	 * Modify filters for WooCommerce template rendering based on Customizer settings.
	 */
	public function modify_template_hooks_based_on_page_type() {
		/**
		 * Cart page's template hooks
		 */

		// Add mobile sticky checkout button.
		if ( is_cart() && intval( cakecious_get_theme_mod( 'woocommerce_cart_mobile_sticky_checkout_button' ) ) ) {
			add_action( 'woocommerce_before_cart_totals', array( $this, 'render_cart_mobile_sticky_checkout' ), 9 );
		}

		/**
		 * Checkout page's template hooks
		 */

		// Implement distraction free mode on checkout page.
		if ( is_checkout() && intval( cakecious_get_theme_mod( 'woocommerce_checkout_distraction_free' ) ) ) {
			// Replace default header & footer elements.
			add_filter( 'cakecious/customizer/setting_value', array( $this, 'set_distraction_free_header_footer_elements' ), 10, 2 );
			
			// Replace default page settings.
			add_filter( 'cakecious/page_settings/setting_value', array( $this, 'set_distraction_free_page_settings' ), 10, 2 );
		}
	}

	/**
	 * Manually set header & footer elements on distraction free mode.
	 *
	 * @param mixed $value
	 * @param string $key
	 * @param mixed default
	 * @return mixed
	 */
	public function set_distraction_free_header_footer_elements( $value, $key ) {
		if ( 0 === strpos( $key, 'header_elements_' ) ) {
			if ( 'header_elements_main_center' === $key ) {
				$value = array( 'logo' );
			} else {
				$value = array();
			}
		} elseif ( 0 === strpos( $key, 'header_mobile_elements_' ) ) {
			if ( 'header_mobile_elements_main_center' === $key ) {
				$value = array( 'mobile-logo' );
			} else {
				$value = array();
			}
		} elseif ( 0 === strpos( $key, 'footer_elements_' ) ) {
			if ( 'footer_elements_bottom_center' === $key ) {
				$value = array( 'copyright' );
			} else {
				$value = array();
			}
		}

		return $value;
	}

	/**
	 * Manually assign page settings on distraction free mode.
	 *
	 * @param mixed $value
	 * @param string $key
	 * @param mixed default
	 * @return mixed
	 */
	public function set_distraction_free_page_settings( $value, $key ) {
		switch ( $key ) {
			case 'header_sticky':
			case 'header_mobile_sticky':
			case 'header_transparent':
			case 'header_mobile_transparent':
			case 'page_header':
				$value = false;
				break;

			case 'disable_footer_widgets':
				$value = true;
				break;
		}

		return $value;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render mobile sticky checkout button on cart page.
	 */
	public function render_cart_mobile_sticky_checkout() {
		cakecious_get_template_part( 'woocommerce-mobile-sticky-checkout-button' );
	}
}

Cakecious_Pro_Module_WooCommerce_Checkout_Optimization::instance();