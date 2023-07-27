<?php
/**
 * Main class of Cakecious Pro plugin.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro
	 */
	private static $instance;

	/**
	 * Theme info
	 *
	 * @var array
	 */
	private $_info;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**a
	 * Get singleton instance.
	 *
	 * @return Cakecious_Pro
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
		add_action( 'after_setup_theme', array( $this, 'init' ), 20 );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */
	
	/**
	 * Load plugin textdomain.
	 */
	public function init() {
		// Check if PHP version is less than 5.4.0, don't load the plugin, show error notice.
		if ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'render_fail_php_version_notice' ) );
		}

		// Check if Cakecious theme version is less than the required version, don't load the plugin, show error notice.
		elseif ( version_compare( preg_replace( '/\-.*/', '', CAKECIOUS_VERSION ), CAKECIOUS_VERSION_REQUIRED, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'render_fail_theme_version_notice' ) );
		}

		// All requirements are met, load the plugin.
		else {
			// Setup plugin info.
			// Priority has to be set to 0 because "widgets_init" action is actually an "init" action with priority set to 1.
			add_action( 'init', array( $this, 'setup_plugin_info' ), 0 );

			// Check migration.
			// Priority is set to 2 because theme migration is at priority 1.
			add_action( 'init', array( $this, 'check_plugin_version' ), 2 );
			
			// Add global cakecious pro class on frontend's <body> tag.
			add_filter( 'body_class', array( $this, 'add_body_classes' ), -1 );

			// Add additional directory path for partial template files.
			add_filter( 'cakecious/frontend/template_dirs', array( $this, 'add_template_dirs' ) );
			
			// Register all CSS and JS vendor files for future conditional uses.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_vendor_scripts' ), 0 );

			// Include other files.
			$this->_includes();
		}
	}

	/**
	 * Set plugin info based on header data in cakecious-pro.php file.
	 */
	public function setup_plugin_info() {
		// Extract plugin data.
		$info = get_file_data( CAKECIOUS_PRO_DIR . '/cakecious-pro.php', array(
			'name'        => 'Plugin Name',
			'url'         => 'Plugin URI',
			'description' => 'Description',
			'author'      => 'Author',
			'author_url'  => 'Author URI',
			'version'     => 'Version',
			'text_domain' => 'Text Domain',
		), 'plugin' );

		// Assign to class $_info property.
		$this->_info = apply_filters( 'cakecious/pro/plugin_info', $info );
	}

	/**
	 * Check plugin version and add hook to do some actions when version changed.
	 */
	public function check_plugin_version() {
		// Get plugin version info from DB
		$db_version = get_option( 'cakecious_pro_version', false );
		$files_version = $this->get_info( 'version' );

		// If no version info found in DB, then create the info.
		if ( ! $db_version ) {
			add_option( 'cakecious_pro_version', $files_version );

			// Skip migration and version update, because this is new installation.
			return;
		}

		// If current version is larger than DB version, update DB version and run migration (if any).
		if ( version_compare( $db_version, $files_version, '<' ) ) {
			// Run through each "to-do" migration list step by step.
			foreach ( $this->get_migration_checkpoints() as $migration_version ) {
				// Skip migration checkpoints that are less than DB version.
				// OR greater than current plugin files version (to make sure the migration doesn't run while on development phase).
				if ( version_compare( $migration_version, $db_version, '<' ) || version_compare( $migration_version, preg_replace( '/\-.*/', '', $files_version ), '>' ) ) {
					continue;
				}

				// Include migration functions.
				$file = CAKECIOUS_PRO_DIR . '/inc/migrations/class-cakecious-pro-migrate-' . $migration_version . '.php';

				if ( file_exists( $file ) ) {
					include( $file );
				}

				// Update DB version to migrated version.
				update_option( 'cakecious_pro_version', $migration_version );
			}

			// Update DB version to latest version.
			update_option( 'cakecious_pro_version', $files_version );
		}
	}

	/**
	 * Add custom classes to the array of body classes.
	 *
	 * @param array $classes.
	 * @return array
	 */
	public function add_body_classes( $classes ) {
		// Add Cakecious Pro version.
		$classes['cakecious_pro_version'] = esc_attr( 'cakecious-pro-ver-' . str_replace( '.', '-', CAKECIOUS_PRO_VERSION ) );

		return $classes;
	}

	/**
	 * Add custom directory paths for frontend template files.
	 *
	 * @param array $paths.
	 * @return array
	 */
	public function add_template_dirs( $paths ) {
		// Add Cakecious Pro template paths.
		// Add into prioriry "10" to allow other plugins to override the template using lower number (higher priority).
		$paths[10] = trailingslashit( CAKECIOUS_PRO_DIR ) . 'template-parts';

		return $paths;
	}

	/**
	 * Register all scripts (CSS and JS files).
	 */
	public function register_vendor_scripts() {
		// Fetched version from package.json
		$ver = array();
		$ver['tiny-slider'] = '2.9.2';

		// tiny-slider
		wp_register_script( 'tiny-slider', CAKECIOUS_PRO_URI . 'assets/js/vendors/tiny-slider' . CAKECIOUS_ASSETS_SUFFIX . '.js', array(), $ver['tiny-slider'], true );
		wp_register_style( 'tiny-slider', CAKECIOUS_PRO_URI . 'assets/css/vendors/tiny-slider' . CAKECIOUS_ASSETS_SUFFIX . '.css', array(), $ver['tiny-slider'] );
	}

	/**
	 * Include active modules files.
	 */
	private function _includes() {
		/**
		 * Helper classes.
		 */

		require_once( CAKECIOUS_PRO_DIR . 'inc/class-cakecious-helper-css-spinner.php' );
		
		
		/**
		 * Include admin functions.
		 */

		if ( is_admin() ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/class-cakecious-pro-admin.php' );
		}

		/**
		 * Include mandatory classes.
		 */

		// Base module class
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/class-cakecious-pro-module.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/class-cakecious-pro-module-blog.php' );

		// Base WooCommerce module class
		if ( class_exists( 'WooCommerce' ) ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/modules/class-cakecious-pro-module-woocommerce.php' );
		}

		/**
		 * Include modules.
		 */

		// Get list of pro modules that are supported in current installed theme version.
		$available_modules = cakecious_get_pro_modules();

		// Get list of active modules as saved on DB.
		$active_modules = get_option( 'cakecious_pro_active_modules', array() );
		$active_modules = array(
			'header-elements-plus',
			'header-vertical',
			'header-transparent',
			'header-sticky',
			'header-alt-colors',
			'header-mega-menu',
			'footer-widgets-columns-width',
			'preloader-screen',
			'custom-blocks',
			'custom-fonts',
			'custom-icons',
			'woocommerce-advanced',
			'woocommerce-layout-plus',
			'woocommerce-ajax-add-to-cart',
			'woocommerce-quick-view',
			'woocommerce-off-canvas-filters',
			'woocommerce-checkout-optimization',
			'blog-layout-plus',
			'blog-featured-posts',
			'blog-related-posts',
		);

		// Iterate through all available modules to check its status.
		foreach ( $available_modules as $module_slug => $module_data ) {
			// Skip Advanced WooCommerce module if it's activated but no WooCommerce class is found.
			if ( 'woocommerce' === $module_data['category'] && ! class_exists( 'WooCommerce' ) ) {
				continue;
			}

			$module_file = CAKECIOUS_PRO_DIR . 'inc/modules/' . $module_slug . '/class-cakecious-pro-module-' . $module_slug . '.php';

			// If a module is active, include the module file.
			if ( in_array( $module_slug, $active_modules ) && file_exists( $module_file ) ) {
				require_once( $module_file );
			}
		}
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render notice in admin page if PHP version is less than 5.4.0.
	 */
	public function render_fail_php_version_notice() {
		?>
		<div class="notice notice-error is-dismissible">
			<p>
				<?php esc_html_e( 'Cakecious Pro plugin requires at least PHP 5.4.0. The plugin is currently NOT RUNNING.', 'cakecious-features' ); ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Render notice in admin page if Cakecious theme version is less than the required version.
	 */
	public function render_fail_theme_version_notice() {
		?>
		<div class="notice notice-error is-dismissible">
			<p>
				<?php printf(
					/* translators: %1$s: current Cakecious Pro version, %2$s: required Cakecious theme version. */
					esc_html__( 'The installed Cakecious Pro %1$s requires at least Cakecious (theme) %2$s, please update your theme first. The plugin is currently NOT RUNNING.', 'cakecious-features' ),
					CAKECIOUS_PRO_VERSION,
					CAKECIOUS_VERSION_REQUIRED
				); ?>
			</p>
		</div>
		<?php
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return plugin info.
	 *
	 * @param string $key
	 * @return string
	 */
	public function get_info( $key ) {
		if ( isset( $this->_info[ $key ] ) ) {
			return $this->_info[ $key ];
		}

		return false;
	}

	/**
	 * Return array of migration checkpoints start from specified version.
	 *
	 * @return array
	 */
	public function get_migration_checkpoints() {
		return array(
			'1.1.0',
		);
	}
}

// Initialize plugin.
Cakecious_Pro::instance();