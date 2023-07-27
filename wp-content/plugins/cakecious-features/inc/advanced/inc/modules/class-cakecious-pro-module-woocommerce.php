<?php
/**
 * Cakecious Pro WooCommerce module base class
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

abstract class Cakecious_Pro_Module_WooCommerce extends Cakecious_Pro_Module {

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
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Enqueue frontend CSS.
	 */
	public function enqueue_css() {
		parent::enqueue_css();

		if ( ! wp_style_is( 'cakecious-pro-woocommerce', 'enqueued' ) ) {
			// WooCommerce CSS
			wp_enqueue_style( 'cakecious-pro-woocommerce', CAKECIOUS_PRO_URI . 'assets/css/compatibilities/pro-woocommerce' . CAKECIOUS_ASSETS_SUFFIX . '.css', array( 'cakecious-features' ), CAKECIOUS_PRO_VERSION );
			wp_style_add_data( 'cakecious-pro-woocommerce', 'rtl', 'replace' );

			// Inline CSS
			$dynamic_css = trim( apply_filters( 'cakecious/frontend/woocommerce/pro_dynamic_css', '' ) );
			if ( ! empty( $dynamic_css ) ) {
				$dynamic_css = "/* Cakecious Pro + WooCommerce Dynamic CSS */\n" . $dynamic_css;
			}

			wp_add_inline_style( 'cakecious-pro-woocommerce', $dynamic_css );
		}
	}

	/**
	 * Enqueue frontend JS.
	 */
	public function enqueue_js() {
		parent::enqueue_js();

		if ( ! wp_script_is( 'cakecious-pro-woocommerce', 'enqueued' ) ) {
			// WooCommerce JS
			wp_enqueue_script( 'cakecious-pro-woocommerce', CAKECIOUS_PRO_URI . 'assets/js/compatibilities/pro-woocommerce' . CAKECIOUS_ASSETS_SUFFIX . '.js', array( 'jquery', 'flexslider', 'wc-add-to-cart-variation' ), CAKECIOUS_PRO_VERSION, true );
		}
	}
}