<?php
/**
 * Cakecious Pro module: White Label
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_White_Label extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'white-label';

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

		// Admin page
		if ( is_admin() ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/class-cakecious-pro-module-' . self::MODULE_SLUG . '-admin.php' );
		}
	}
}

Cakecious_Pro_Module_White_Label::instance();