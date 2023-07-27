<?php
/**
 * Cakecious Pro module: Custom Fonts Elementor page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Custom_Fonts_Elementor {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_Custom_Fonts_Elementor
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
	 * @return Cakecious_Pro_Module_Custom_Fonts_Elementor
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
		// Fonts groups
		add_filter( 'elementor/fonts/groups', array( $this, 'add_fonts_groups' ) );

		// Fonts choices
		add_filter( 'elementor/fonts/additional_fonts', array( $this, 'add_fonts_choices' ) );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add Cakecious Custom Fonts group to Elementor fonts groups.
	 */
	public function add_fonts_groups( $groups ) {
		return array_merge(
			array(
				'cakecious_custom_fonts' => sprintf( esc_html__( '%s - Custom', 'cakecious-features' ), cakecious_get_theme_info( 'name' ) ),
			),
			$groups
		);
	}

	/**
	 * Add Cakecious Custom Fonts choices to Elementor fonts choices.
	 */
	public function add_fonts_choices( $choices ) {
		foreach( Cakecious_Pro_Module_Custom_Fonts::instance()->get_custom_fonts() as $font => $stack ) {
			$choices[ $font ] = 'cakecious_custom_fonts';
		}

		return $choices;
	}
}

Cakecious_Pro_Module_Custom_Fonts_Elementor::instance();