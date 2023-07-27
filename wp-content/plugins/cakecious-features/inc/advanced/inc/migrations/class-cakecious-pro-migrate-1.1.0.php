<?php
/**
 * Migrate to 1.1.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Migrate_1_1_0 {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Migrate_1_1_0
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
	 * @return Cakecious_Pro_Migrate_1_1_0
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
		$this->split_woocommerce_advanced_module();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Split "WooCommerce Advanced" module to multiple modules.
	 */
	private function split_woocommerce_advanced_module() {
		$active_modules = get_option( 'cakecious_pro_active_modules', array() );

		if ( in_array( 'woocommerce-advanced', $active_modules ) ) {
			// Add the separate WooCommerce modules.
			foreach ( cakecious_get_pro_modules() as $module_slug => $module_data ) {
				if ( 'woocommerce' === $module_data['category'] ) {
					$active_modules[] = $module_slug;
				}
			}

			// Remove woocommerce-advanced.
			$active_modules = array_diff( $active_modules, array( 'woocommerce-advanced' ) );
			
			// Update option.
			update_option( 'cakecious_pro_active_modules', $active_modules );
		}
	}
}

Cakecious_Pro_Migrate_1_1_0::instance();