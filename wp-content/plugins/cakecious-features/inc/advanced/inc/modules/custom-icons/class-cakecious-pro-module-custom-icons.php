<?php
/**
 * Cakecious Pro module: Custom Icons
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Custom_Icons extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'custom-icons';

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

		add_filter( 'cakecious/frontend/svg_icon_path', array( $this, 'override_default_icons' ), 999, 2 );

		add_filter( 'cakecious/dataset/social_media_types', array( $this, 'add_custom_social_icons' ) );
		add_filter( 'cakecious/frontend/svg_icon_path', array( $this, 'apply_custom_icons_path__add_social' ), 999, 2 );

		// Admin page
		if ( is_admin() ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/class-cakecious-pro-module-' . self::MODULE_SLUG . '-admin.php' );
		}
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Apply override icons paths.
	 *
	 * @param string $path
	 * @param string $key
	 * @return string
	 */
	public function override_default_icons( $path, $key ) {
		if ( ! is_admin() ) {
			$override = get_option( 'cakecious_custom_icons_override', array() );

			if ( isset( $override[ $key ] ) ) {
				$path = get_attached_file( attachment_url_to_postid( $override[ $key ] ) );
			}
		}

		return $path;
	}

	/**
	 * Add new social icons to the icons list.
	 *
	 * @param array $icons
	 * @return array
	 */
	public function add_custom_social_icons( $icons ) {
		$add_social = get_option( 'cakecious_custom_icons_add_social', array() );

		foreach ( $add_social as $slug => $icon ) {
			$icons[ $slug ] = $icon['label'];
		}

		return $icons;
	}

	/**
	 * Apply new social icons paths.
	 *
	 * @param string $path
	 * @param string $key
	 * @return string
	 */
	public function apply_custom_icons_path__add_social( $path, $key ) {
		if ( ! is_admin() ) {
			$add_social = get_option( 'cakecious_custom_icons_add_social', array() );

			if ( isset( $add_social[ $key ] ) ) {
				$path = get_attached_file( attachment_url_to_postid( $add_social[ $key ]['svg'] ) );
			}
		}

		return $path;
	}
}

Cakecious_Pro_Module_Custom_Icons::instance();