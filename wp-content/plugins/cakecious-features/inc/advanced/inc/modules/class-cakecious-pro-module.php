<?php
/**
 * Cakecious Pro module base class
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

abstract class Cakecious_Pro_Module {

	/**
	 * Singleton instances
	 *
	 * @var array()
	 */
	protected static $instances = array();

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = '';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Cakecious_Pro_Module_WooCommerce_Quick_View
	 */
	public static function instance() {
		$called_class = get_called_class();
		if ( empty( static::$instances[ $called_class ] ) ) {
			static::$instances[ $called_class ] = new static();
		}
		return static::$instances[ $called_class ];
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		// Frontend CSS & JS
		add_action( 'cakecious/frontend/after_enqueue_main_css', array( $this, 'enqueue_css' ), 20 );
		add_action( 'cakecious/frontend/after_enqueue_main_js', array( $this, 'enqueue_js' ), 20 );
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
		if ( ! wp_style_is( 'cakecious-features', 'enqueued' ) ) {
			// Main CSS
			wp_enqueue_style( 'cakecious-features', CAKECIOUS_PRO_URI . 'assets/css/pro' . CAKECIOUS_ASSETS_SUFFIX . '.css', array( 'cakecious' ), CAKECIOUS_PRO_VERSION );
			wp_style_add_data( 'cakecious-features', 'rtl', 'replace' );

			// Inline CSS
			$dynamic_css = trim( apply_filters( 'cakecious/frontend/pro_dynamic_css', '' ) );
			if ( ! empty( $dynamic_css ) ) {
				$dynamic_css = "/* Cakecious Pro Dynamic CSS */\n" . $dynamic_css;
			}

			wp_add_inline_style( 'cakecious-features', $dynamic_css );
		}
	}

	/**
	 * Enqueue frontend JS.
	 */
	public function enqueue_js() {
		if ( ! wp_script_is( 'cakecious-features', 'enqueued' ) ) {
			// Main JS
			wp_enqueue_script( 'cakecious-features', CAKECIOUS_PRO_URI . 'assets/js/pro' . CAKECIOUS_ASSETS_SUFFIX . '.js', array( 'cakecious' ), CAKECIOUS_PRO_VERSION, true );

			wp_localize_script( 'cakecious-features', 'cakeciousProConfig', apply_filters( 'cakecious/frontend/pro_localize_script', array(
				'ajaxURL' => admin_url( 'admin-ajax.php' ),
			) ) );
		}
	}
}