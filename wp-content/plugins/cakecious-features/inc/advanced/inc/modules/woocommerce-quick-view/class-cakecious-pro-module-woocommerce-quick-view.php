<?php
/**
 * Cakecious Pro module: WooCommerce Quick View
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_WooCommerce_Quick_View extends Cakecious_Pro_Module_WooCommerce {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'woocommerce-quick-view';

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
		add_action( 'init', array( $this, 'modify_template_hooks' ) );

		// AJAX callbacks
		add_action( 'wp_ajax_cakecious_woocommerce_render_product_quick_view', array( $this, 'ajax_woocommerce_render_product_quick_view' ) );
		add_action( 'wp_ajax_nopriv_cakecious_woocommerce_render_product_quick_view', array( $this, 'ajax_woocommerce_render_product_quick_view' ) );
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

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--quick-view.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/woocommerce--ajax-add-to-cart.php' );
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
	public function modify_template_hooks() {
		// Add quick view.
		if ( intval( cakecious_get_theme_mod( 'woocommerce_quick_view' ) ) ) {
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'render_quick_view_button' ), 20 );
			add_action( 'cakecious/frontend/after_canvas', array( $this, 'render_quick_view_popup' ) );
			add_filter( 'cakecious/frontend/woocommerce/loop_item_thumbnail_classes', array( $this, 'add_quick_view_class_to_product_image' ) );
		}
	}

	/**
	 * Add AJAX add to cart CSS class on Quick View popup form.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_ajax_add_to_cart_class_to_quick_view_popup( $classes ) {
		$classes['cakecious-ajax-add-to-cart-form'] = esc_attr( 'cakecious-ajax-add-to-cart-form' );

		return $classes;
	}
	
	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render quick view button on product thumbnail wrapper.
	 */
	public function render_quick_view_button() {
		cakecious_get_template_part( 'woocommerce-quick-view-button' );
	}

	/**
	 * Render quick view popup.
	 */
	public function render_quick_view_popup() {
		cakecious_get_template_part( 'woocommerce-quick-view-popup' );
	}

	/**
	 * Add CSS class on product image wrapper to identify quick view functionality.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_quick_view_class_to_product_image( $classes ) {
		$classes['woocommerce-quick-view'] = 'cakecious-product-thumbnail-with-quick-view';

		return $classes;
	}
	
	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to get status of plugins.
	 */
	public function ajax_woocommerce_render_product_quick_view() {
		if ( ! isset( $_GET['product_id'] ) ) {
			wp_die();
		}

		if ( function_exists( 'wc_get_product' ) ) {
			// Temporarily override the global $post variable.
			global $post;
			$temp = $post;

			// Get the product.
			$post = get_post( $_GET['product_id'] );

			// Abort if it's not a WooCommerce product.
			if ( 'product' !== get_post_type( $post ) ) {
				wp_die();
			}
			
			// Assign to global post.
			setup_postdata( $post );

			// Remove all actions after product summary.
			remove_all_actions( 'woocommerce_after_single_product_summary' );

			// Whether enable AJAX Add to Cart on Quick View popup.
			if ( intval( cakecious_get_theme_mod( 'woocommerce_quick_view_ajax_add_to_cart' ) ) ) {
				add_filter( 'cakecious/frontend/woocommerce/add_to_cart_form_classes', array( $this, 'add_ajax_add_to_cart_class_to_quick_view_popup' ) );
			}

			// Print single product.
			if ( function_exists( 'wc_get_template_part' ) ) {
				wc_get_template_part( 'content', 'single-product' );
			}

			// Reset global post to its original.
			$post = $temp;
			wp_reset_postdata();
		}

		wp_die();
	}
}

Cakecious_Pro_Module_WooCommerce_Quick_View::instance();