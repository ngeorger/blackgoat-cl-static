<?php
/**
 * Plugin compatibility: WooCommerce
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Compatibility_WooCommerce {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Compatibility_WooCommerce
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
	 * @return Cakecious_Compatibility_WooCommerce
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
		// Theme supports
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

		// Compatibility CSS
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'disable_original_css' ) );
		add_action( 'cakecious/frontend/after_enqueue_main_css', array( $this, 'enqueue_css' ) );
		add_filter( 'cakecious/frontend/woocommerce/dynamic_css', array( $this, 'add_dynamic_css' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );
		add_filter( 'cakecious/customizer/control_contexts', array( $this, 'add_control_contexts' ) );
		add_filter( 'cakecious/customizer/preview_contexts', array( $this, 'add_preview_contexts' ) );
		add_filter( 'cakecious/dataset/header_builder_configurations', array( $this, 'modify_header_builder_configurations' ) );
		add_filter( 'cakecious/dataset/mobile_header_builder_configurations', array( $this, 'modify_mobile_header_builder_configuratinos' ) );
		add_filter( 'cakecious/customizer/auto_page_options/excluded_post_types', array( $this, 'exclude_from_auto_page_options' ) );

		// Template hooks
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'init', array( $this, 'modify_template_hooks' ) );
		add_action( 'wp', array( $this, 'modify_template_hooks_after_init' ) );
		
		// Page settings
		add_action( 'cakecious/admin/metabox/page_settings/disabled_posts', array( $this, 'exclude_shop_page_from_page_settings' ), 10, 2 );
		
		add_filter( 'cakecious/admin/metabox/page_settings/tabs', array( $this, 'add_page_settings_tab__product' ) );
		add_action( 'cakecious/admin/metabox/page_settings/fields', array( $this, 'render_page_settings_fields__product' ), 10, 2 );
		add_filter( 'cakecious/dataset/fallback_page_settings', array( $this, 'add_page_settings_fallback_values__product' ) );

		add_filter( 'update_option_woocommerce_cart_page_id', array( $this, 'set_default_page_settings_on_woocommerce_pages' ), 10, 3 );
		add_filter( 'update_option_woocommerce_checkout_page_id', array( $this, 'set_default_page_settings_on_woocommerce_pages' ), 10, 3 );
		add_filter( 'update_option_woocommerce_myaccount_page_id', array( $this, 'set_default_page_settings_on_woocommerce_pages' ), 10, 3 );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Define WooCommerce theme's supports.
	 */
	public function add_theme_supports() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-lightbox' );
	}

	/**
	 * Enqueue compatibility CSS.
	 */
	public function enqueue_css() {
		wp_enqueue_style( 'cakecious-woocommerce', CAKECIOUS_CSS_URL . '/compatibilities/woocommerce/woocommerce' . CAKECIOUS_ASSETS_SUFFIX . '.css', array(), CAKECIOUS_VERSION );
		wp_style_add_data( 'cakecious-woocommerce', 'rtl', 'replace' );

		// Inline CSS
		wp_add_inline_style( 'cakecious-woocommerce', trim( apply_filters( 'cakecious/frontend/woocommerce/dynamic_css', '' ) ) );
	}

	/**
	 * Disable original WooCommerce CSS.
	 *
	 * @param array $styles
	 * @return array
	 */
	public function disable_original_css( $styles ) {
		$styles['woocommerce-layout']['src'] = false;
		$styles['woocommerce-smallscreen']['src'] = false;
		$styles['woocommerce-general']['src'] = false;
		
		return $styles;
	}

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

		$postmessages = include( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/postmessages.php' );
		$defaults = include( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/defaults.php' );

		$generated_css = Cakecious_Customizer::instance()->convert_postmessages_to_css_string( $postmessages, $defaults );

		if ( ! empty( $generated_css ) ) {
			$css .= "\n/* Cakecious + WooCommerce Dynamic CSS */\n" . $generated_css;
		}

		return $css;
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();
		
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/_sections.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--store-notice.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--product-catalog.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--product-single.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--cart.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--checkout.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--products-grid.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/options/woocommerce--other-elements.php' );
	}

	/**
	 * Add default values for all Customizer settings.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_customizer_setting_defaults( $defaults = array() ) {
		$add = include( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/defaults.php' );

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_customizer_setting_postmessages( $postmessages = array() ) {
		$add = include( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/postmessages.php' );

		return array_merge_recursive( $postmessages, $add );
	}

	/**
	 * Add dependency contexts for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $contexts
	 * @return array
	 */
	public function add_control_contexts( $contexts = array() ) {
		$add = include( CAKECIOUS_INCLUDES_DIR . '/compatibilities/woocommerce/customizer/contexts.php' );

		return array_merge_recursive( $contexts, $add );
	}

	/**
	 * Allow others to add more preview contexts.
	 *
	 * @param array $contexts
	 * @return array
	 */
	public function add_preview_contexts( $contexts = array() ) {
		// Add Customizer’s preview contexts for Cart and Checkout pages.
		$contexts['woocommerce_cart'] = esc_url( wc_get_cart_url() );		
		$contexts['woocommerce_checkout'] = esc_url( wc_get_checkout_url() );

		return $contexts;
	}

	/**
	 * Modify header builder configurations.
	 *
	 * @param array $config
	 * @return array
	 */
	public function modify_header_builder_configurations( $config ) {
		$config = array_merge_recursive( array(
			'choices' => array(
				'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'cakecious' ),
				'shopping-cart-dropdown' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Dropdown', 'cakecious' ),
			)
		), $config );

		return $config;
	}

	/**
	 * Modify mobile header builder configurations.
	 *
	 * @param array $config
	 * @return array
	 */
	public function modify_mobile_header_builder_configuratinos( $config ) {
		$config = array_merge_recursive( array(
			'choices' => array(
				'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'cakecious' ),
				'shopping-cart-dropdown' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Dropdown', 'cakecious' ),
			),
			'limitations' => array(
				'shopping-cart-link'     => array( 'vertical_top' ),
				'shopping-cart-dropdown' => array( 'vertical_top' ),
			),
		), $config );

		return $config;
	}

	/**
	 * Exclude 'product' post type from auto page options.
	 * 
	 * @param array $post_types
	 * @return array
	 */
	public function exclude_from_auto_page_options( $post_types ) {
		$post_types[] = 'product';

		return $post_types;
	}

	/**
	 * Register additional sidebar for WooCommerce.
	 */
	public function register_sidebars() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Shop', 'cakecious' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Sidebar that replaces the default sidebar when on WooCommerce pages.', 'cakecious' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

	/**
	 * Modify filters for WooCommerce template rendering.
	 */
	public function modify_template_hooks() {
		/**
		 * Global template hooks
		 */

		// Change "Products" in theme's breadcrumb trails to Shop page's title.
		add_filter( 'cakecious/frontend/breadcrumb_trail', array( $this, 'modify_theme_breadcrumb_trails' ) );

		// Change main content (primary) wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', 'cakecious_primary_open' );
		add_action( 'woocommerce_after_main_content', 'cakecious_primary_close' );

		// Add count to Cart menu item.
		add_filter( 'nav_menu_item_title', array( $this, 'add_count_to_cart_menu_item' ), 10, 4 );

		// Add filter for adding class to products grid wrapper.
		add_filter( 'woocommerce_product_loop_start', array( $this, 'change_loop_start_markup' ) );

		// Change mobile devices breakpoint.
		add_filter( 'woocommerce_style_smallscreen_breakpoint', array( $this, 'set_smallscreen_breakpoint' ) );

		// Add cart fragments.
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'update_header_cart' ) );

		// Product search form widget
		add_filter( 'get_product_search_form', array( $this, 'add_icon_to_product_search_widget' ) );

		// Add text alignment class on products loop.
		add_filter( 'cakecious/frontend/woocommerce/loop_item_classes', array( $this, 'add_loop_item_alignment_class' ) );

		// Modify "added to cart" message.
		add_filter( 'wc_add_to_cart_message_html', array( $this, 'change_add_to_cart_message_html' ), 10, 3 );

		//  Modify flexslider settings on single product page.
		add_filter( 'woocommerce_single_product_carousel_options', array( $this, 'change_single_product_carousel_options' ), 10, 3 );

		// Add plus and minus buttons to the quantity input.
		add_action( 'woocommerce_after_quantity_input_field', array( $this, 'add_quantity_plus_minus_buttons' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_quantity_plus_minus_buttons_scripts' ) );

		/**
		 * Shop page's template hooks
		 */

		// Add wrapper to products grid filters.
		add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_filters_wrapper' ), 11 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'render_loop_filters_wrapper_end' ), 999 );

		// Add wrapper to products grid item.
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'render_loop_item_wrapper' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_loop_item_wrapper_end' ), 999 );

		// Reposition sale badge on products grid item.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 2 );

		// Reposition product image and wrap it with custom <div>.
		if ( defined( 'CAKECIOUS_PRO_VERSION' ) && version_compare( preg_replace( '/\-.*/', '', CAKECIOUS_PRO_VERSION ), '1.1.0', '<' ) ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'render_loop_product_thumbnail_wrapper' ), 2 );
			add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 5 );
			add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_close', 15 );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'render_loop_product_thumbnail_wrapper_end' ), 20 );
		} else {
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'render_loop_product_thumbnail_wrapper' ), 1 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 19 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'render_loop_product_thumbnail_wrapper_end' ), 999 );
		}

		// Wrap the title with link.
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 1 );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 999 );

		// Products loop
		add_filter( 'loop_shop_per_page', array( $this, 'set_loop_posts_per_page' ) );
		add_filter( 'loop_shop_columns', array( $this, 'set_loop_columns' ) );

		/**
		 * Product page's template hooks
		 */

		// Add a new filter to add additional classes to single product wrapper.
		add_action( 'woocommerce_before_single_product', array( $this, 'add_single_product_class' ) );

		// Add class to single product gallery for single image or multiple images.
		add_filter( 'woocommerce_single_product_image_gallery_classes', array( $this, 'add_single_product_gallery_class' ) );

		// Move sale badge
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 21 );

		// Set product images thumbnails columns.
		add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'set_product_thumbnails_columns' ) );

		// Add wrapper to single product add to cart form.
		add_filter( 'woocommerce_before_add_to_cart_form', array( $this, 'render_add_to_cart_form_wrapper' ) );
		add_filter( 'woocommerce_after_add_to_cart_form', array( $this, 'render_add_to_cart_form_wrapper_end' ) );

		// Related products
		add_filter( 'woocommerce_related_products_args', array( $this, 'set_related_products_args' ) );
		add_filter( 'woocommerce_related_products_columns', array( $this, 'set_related_products_columns' ) );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'set_related_products_display_args' ) );

		// Up sells
		add_filter( 'woocommerce_up_sells_columns', array( $this, 'set_up_sells_columns' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'set_up_sells_display_args' ) );

		/**
		 * Cart page's template hooks
		 */

		// Cross sells columns
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'set_cart_page_cross_sells_columns' ) );

		/**
		 * My Account page's template hooks
		 */

		// Add account avatar and name into side navigation.
		add_filter( 'woocommerce_before_account_navigation', array( $this, 'render_account_sidebar_wrapper' ), 1 );
		add_filter( 'woocommerce_after_account_navigation', array( $this, 'render_account_sidebar_wrapper_end' ), 999 );
	}

	/**
	 * Modify filters for WooCommerce template rendering based on Customizer settings.
	 */
	public function modify_template_hooks_after_init() {
		/**
		 * Global template hooks
		 */

		// Keep / remove "add to cart" button on products grid.
		if ( ! intval( cakecious_get_theme_mod( 'woocommerce_products_grid_item_add_to_cart' ) ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		}

		// Keep / remove gallery zoom module.
		if ( ! intval( cakecious_get_theme_mod( 'woocommerce_single_gallery_zoom' ) ) ) {
			remove_theme_support( 'wc-product-gallery-zoom' );
		}

		// Keep / remove gallery lightbox module.
		if ( ! intval( cakecious_get_theme_mod( 'woocommerce_single_gallery_lightbox' ) ) ) {
			remove_theme_support( 'wc-product-gallery-lightbox' );
		}

		/**
		 * Shop page's template hooks
		 */

		if ( is_shop() || is_product_taxonomy() ) {
			// Keep / remove page title.
			if ( ! intval( cakecious_get_theme_mod( 'woocommerce_index_page_title' ) ) ) {
				add_filter( 'woocommerce_show_page_title', '__return_false' );
			}

			// Keep / remove breadcrumb.
			if ( ! intval( cakecious_get_theme_mod( 'woocommerce_index_breadcrumb' ) ) ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			}

			// Keep / remove products count filter.
			if ( ! intval( cakecious_get_theme_mod( 'woocommerce_index_results_count' ) ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			// Keep / remove products sorting filter.
			if ( ! intval( cakecious_get_theme_mod( 'woocommerce_index_sort_filter' ) ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}

		/**
		 * Products page's template hooks
		 */

		if ( is_product() ) {
			// Keep / remove breadcrumb.
			if ( ! intval( cakecious_get_current_page_setting( 'woocommerce_single_breadcrumb' ) ) ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			} else {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 1 );
			}

			// Keep / remove gallery.
			if ( ! intval( cakecious_get_current_page_setting( 'woocommerce_single_gallery' ) ) ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			}

			// Keep / remove tabs.
			if ( ! intval( cakecious_get_current_page_setting( 'woocommerce_single_tabs' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			}

			// Keep / remove up-sells.
			if ( ! intval( cakecious_get_current_page_setting( 'woocommerce_single_up_sells' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			}

			// Keep / remove up-sells.
			if ( ! intval( cakecious_get_current_page_setting( 'woocommerce_single_related' ) ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
		}

		/**
		 * Cart page's template hooks
		 */

		if ( is_cart() ) {
			// Split into 2 columns.
			if ( '2-columns' === cakecious_get_theme_mod( 'woocommerce_cart_layout' ) ) {
				add_filter( 'body_class', array( $this, 'add_cart_two_columns_class' ) );

				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
				add_action( 'woocommerce_before_cart_collaterals', 'woocommerce_cross_sell_display', 20 );

				add_action( 'woocommerce_before_cart', array( $this, 'render_cart_2_columns_left_wrapper' ), 99999 );
				add_action( 'woocommerce_before_cart_collaterals', array( $this, 'render_cart_2_columns_left_wrapper_end' ), 99999 );

				add_action( 'woocommerce_before_cart_collaterals', array( $this, 'render_cart_2_columns_right_wrapper' ), 99999 );
				add_action( 'woocommerce_after_cart', array( $this, 'render_cart_2_columns_right_wrapper_end' ), 99999 );
			}

			// Keep / remove cross-sells.
			if ( ! intval( cakecious_get_theme_mod( 'woocommerce_cart_cross_sells' ) ) ) {
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
				remove_action( 'woocommerce_before_cart_collaterals', 'woocommerce_cross_sell_display', 20 ); // If 2 columns layout is enabled.
			}
		}

		/**
		 * Checkout page's template hooks
		 */

		if ( is_checkout() ) {
			// Split into 2 columns.
			if ( '2-columns' === cakecious_get_theme_mod( 'woocommerce_checkout_layout' ) ) {
				add_filter( 'body_class', array( $this, 'add_checkout_two_columns_class' ) );

				add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'render_checkout_2_columns_left_wrapper' ), 0 );
				add_action( 'woocommerce_checkout_after_customer_details', array( $this, 'render_checkout_2_columns_left_wrapper_end' ), 99999 );

				add_action( 'woocommerce_checkout_before_order_review_heading', array( $this, 'render_checkout_2_columns_right_wrapper' ), 0 );
				add_action( 'woocommerce_checkout_after_order_review', array( $this, 'render_checkout_2_columns_right_wrapper_end' ), 99999 );
			}
		}
	}

	/**
	 * Modify page settings metabox.
	 *
	 * @param array $ids
	 * @param array $post
	 * @return array
	 */
	public function exclude_shop_page_from_page_settings( $ids, $post ) {
		if ( $post->ID === wc_get_page_id( 'shop' ) ) {
			$ids[ $post->ID ] = '<p><a href="' . esc_attr( add_query_arg( array( 'autofocus[section]' => 'cakecious_section_page_settings_product_archive', 'url' => esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) ), admin_url( 'customize.php' ) ) ) . '">' .  esc_html__( 'Edit Page settings here', 'cakecious' ) . '</a></p>';
		}

		return $ids;
	}

	/**
	 * Add "Product Layout" tab on Individual Page Settings meta box.
	 *
	 * @param array $tabs
	 * @return array
	 */ 
	public function add_page_settings_tab__product( $tabs ) {
		if ( 'product' === get_current_screen()->post_type ) {
			$tabs['woocommerce-single'] = esc_html__( 'Product Layout', 'cakecious' );
		}

		return $tabs;
	}

	/**
	 * Render "Product Layout" options on Individual Page Settings meta box.
	 *
	 * @param WP_Post|WP_Term $obj
	 * @param string $tab
	 */
	public function render_page_settings_fields__product( $obj, $tab ) {
		if ( 'woocommerce-single' !== $tab ) {
			return;
		}

		if ( cakecious_show_pro_teaser() ) : ?>
			<div class="notice notice-info notice-alt inline cakecious-metabox-field-pro-teaser">
				<h3><?php echo esc_html_x( 'More Options Available', 'Cakecious Pro upsell', 'cakecious' ); ?></h3>
				<p>
					<?php echo esc_html_x( 'Enable / disable breadcrumb.', 'Cakecious Pro upsell', 'cakecious' ); ?><br>
					<?php echo esc_html_x( 'Enable / disable gallery on this product page.', 'Cakecious Pro upsell', 'cakecious' ); ?><br>
					<?php echo esc_html_x( 'Change gallery layout on this product page.', 'Cakecious Pro upsell', 'cakecious' ); ?><br>
					<?php echo esc_html_x( 'Enable / disable product info tabs.', 'Cakecious Pro upsell', 'cakecious' ); ?><br>
					<?php echo esc_html_x( 'Enable / disable up-sells.', 'Cakecious Pro upsell', 'cakecious' ); ?><br>
					<?php echo esc_html_x( 'Enable / disable related products.', 'Cakecious Pro upsell', 'cakecious' ); ?>
				</p>
				<p><a href="<?php echo esc_url( add_query_arg( array( 'utm_source' => 'cakecious-page-settings-metabox', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ); ?>" class="button button-secondary" target="_blank" rel="noopener"><?php echo esc_html_x( 'Learn More', 'Cakecious Pro upsell', 'cakecious' ); ?></a></p>
			</div>
		<?php endif;
	}

	/**
	 * Add fallback page settings value for "Product Layout" settings.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_page_settings_fallback_values__product( $settings ) {
		$add = array(
			'woocommerce_single_breadcrumb' => cakecious_get_theme_mod( 'woocommerce_single_breadcrumb' ),
			'woocommerce_single_gallery' => cakecious_get_theme_mod( 'woocommerce_single_gallery' ),
			'woocommerce_single_gallery_layout' => cakecious_get_theme_mod( 'woocommerce_single_gallery_layout' ),
			'woocommerce_single_tabs' => cakecious_get_theme_mod( 'woocommerce_single_tabs' ),
			'woocommerce_single_up_sells' => cakecious_get_theme_mod( 'woocommerce_single_up_sells' ),
			'woocommerce_single_related' => cakecious_get_theme_mod( 'woocommerce_single_related' ),
		);

		return array_merge( $settings, $add );
	}

	/**
	 * Set default values of Dynamic page layout settings for Cart, Checkout, and My Acount pages.
	 *
	 * @param integer $old_value
	 * @param integer $value
	 * @param string $option
	 */
	public function set_default_page_settings_on_woocommerce_pages( $old_value, $value, $option ) {
		// Abort if the changed option key is not WooCommerce's cart, checkout, and myaccount page ID.
		if ( ! in_array( $option, array( 'woocommerce_cart_page_id', 'woocommerce_checkout_page_id', 'woocommerce_myaccount_page_id' ) ) ) {
			return;
		}

		// Get the settings, if exists.
		$page_settings = get_post_meta( $value, '_cakecious_page_settings', true );
		if ( empty( $page_settings ) ) {
			$page_settings = array();
		}

		// If "Container Width" is not set yet, set it to the default value.
		if ( ! isset( $page_settings['content_container'] ) ) {
			$page_settings['content_container'] = 'default';
		}

		// If "Container Width" is not set yet, set it to the default value.
		if ( ! isset( $page_settings['content_layout'] ) ) {
			$page_settings['content_layout'] = 'wide';
		}

		// Update the post meta.
		update_post_meta( $value, '_cakecious_page_settings', $page_settings );
	}
	
	/**
	 * ====================================================
	 * Global Hook functions
	 * ====================================================
	 */

	/**
	 * Change "Products" in theme's breadcrumb trails to Shop page's title.
	 *
	 * @param array $array
	 * @return array
	 */
	public function modify_theme_breadcrumb_trails( $array ) {
		if ( is_shop() ) {
			$array['post_type_archive']['label'] = get_the_title( wc_get_page_id( 'shop' ) );
		}

		return $array;
	}

	/**
	 * Add items count to Cart menu item.
	 *
	 * @param string $title
	 * @param WP_Post $item
	 * @param array $args
	 * @param integer $depth
	 * @return string
	 */
	public function add_count_to_cart_menu_item( $title, $item, $args, $depth ) {
		// Add items count to "Cart" menu.
		if ( 'page' == $item->object && $item->object_id == get_option( 'woocommerce_cart_page_id' ) ) {
			if ( strpos( $title, '{{count}}' ) ) {
				$cart = WC()->cart;
				if ( ! empty( $cart ) ) {
					$count = $cart->cart_contents_count;
				} else {
					$count = 0;
				}
				$title = str_replace( '{{count}}', '(<span class="shopping-cart-count" data-count="' . $count . '">' . $count . '</span>)', $title );
			}
		}

		return $title;
	}

	/**
	 * Improve products loop wrapper HTML markup.
	 *
	 * @param string $html
	 * @return string
	 */
	public function change_loop_start_markup( $html ) {
		$html = preg_replace( '/(class=".*?)"/', '$1 ' . implode( ' ', apply_filters( 'cakecious/frontend/woocommerce/loop_classes', array() ) ) . '"', $html );

		return $html;
	}

	/**
	 * Mobile screen breakpoint.
	 * 
	 * @param string $px
	 * @return string
	 */
	public function set_smallscreen_breakpoint( $px ) {
		return '767px';
	}

	/**
	 * AJAX update items count on header cart menu & icon.
	 */
	public function update_header_cart( $fragments ) {
		$count = WC()->cart->get_cart_contents_count();
		$fragments['.shopping-cart-count'] = '<span class="shopping-cart-count" data-count="' . $count . '">' . $count . '</span>';
		
		return $fragments;
	}

	/**
	 * Add SVG icon to product search widget HTML.
	 *
	 * @param string $from
	 * @return string
	 */
	public function add_icon_to_product_search_widget( $form ) {
		$form = preg_replace( '/<\/form>/', cakecious_icon( 'search', array( 'class' => 'cakecious-search-icon' ), false ) . '</form>', $form );

		return $form;
	}

	/**
	 * Add text alignment class on loop start tag.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_loop_item_alignment_class( $classes ) {
		$classes['text_alignment'] = esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'woocommerce_products_grid_text_alignment' ) );

		return $classes;
	}

	/**
	 * Modify "added to cart" message.
	 *
	 * @param string $message
	 * @param array $products
	 * @param boolean $show_qty
	 * @return string
	 */
	public function change_add_to_cart_message_html( $message, $products, $show_qty ) {
		$message = preg_replace( '/(<a .*?>.*?<\/a>) (.*)/', '$2 $1', $message );

		return $message;
	}

	/**
	 * Modify flexslider settings on single product page.
	 *
	 * @param array $options
	 * @return array
	 */
	public function change_single_product_carousel_options( $options ) {
		$options['animation'] = 'fade';
		$options['animationSpeed'] = 250;

		return $options;
	}

	/**
	 * Add plus and minus buttons to the quantity input.
	 */
	public function add_quantity_plus_minus_buttons() {
		?>
		<span class="cakecious-qty-increment cakecious-qty-minus" role="button" tabindex="0">-</span>
		<span class="cakecious-qty-increment cakecious-qty-plus" role="button" tabindex="0">+</span>
		<?php
	}

	/**
	 * Add plus and minus buttons to the quantity input via JS.
	 */
	public function add_quantity_plus_minus_buttons_scripts() {
		// Add inline JS to initiate quantity plus minus UI.
		// This javascript uses jQuery to hook into WooCommerce event callback (WooCommerce uses jQuery).
		ob_start();
		?>
		(function() {
			'use strict';

			var handleWooCommerceQuantityIncrementButtons = function( e ) {
				// Only handle "cakecious-qty-increment" button.
				if ( e.target.classList.contains( 'cakecious-qty-increment' ) ) {
					// Prevent default handlers on click and touch event.
					if ( 'click' === e.type || 'touchend' === e.type ) {
						e.preventDefault();
					}

					// Abort if keydown is not enter or space key.
					else if ( 'keydown' === e.type && 13 !== e.which && 32 !== e.which ) {
						return;
					}

					var $button = e.target,
					    $input = $button.parentElement.querySelector( '.qty' ),
					    step = parseInt( $input.getAttribute( 'step' ) ),
					    min = parseInt( $input.getAttribute( 'min' ) ),
					    max = parseInt( $input.getAttribute( 'max' ) ),
					    sign = $button.classList.contains( 'cakecious-qty-minus' ) ? '-' : '+';

					// Adjust the input value according to the clicked button.
					if ( '-' === sign ) {
						var newValue = parseInt( $input.value ) - step;

						if ( min && min > newValue ) {
							$input.value = parseInt( min );
						} else {
							$input.value = parseInt( newValue );
						}
					} else {
						var newValue = parseInt( $input.value ) + step;

						if ( max && max < newValue ) {
							$input.value = parseInt( max );
						} else {
							$input.value = parseInt( newValue );
						}
					}

					// Trigger "change" event on the input field (use old fashioned way for IE compatibility).
					var event = document.createEvent( 'HTMLEvents' );
					event.initEvent( 'change', true, false);
					$input.dispatchEvent( event );
				}
			};

			document.body.addEventListener( 'click', handleWooCommerceQuantityIncrementButtons );
			document.body.addEventListener( 'touchend', handleWooCommerceQuantityIncrementButtons );
			document.body.addEventListener( 'keydown', handleWooCommerceQuantityIncrementButtons );
		})();
		<?php
		$js = ob_get_clean();

		// Add right after WooCommerce main js.
		wp_add_inline_script( 'woocommerce', $js );
	}
	
	/**
	 * ====================================================
	 * Shop Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening products filters wrapper tag.
	 */
	public function render_loop_filters_wrapper() {
		?><div class="cakecious-products-filters"><?php
	}

	/**
	 * Add closing products filters wrapper tag.
	 */
	public function render_loop_filters_wrapper_end() {
		?></div><?php
	}

	/**
	 * Add opening product wrapper tag to products loop item.
	 */
	public function render_loop_item_wrapper() {
		?><div class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/woocommerce/loop_item_classes', array( 'cakecious-product-wrapper' ) ) ) ); ?>"><?php
	}

	/**
	 * Add closing product wrapper tag to products loop item.
	 */
	public function render_loop_item_wrapper_end() {
		?></div><?php
	}

	/**
	 * Add opening product image wrapper tag.
	 */
	public function render_loop_product_thumbnail_wrapper() {
		?><div class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/woocommerce/loop_item_thumbnail_classes', array( 'cakecious-product-thumbnail' ) ) ) ); ?>"><?php
	}

	/**
	 * Add closing product image wrapper tag.
	 */
	public function render_loop_product_thumbnail_wrapper_end() {
		?></div><?php
	}

	/**
	 * Set products loop posts per page.
	 * 
	 * @param integer $posts_per_page
	 * @return integer
	 */
	public function set_loop_posts_per_page( $posts_per_page ) {
		return intval( cakecious_get_theme_mod( 'woocommerce_index_posts_per_page' ) );
	}

	/**
	 * Set products loop columns.
	 * 
	 * @param integer $cols
	 * @return integer
	 */
	public function set_loop_columns( $cols ) {
		return intval( cakecious_get_theme_mod( 'woocommerce_index_grid_columns' ) );
	}

	/**
	 * ====================================================
	 * Product Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add some classes on single product wrapper on single product template.
	 *
	 * @param array $classes
	 * @param array $class
	 * @param integer $post_id
	 * @return array
	 */
	public function add_single_product_class() {
		add_filter( 'post_class', array( $this, 'add_single_product_class_filter' ), 10, 3 );
	}

	/**
	 * Add some classes on single product wrapper via filter.
	 *
	 * @param array $classes
	 * @param array $class
	 * @param integer $post_id
	 * @return array
	 */
	public function add_single_product_class_filter( $classes, $class, $post_id ) {
		$classes = apply_filters( 'cakecious/frontend/woocommerce/single_product_classes', $classes );
		
		return $classes;
	}

	/**
	 * Add class on single product gallery whether it contains single image or multiple images.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_single_product_gallery_class( $classes ) {
		global $product;

		$gallery_ids = $product->get_gallery_image_ids();

		if ( 0 < count( $gallery_ids ) ) {
			$classes['gallery_multiple_images'] = esc_attr( 'cakecious-woocommerce-single-gallery-multiple-images' );
		}
		
		return $classes;
	}

	/**
	 * Set Product thumbnails columns in single product page.
	 * 
	 * @param integer $columns
	 * @return integer
	 */
	public function set_product_thumbnails_columns( $columns ) {
		return 8;
	}

	/**
	 * Add opening add to cart form's wrapper tag.
	 */
	public function render_add_to_cart_form_wrapper() {
		?><div class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/woocommerce/add_to_cart_form_classes', array( 'cakecious-product-add-to-cart' ) ) ) ); ?>"><?php
	}

	/**
	 * Add closing add to cart form's wrapper tag.
	 */
	public function render_add_to_cart_form_wrapper_end() {
		?></div><?php
	}

	/**
	 * Keep / remove related products.
	 * 
	 * @param array $args Array of arguments
	 * @return array
	 */
	public function set_related_products_args( $args ) {
		if ( 0 == intval( cakecious_get_theme_mod( 'woocommerce_single_related_posts_per_page' ) ) ) {
			return array();
		}

		return $args;
	}
	
	/**
	 * Set related products columns.
	 * 
	 * @param integer $columns Number of columns
	 * @return integer
	 */
	public function set_related_products_columns( $columns ) {
		return intval( cakecious_get_theme_mod( 'woocommerce_single_related_grid_columns' ) );
	}

	/**
	 * Set related products arguments.
	 * 
	 * @param array $args Array of arguments
	 * @return array
	 */
	public function set_related_products_display_args( $args ) {
		$args['posts_per_page'] = intval( cakecious_get_theme_mod( 'woocommerce_single_related_posts_per_page' ) );
		$args['columns'] = intval( cakecious_get_theme_mod( 'woocommerce_single_related_grid_columns' ) );

		return $args;
	}

	/**
	 * Set up-sells columns.
	 * 
	 * @param integer $columns Number of columns
	 * @return integer
	 */
	public function set_up_sells_columns( $columns ) {
		return intval( cakecious_get_theme_mod( 'woocommerce_single_up_sells_grid_columns' ) );
	}
	
	/**
	 * Set up-sells products arguments.
	 * 
	 * @param array $args Array of arguments
	 * @return array
	 */
	public function set_up_sells_display_args( $args ) {
		$args['columns'] = intval( cakecious_get_theme_mod( 'woocommerce_single_up_sells_grid_columns' ) );

		return $args;
	}

	/**
	 * ====================================================
	 * Cart Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add two columns layout class for cart page.
	 */
	public function add_cart_two_columns_class( $classes ) {
		$classes[] = 'cakecious-woocommerce-cart-2-columns';

		return $classes;
	}

	/**
	 * Add opening 2 columns cart left columns wrapper tag.
	 */
	public function render_cart_2_columns_left_wrapper() {
		?><div class="cakecious-woocommerce-cart-2-columns--left"><?php
	}

	/**
	 * Add closing 2 columns cart left columns wrapper tag.
	 */
	public function render_cart_2_columns_left_wrapper_end() {
		?></div><?php
	}

	/**
	 * Add opening 2 columns cart right columns wrapper tag.
	 */
	public function render_cart_2_columns_right_wrapper() {
		?><div class="cakecious-woocommerce-cart-2-columns--right"><?php
	}

	/**
	 * Add opening 2 columns cart right columns wrapper tag.
	 */
	public function render_cart_2_columns_right_wrapper_end() {
		?></div><?php
	}

	/**
	 * Set cross-sells columns.
	 * 
	 * @param integer $columns Number of columns
	 * @return integer
	 */
	public function set_cart_page_cross_sells_columns( $columns ) {
		return intval( cakecious_get_theme_mod( 'woocommerce_cart_cross_sells_grid_columns' ) );
	}

	/**
	 * ====================================================
	 * Checkout Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add two columns layout class for checkout page.
	 */
	public function add_checkout_two_columns_class( $classes ) {
		$classes[] = 'cakecious-woocommerce-checkout-2-columns';

		return $classes;
	}

	/**
	 * Add opening 2 columns checkout left columns wrapper tag.
	 */
	public function render_checkout_2_columns_left_wrapper() {
		?><div class="cakecious-woocommerce-checkout-2-columns--left"><?php
	}

	/**
	 * Add closing 2 columns checkout left columns wrapper tag.
	 */
	public function render_checkout_2_columns_left_wrapper_end() {
		?></div><?php
	}

	/**
	 * Add opening 2 columns checkout right columns wrapper tag.
	 */
	public function render_checkout_2_columns_right_wrapper() {
		?><div class="cakecious-woocommerce-checkout-2-columns--right"><?php
	}

	/**
	 * Add opening 2 columns checkout right columns wrapper tag.
	 */
	public function render_checkout_2_columns_right_wrapper_end() {
		?></div><?php
	}

	/**
	 * ====================================================
	 * My Account Page Hook functions
	 * ====================================================
	 */

	/**
	 * Add opening wrapper tag to wrap account sidebar.
	 */
	public function render_account_sidebar_wrapper() {
		$user = wp_get_current_user();
		?>
		<div class="cakecious-woocommerce-MyAccount-sidebar">
			<div class="cakecious-woocommerce-MyAccount-user">
				<?php echo get_avatar( $user->user_ID, 60 ); ?>
				<strong class="name"><?php echo esc_html( $user->display_name ); ?></strong>
			</div>
		<?php
	}

	/**
	 * Add closing wrapper tag to wrap account sidebar.
	 */
	public function render_account_sidebar_wrapper_end() {
		?>
		</div>
		<?php
	}
}

Cakecious_Compatibility_WooCommerce::instance();