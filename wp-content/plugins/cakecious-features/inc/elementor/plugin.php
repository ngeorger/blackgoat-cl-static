<?php
namespace CAKECIOUSElementor;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		//wp_register_script( 'cakeciousfm-features', plugins_url( '/assets/js/hello-world.js', __FILE__ ), [ 'jquery' ], false, true );
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/add-content.php' );
		if( defined('WC_PLUGIN_FILE')) {
			require_once( __DIR__ . '/widgets/display-products.php' );
		}
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cakecious_Add_Content() );
		if( defined('WC_PLUGIN_FILE')) {
		    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cakecious_Display_Products() );
		}
	}

	/**
	 * Custom css for Elementor panel
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function elementor_panel_css() {
		wp_add_inline_style( 'elementor-editor', '#elementor-panel-category-pro-elements, #elementor-panel-category-theme-elements, #elementor-panel-category-woocommerce-elements, .elementor-control-dynamic-switcher, #elementor-notice-bar, #elementor-panel-get-pro-elements, .elementor-component-tab[data-tab="global"] {display:none !important;}' );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		// Add styles on Elementor to remove nag, only if Pro is not installed.
		if( ! defined('ELEMENTOR_PRO_VERSION')) {
			add_action('elementor/editor/after_enqueue_styles', [ $this, 'elementor_panel_css' ] );
		}
	}
}

// Instantiate Plugin Class
Plugin::instance();
