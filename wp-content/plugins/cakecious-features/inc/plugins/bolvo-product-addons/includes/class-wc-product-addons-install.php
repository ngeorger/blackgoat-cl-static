<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Installation/Migration Class.
 *
 * Handles the activation/installation of the plugin.
 *
 * @category Installation
 * @version  3.0.0
 */
class WC_Product_Addons_Install {
	/**
	 * Initialize hooks.
	 *
	 * @since 3.0.0
	 * @return bool
	 */
	public static function init() {
		self::run();
	}

	/**
	 * Run the installation.
	 *
	 * @since 3.0.0
	 * @return bool
	 */
	private static function run() {
		if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
			return;
		}

		$installed_version = get_option( 'blv_cust_p_version' );

		self::migration_3_0_product();

		// Check the version before running.
		if ( ! defined( 'IFRAME_REQUEST' ) && ( $installed_version !== WC_PRODUCT_ADDONS_VERSION ) ) {
			if ( ! defined( 'WC_PAO_INSTALLING' ) ) {
				define( 'WC_PAO_INSTALLING', true );
			}

			self::update_plugin_version();

			if ( version_compare( $installed_version, '3.0', '<' ) ) {
				self::migration_3_0();
			}

			do_action( 'blv_cust_p_updated' );
		}
	}

	/**
	 * Updates the plugin version in db.
	 *
	 * @since 3.0.0
	 * @return bool
	 */
	private static function update_plugin_version() {
		delete_option( 'blv_cust_p_version' );
		add_option( 'blv_cust_p_version', WC_PRODUCT_ADDONS_VERSION );
	}

	/**
	 * 3.0 migration script.
	 *
	 * @since 3.0.0
	 */
	private static function migration_3_0() {
		require_once( WC_PRODUCT_ADDONS_PLUGIN_PATH . '/includes/updates/class-wc-product-addons-migration-3-0.php' );
	}

	/**
	 * 3.0 migration script for product level.
	 *
	 * @since 3.0.0
	 */
	private static function migration_3_0_product() {
		require_once( WC_PRODUCT_ADDONS_PLUGIN_PATH . '/includes/updates/class-wc-product-addons-migration-3-0-product.php' );
	}
}

WC_Product_Addons_Install::init();
