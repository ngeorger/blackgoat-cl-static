<?php
/**
 * Cakecious Pro module: Custom Fonts
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Custom_Fonts extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'custom-fonts';

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
		
		// Enqueue custom fonts on frontend
		add_action( 'wp_print_styles', array( $this, 'enqueue_custom_fonts_css' ) );

		// Customizer filters
		add_filter( 'cakecious/dataset/all_fonts', array( $this, 'add_custom_fonts_to_all_fonts' ) );

		// Elementor compatibility
		if ( class_exists( '\Elementor\Plugin' ) ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/class-cakecious-pro-module-' . self::MODULE_SLUG . '-elementor.php' );
		}

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
	 * Enqueue custom fonts CSS on frontend.
	 */
	public function enqueue_custom_fonts_css() {
		// Customizer Custom Fonts
		$custom_fonts_css = $this->generate_custom_fonts_css();
		if ( ! empty( $custom_fonts_css ) ) {
			echo '<style id="cakecious-custom-fonts-css" type="text/css">' . $custom_fonts_css . '</style>' . "\n";
		}
	}

	/**
	 * Add custom fonts to Customizer typography control.
	 *
	 * @param array $choices
	 * @return array
	 */
	public function add_custom_fonts_to_all_fonts( $choices ) {
		$choices['custom_fonts'] = $this->get_custom_fonts();

		return $choices;
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return array of Custom Fonts choices.
	 * 
	 * @return array
	 */
	public function get_custom_fonts() {
		$custom_fonts = get_option( 'cakecious_custom_fonts', array() );
		$list = array();

		if ( 0 < count( $custom_fonts ) ) {
			foreach ( $custom_fonts as $name => $font ) {
				$list[ $name ] = '"' . $font['name'] . '"';
			}
		}

		return $list;
	}

	/**
	 * Generate Custom Fonts CSS for enqueueing the fonts.
	 *
	 * @param 
	 * @return string
	 */
	public function generate_custom_fonts_css() {
		$custom_fonts = get_option( 'cakecious_custom_fonts', array() );
		$final_css = '';

		foreach ( $custom_fonts as $name => $font ) {
			// Skip if no name is specified for this custom font.
			if ( empty( $font['name'] ) ) return;

			$css = '';

			foreach ( $font['variants'] as $variant ) {
				// Font family
				$css .= '@font-face{font-family:"' . $font['name'] . '";';

				// Weight & Style
				list( $weight, $style ) = explode( '|', $variant );
				$css .= 'font-weight:' . $weight . ';font-style:' . $style . ';';

				// Sources
				$src = array();
				if ( ! empty( $font['file_' . $variant . '_eot'] ) ) {
					$css .= 'src:url("' . esc_url( $font['file_' . $variant . '_eot'] ) . '");';
					$src[] = 'url("' . esc_url( $font['file_' . $variant . '_eot'] ) . '?iefix") format("embedded-opentype")';
				}
				if ( ! empty( $font['file_' . $variant . '_woff2'] ) ) {
					$src[] = 'url("' . esc_url( $font['file_' . $variant . '_woff2'] ) . '") format("woff2")';
				}
				if ( ! empty( $font['file_' . $variant . '_woff'] ) ) {
					$src[] = 'url("' . esc_url( $font['file_' . $variant . '_woff'] ) . '") format("woff")';
				}
				if ( ! empty( $font['file_' . $variant . '_ttf'] ) ) {
					$src[] = 'url("' . esc_url( $font['file_' . $variant . '_ttf'] ) . '") format("truetype")';
				}
				if ( ! empty( $font['file_' . $variant . '_svg'] ) ) {
					$src[] = 'url("' . esc_url( $font['file_' . $variant . '_svg'] ) . '") format("svg")';
				}
				$css .= 'src:' . implode( ',', $src ) . ';}';
			}

			$final_css .= $css;
		}

		return $final_css;
	}
}

Cakecious_Pro_Module_Custom_Fonts::instance();