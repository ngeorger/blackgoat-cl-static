<?php
/**
 * Plugin compatibility: Cakecious Pro
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Compatibility_Cakecious_Pro {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Compatibility_Cakecious_Pro
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
	 * @return Cakecious_Compatibility_Cakecious_Pro
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
		/**
		 * Compatibility for Cakecious Pro prior to v1.1.0.
		 */

		// Get the main version without suffix like "dev", "alpha", "beta".
		if ( defined( 'CAKECIOUS_PRO_VERSION' ) && version_compare( preg_replace( '/\-.*/', '', CAKECIOUS_PRO_VERSION ), '1.1.0', '<' ) ) {
			// Add legacy "woocommerce-advanced" module and hide the new modules.
			// Use "0" priority because the legacy "woocommerce-advanced" module needs to be added before any other filters run.
			add_filter( 'cakecious/pro/modules', array( $this, 'fallback_compatibility_for_legacy_woocommerce_advanced_module' ), 0 );

			// Add fallback compatibility for all Cakecious Pro modules dynamic CSS.
			// Since Cakecious v1.1.0, all dynamic CSS are printed using 'wp_add_inline_style' instead of manual printing on 'wp_head'.
			add_filter( 'cakecious/frontend/inline_css', array( $this, 'fallback_compatibility_for_customizer_inline_css' ) );
		}

		/**
		 * Compatibility for Cakecious Pro prior to v1.2.0.
		 */

		// Get the main version without suffix like "dev", "alpha", "beta".
		if ( defined( 'CAKECIOUS_PRO_VERSION' ) && version_compare( preg_replace( '/\-.*/', '', CAKECIOUS_PRO_VERSION ), '1.2.0', '<' ) ) {
			// Modify header bar templates to use HTML attributes for Javascript configuration.
			// Since Cakecious Pro v1.2.0, HTML attributes are no longer used to define Javascript configuration.
			// Instead, localize_script is used to define the configuration.
			add_filter( 'cakecious/template_part/header-desktop-top-bar', array( $this, 'fallback_compatibility_for_header_top_bar_attributes' ) );
			add_filter( 'cakecious/template_part/header-desktop-main-bar', array( $this, 'fallback_compatibility_for_header_main_bar_attributes' ) );
			add_filter( 'cakecious/template_part/header-desktop-bottom-bar', array( $this, 'fallback_compatibility_for_header_bottom_bar_attributes' ) );
			add_filter( 'cakecious/template_part/header-mobile', array( $this, 'fallback_compatibility_for_header_mobile_main_bar_attributes' ) );
		}
	}
	
	/**
	 * ====================================================
	 * Cakecious Pro 1.1.0
	 * ====================================================
	 */

	/**
	 * Add legacy "woocommerce-advanced" module and hide the new modules.
	 *
	 * @param array $modules
	 * @return array
	 */
	public function fallback_compatibility_for_legacy_woocommerce_advanced_module( $modules ) {
		$pro_active_modules = get_option( 'cakecious_pro_active_modules', array() );

		// Hide the new modules.
		foreach ( $modules as $module_slug => $module_data ) {
			if ( 'woocommerce' === $module_data['category'] ) {
				$modules[ $module_slug ]['hide'] = true;
			}
		}

		// Add legacy "woocommerce-advanced" module.
		$modules['woocommerce-advanced'] = array(
			'label'    => esc_html__( 'WooCommerce Advanced (Legacy)', 'cakecious' ),
			'category' => 'woocommerce',
			'url'      => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-dashboard', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-pro-modules-list' ), trailingslashit( CAKECIOUS_URL ) ) ),
		);

		return $modules;
	}

	/**
	 * Add fallback compatibility for all Cakecious Pro modules dynamic CSS.
	 *
	 * @param string $css
	 * @return string
	 */
	public function fallback_compatibility_for_customizer_inline_css( $css ) {
		$postmessages = array();
		$active_modules = get_option( 'cakecious_pro_active_modules', array() );

		foreach ( $active_modules as $i => $module_slug ) {
			// Skip Advanced WooCommerce module if it's activated but no WooCommerce class is found.
			if ( 'woocommerce' === substr( $module_slug, 0, 11 ) && ! class_exists( 'WooCommerce' ) ) {
				continue;
			}

			$postmessages_file = CAKECIOUS_PRO_DIR . 'inc/modules/' . $module_slug . '/customizer/postmessages.php';

			if ( file_exists( $postmessages_file ) ) {
				include( $postmessages_file );
			}
		}

		$generated_css = Cakecious_Customizer::instance()->convert_postmessages_to_css_string( $postmessages );

		if ( ! empty( $generated_css ) ) {
			$css = "\n/* Cakecious Pro Dynamic CSS (fallback compatibility prior Cakecious Pro v1.1.0) */\n" . $generated_css;
		}

		return $css;
	}

	/**
	 * ====================================================
	 * Cakecious Pro 1.2.0
	 * ====================================================
	 */

	/**
	 * Add fallback compatibility for header top bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_top_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'cakecious/frontend/header_top_bar_attrs', array(
			'data-height' => intval( cakecious_get_theme_mod( 'header_top_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="cakecious-header-top-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}

	/**
	 * Add fallback compatibility for header main bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_main_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'cakecious/frontend/header_main_bar_attrs', array(
			'data-height' => intval( cakecious_get_theme_mod( 'header_main_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="cakecious-header-main-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}

	/**
	 * Add fallback compatibility for header bottom bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_bottom_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'cakecious/frontend/header_bottom_bar_attrs', array(
			'data-height' => intval( cakecious_get_theme_mod( 'header_bottom_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="cakecious-header-bottom-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}

	/**
	 * Add fallback compatibility for header mobile main bar templates to use HTML attributes for Javascript configuration.
	 *
	 * @param string $html
	 * @return string
	 */
	public function fallback_compatibility_for_header_mobile_main_bar_attributes( $html ) {
		$attrs_array = apply_filters( 'cakecious/frontend/header_mobile_main_bar_attrs', array(
			'data-height' => intval( cakecious_get_theme_mod( 'header_mobile_main_bar_height' ) ),
		) );
		$attrs = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		$html = preg_replace( '/(<div id="cakecious-header-mobile-main-bar".*?)(>)/', '$1 ' . $attrs . '$2', $html );

		return $html;
	}
}

Cakecious_Compatibility_Cakecious_Pro::instance();