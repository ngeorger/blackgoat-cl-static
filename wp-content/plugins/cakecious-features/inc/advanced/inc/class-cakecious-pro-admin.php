<?php
/**
 * Cakecious Pro admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Admin
	 */
	private static $instance;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Cakecious_Pro_Admin
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {

		add_action( 'cakecious/admin/after_enqueue_admin_css', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'cakecious/admin/after_enqueue_admin_js', array( $this, 'enqueue_admin_javascripts' ) );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_panel_scripts' ) );
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_styles( $hook ) {
		// Fetched version from package.json
		$ver = array();
		$ver['select2'] = '4.0.10';

		wp_register_style( 'select2', trailingslashit( CAKECIOUS_PRO_CSS_URL ) . 'vendors/select2' . CAKECIOUS_ASSETS_SUFFIX . '.css', array(), $ver['select2'] );

		wp_enqueue_style( 'cakecious-pro-admin', trailingslashit( CAKECIOUS_PRO_CSS_URL ) . 'admin/pro-admin' . CAKECIOUS_ASSETS_SUFFIX . '.css', array( 'select2' ), CAKECIOUS_PRO_VERSION );
		wp_style_add_data( 'cakecious-pro-admin', 'rtl', 'replace' );
	}

	/**
	 * Enqueue admin javascripts.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_javascripts( $hook ) {
		// Fetched version from package.json
		$ver = array();
		$ver['jquery-repeater'] = '1.2.1';
		$ver['select2'] = '4.0.10';

		wp_register_script( 'jquery-repeater', trailingslashit( CAKECIOUS_PRO_JS_URL ) . 'vendors/jquery.repeater' . CAKECIOUS_ASSETS_SUFFIX . '.js', array( 'jquery' ), $ver['jquery-repeater'], true );
		wp_register_script( 'select2', trailingslashit( CAKECIOUS_PRO_JS_URL ) . 'vendors/select2' . CAKECIOUS_ASSETS_SUFFIX . '.js', array(), $ver['select2'], true );

		wp_enqueue_script( 'cakecious-pro-admin', trailingslashit( CAKECIOUS_PRO_JS_URL ) . 'admin/pro-admin' . CAKECIOUS_ASSETS_SUFFIX . '.js', array( 'jquery-repeater', 'select2' ), CAKECIOUS_PRO_VERSION, true );
		wp_localize_script( 'cakecious-pro-admin', 'cakeciousProAdminData', array(
			'ajaxNonce' => wp_create_nonce( 'cakecious-pro-admin' ),
		) );
	}

	/**
	 * Enqueue Customizer panel scripts.
	 */
	public function enqueue_customizer_panel_scripts() {
		wp_enqueue_script( 'cakecious-pro-customize-controls', trailingslashit( CAKECIOUS_PRO_JS_URL ) . 'admin/pro-customize-controls' . CAKECIOUS_ASSETS_SUFFIX . '.js', array( 'cakecious-customize-controls' ), CAKECIOUS_PRO_VERSION, true );
	}

}

Cakecious_Pro_Admin::instance();