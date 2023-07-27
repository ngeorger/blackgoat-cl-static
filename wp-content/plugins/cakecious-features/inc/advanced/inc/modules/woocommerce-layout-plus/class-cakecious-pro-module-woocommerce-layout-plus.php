<?php
/**
 * Cakecious Pro module: WooCommerce Plus
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_WooCommerce_Layout_Plus extends Cakecious_Pro_Module_WooCommerce {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'woocommerce-layout-plus';

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

		// Dynamic CSS
		add_filter( 'cakecious/frontend/woocommerce/pro_dynamic_css', array( $this, 'add_dynamic_css' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );

		// Template hooks
		add_action( 'wp', array( $this, 'modify_template_hooks_after_init' ) );

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
	 * Add dynamic CSS from customizer settings into the inline CSS.
	 *
	 * @param string $css
	 * @return string
	 */
	public function add_dynamic_css( $css ) {
		// Skip adding dynamic CSS on customizer preview frame.
		if ( is_customize_preview() ) {
			return $css;
		}

		$postmessages = include( CAKECIOUS_PRO_DIR . '/inc/modules/' . self::MODULE_SLUG . '/customizer/postmessages.php' );
		$defaults = include( CAKECIOUS_PRO_DIR . '/inc/modules/' . self::MODULE_SLUG . '/customizer/defaults.php' );

		$css .= Cakecious_Customizer::instance()->convert_postmessages_to_css_string( $postmessages, $defaults );

		return $css;
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--product-single.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--products-grid.php' );
	}
	
	/**
	 * Add default values for all Customizer settings.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		$add = include( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/defaults.php' );

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_customizer_setting_postmessages( $postmessages = array() ) {
		$add = include( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/postmessages.php' );

		return array_merge_recursive( $postmessages, $add );
	}

	/**
	 * Modify filters for WooCommerce template rendering.
	 */
	public function modify_template_hooks_after_init() {
		/**
		 * Shop page's template hooks
		 */

		// Add product image's ignore padding class on product thumbnail wrapper.
		if ( intval( cakecious_get_theme_mod( 'woocommerce_products_grid_item_image_ignore_padding' ) ) ) {
			add_filter( 'cakecious/frontend/woocommerce/loop_item_thumbnail_classes', array( $this, 'add_loop_item_thumbnail_ignore_padding_class' ) );
		}

		// Add alt hover image class on product thumbnail wrapper.
		if ( intval( cakecious_get_theme_mod( 'woocommerce_products_grid_item_alt_hover_image' ) ) ) {
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'render_loop_item_thumbnail_alt_hover_image' ), 11 );
			add_filter( 'cakecious/frontend/woocommerce/loop_item_thumbnail_classes', array( $this, 'add_loop_item_thumbnail_alt_hover_class' ) );
		}

		// Add same height class to products grid.
		if ( intval( cakecious_get_theme_mod( 'woocommerce_products_grid_same_height_items' ) ) ) {
			add_filter( 'cakecious/frontend/woocommerce/loop_classes', array( $this, 'add_loop_same_height_items_class' ) );
		}

		/**
		 * Product page's template hooks
		 */

		// Add gallery layout class on single product gallery wrapper.
		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
			add_filter( 'woocommerce_single_product_image_gallery_classes', array( $this, 'add_single_product_gallery_layout_class' ) );
		}
	}

	/**
	 * Add product image's ignore padding class on product thumbnail wrapper.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_loop_item_thumbnail_ignore_padding_class( $classes ) {
		$classes['cakecious-product-thumbnail-ignore-padding'] = esc_attr( 'cakecious-product-thumbnail-ignore-padding' );

		return $classes;
	}

	/**
	 * Add alt hover image class on product thumbnail wrapper.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_loop_item_thumbnail_alt_hover_class( $classes ) {
		global $product;

		$gallery_ids = $product->get_gallery_image_ids();

		if ( 0 < count( $gallery_ids ) ) {
			$classes['cakecious-product-thumbnail-alt-hover-image'] = esc_attr( 'cakecious-product-thumbnail-alt-hover-image' );
		}

		return $classes;
	}

	/**
	 * Render alt hover image on product thumbnail wrapper.
	 */
	public function render_loop_item_thumbnail_alt_hover_image() {
		global $product;

		$gallery_ids = $product->get_gallery_image_ids();

		if ( 0 < count( $gallery_ids ) ) {
			echo wp_get_attachment_image( $gallery_ids[0], 'woocommerce_thumbnail' );
		}
	}

	/**
	 * Add same height items class on products loop.
	 * 
	 * @param array $classes
	 * @return array
	 */
	public function add_loop_same_height_items_class( $classes ) {
		$classes['cakecious-products-grid-same-height'] = esc_attr( 'cakecious-products-grid-same-height' );
		
		return $classes;
	}

	/**
	 * Add additional class on single product wrapper.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_single_product_gallery_layout_class( $classes ) {
		$classes['cakecious-single-gallery-layout'] = esc_attr( 'cakecious-woocommerce-single-gallery-layout-' . cakecious_get_current_page_setting( 'woocommerce_single_gallery_layout' ) );

		return $classes;
	}
}

Cakecious_Pro_Module_WooCommerce_Layout_Plus::instance();