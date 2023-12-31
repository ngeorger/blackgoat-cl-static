<?php
/**
 * Cakecious theme class.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious
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

	/**
	 * Get singleton instance.
	 *
	 * @return Cakecious
	 */
	public final static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class cloning (disabled)
	 */
	private final function __clone() {}

	/**
	 * Class unserializing (disabled)
	 */
	private final function __wakeup() {}

	/**
	 * Class constructor
	 */
	private function __construct() {
		// Load translations.
		add_action( 'after_setup_theme', array( $this, 'load_translations' ) );

		// Set global content width.
		add_action( 'after_setup_theme', array( $this, 'setup_content_width' ) );

		// Define theme supported features.
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

		// Setup theme info.
		// Priority has to be set to 0 because "widgets_init" action is actually an "init" action with priority set to 1.
		add_action( 'init', array( $this, 'setup_theme_info' ), 0 );

		// Check blv migration.
		add_action( 'init', array( $this, 'check_blv_framework_version' ), 1 );

		// Check migration.
		add_action( 'init', array( $this, 'check_theme_version' ), 1 );

		// Register sidebars and widgets.
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Declare 'wp_enqueue_scripts' action on 'init' hook to make sure all plugins' scripts has been enqueued before theme scripts.
		// For example, Elementor declares their 'wp_enqueue_scripts' actions late, on 'init' hook.
		add_action( 'init', array( $this, 'handle_frontend_scripts' ) );

		// If enabled from Child Theme, this will make Child Theme inherit Parent Theme configuration.
		if ( get_stylesheet() !== get_template() && defined( 'CAKECIOUS_CHILD_USE_PARENT_MODS' ) && CAKECIOUS_CHILD_USE_PARENT_MODS ) {
			add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), array( $this, 'child_use_parent_mods__set' ), 10, 2 );
			add_filter( 'pre_option_theme_mods_' . get_stylesheet(), array( $this, 'child_use_parent_mods__get' ) );
		}

		// Include other files.
		$this->_includes();
	}

	/**
	 * Include additional files.
	 */
	private function _includes() {
		// Helper functions
		require_once( CAKECIOUS_INCLUDES_DIR . '/helpers.php' );

		// Customizer functions
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/class-cakecious-customizer.php' );

		// Template functions & hooks
		require_once( CAKECIOUS_INCLUDES_DIR . '/template-tags.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/template-functions.php' );

		// Plugins compatibility functions
		foreach ( $this->get_compatible_plugins() as $plugin_slug => $plugin_class ) {
			// Only include plugin's compatibility class if the plugin is active.
			if ( class_exists( $plugin_class ) ) {
				$compatibility_file = CAKECIOUS_INCLUDES_DIR . '/compatibilities/' . $plugin_slug . '/class-cakecious-compatibility-' . $plugin_slug . '.php';

				if ( file_exists( $compatibility_file ) ) {
					require_once( $compatibility_file );
				}
			}
		}

		// Cakecious essentials
		require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/init.php' );

		// Admin page functions
		if ( is_admin() ) {
			require_once( CAKECIOUS_INCLUDES_DIR . '/admin/class-cakecious-admin.php' );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Set theme info based on header data in style.css file.
	 */
	public function setup_theme_info() {

		define( 'CAKECIOUS_FRAMEWORK_VERSION', '1.3.0' );

		// Extract theme data from style.css
		$info = get_file_data( get_template_directory() . '/style.css', array(
			'name'        => 'Theme Name',
			'url'         => 'Theme URI',
			'description' => 'Description',
			'author'      => 'Author',
			'author_url'  => 'Author URI',
			'version'     => 'Version',
			'template'    => 'Template',
			'status'      => 'Status',
			'tags'        => 'Tags',
			'text_domain' => 'Text Domain',
			'domain_path' => 'Domain Path',
		) );

		// Add screenshot to theme data.
		$info['screenshot'] = esc_url( get_template_directory_uri() . '/screenshot.png' );

		// Assign to class $_info property.
		$this->_info = apply_filters( 'cakecious/theme_info', $info );
	}

	/**
	 * Check theme version and add hook to do some actions when version changed.
	 */
	public function check_blv_framework_version() {

		// framework migration, if needed.
		$frm_db_version = get_option( 'cakecious_framework_version', false );
		$frm_files_version =  ( defined('CAKECIOUS_FRAMEWORK_VERSION') ) ? CAKECIOUS_FRAMEWORK_VERSION : $this->get_info( 'version' ) ;

		// If no version info found in DB, then create the info.
		if ( ! $frm_db_version ) {
			add_option( 'cakecious_framework_version', $frm_files_version );

			// Skip migration and version update, because this is new installation.
			return;
		}

		// If current version is larger than DB version, update DB version and run migration (if any).
		if ( version_compare( $frm_db_version, $frm_files_version, '<' ) ) {
			// Run through each "to-do" migration list step by step.
			foreach ( $this->get_migration_checkpoints() as $migration_version ) {
				// Skip migration checkpoints that are less than DB version.
				// OR greater than current theme files version (to make sure the migration doesn't run while on development phase).
				if ( version_compare( $migration_version, $frm_db_version, '<' ) || version_compare( $migration_version, preg_replace( '/\-.*/', '', $frm_db_version ), '>' ) ) {
					continue;
				}

				// Include migration functions.
				$file = CAKECIOUS_INCLUDES_DIR . '/migrations/class-cakecious-migrate-' . $migration_version . '.php';

				if ( file_exists( $file ) ) {
					include( $file );
				}

				// Update DB version to migrated version.
				update_option( 'cakecious_framework_version', $migration_version );
			}

			// Update DB version to latest version.
			update_option( 'cakecious_framework_version', $frm_files_version );
		}
	}

	/**
	 * Check theme version and add hook to do some actions when version changed.
	 */
	public function check_theme_version() {
		// Get theme version info from DB
		$db_version = get_option( 'cakecious_theme_version', false );
		$files_version = $this->get_info( 'version' );

		// If no version info found in DB, then create the info.
		if ( ! $db_version ) {
			add_option( 'cakecious_theme_version', $files_version );

			// Skip migration and version update, because this is new installation.
			return;
		}

		// If current version is larger than DB version, update DB version and run migration (if any).
		if ( version_compare( $db_version, $files_version, '<' ) ) {
			// Run through each "to-do" migration list step by step.
			foreach ( $this->get_migration_checkpoints() as $migration_version ) {
				// Skip migration checkpoints that are less than DB version.
				// OR greater than current theme files version (to make sure the migration doesn't run while on development phase).
				if ( version_compare( $migration_version, $db_version, '<' ) || version_compare( $migration_version, preg_replace( '/\-.*/', '', $files_version ), '>' ) ) {
					continue;
				}

				// Include migration functions.
				$file = CAKECIOUS_INCLUDES_DIR . '/migrations/class-cakecious-migrate-' . $migration_version . '.php';

				if ( file_exists( $file ) ) {
					include( $file );
				}

				// Update DB version to migrated version.
				update_option( 'cakecious_theme_version', $migration_version );
			}

			// Update DB version to latest version.
			update_option( 'cakecious_theme_version', $files_version );
		}
	}

	/**
	 * Load translations for theme's text domain.
	 */
	public function load_translations() {
		load_theme_textdomain( 'cakecious', get_template_directory() . '/languages' );
	}

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global integer $content_width
	 */
	public function setup_content_width() {
		global $content_width;

		$content_width = intval( cakecious_get_theme_mod( 'container_width' ) );
	}

	/**
	 * Registers support for various WordPress features.
	 */
	public function add_theme_supports() {
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for document <title> tag generated by WordPress itself
		add_theme_support( 'title-tag' );

		// Enable support for Post thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		// Register menus
		register_nav_menus( array(
			/* translators: %s: number of Header Menu. */
			'header-menu-1' => sprintf( esc_html__( 'Header Menu %s', 'cakecious' ), 1 ),
			'header-mobile-menu' => esc_html__( 'Mobile Header Menu', 'cakecious' ),
			'footer-menu-1' => esc_html__( 'Footer Bottom Menu', 'cakecious' ),
		) );

		// Enable HTML5 tags for search form, comment form, and comments
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Enable custom logo
		add_theme_support( 'custom-logo', array(
			'flex-height' => true,
			'flex-width'  => true,
		) );

		// Add theme support for selective refresh for widgets
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Add excerpt to pages.
		add_post_type_support( 'page', 'excerpt' );

		// Breadcrumb trail compatibility
		add_theme_support( 'breadcrumb-trail' );

		// Gutenberg: Block styles
		// add_theme_support( 'wp-block-styles' );

		// Gutenberg: Wide alignment
		add_theme_support( 'align-wide' );

		// Gutenberg: Editor color palette
		if ( intval( cakecious_get_theme_mod( 'color_palette_in_gutenberg' ) ) ) {
			$array = array();

			for ( $i = 1; $i <= 8; $i++ ) {
				$color = cakecious_get_theme_mod( 'color_palette_' . $i );

				if ( empty( $color ) ) {
					continue;
				}

				$array[] = array(
					/* translators: %s: color index. */
					'name'  => sprintf( esc_html__( 'Color %s', 'cakecious' ), $i ),
					'slug'  => 'cakecious-color-' . $i,
					'color' => $color,
				);
			}

			add_theme_support( 'editor-color-palette', $array );
		}

		// Gutenberg: Font sizes
		$base_font_size = floatval( cakecious_get_theme_mod( 'body_font_size' ) );
		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' => esc_html__( 'Small', 'cakecious' ),
				'size' => 0.85 * $base_font_size,
				'slug' => 'small',
			),
			array(
				'name' => esc_html__( 'Normal', 'cakecious' ),
				'size' => $base_font_size,
				'slug' => 'regular',
			),
			array(
				'name' => esc_html__( 'Medium', 'cakecious' ),
				'size' => 1.2 * $base_font_size,
				'slug' => 'medium',
			),
			array(
				'name' => esc_html__( 'Large', 'cakecious' ),
				'size' => 1.5 * $base_font_size,
				'slug' => 'large',
			),
			array(
				'name' => esc_html__( 'Huge', 'cakecious' ),
				'size' => 2 * $base_font_size,
				'slug' => 'huge',
			),
		) );

		// Gutenberg: Editor styles
		add_theme_support( 'editor-styles' );

		// Gutenberg: Custom line height
		add_theme_support( 'custom-line-height' );

		// Gutenberg: Custom units
		add_theme_support( 'custom-units' );

		// Gutenberg: Responsive embeds
		add_theme_support( 'responsive-embeds' );
	}

	/**
	 * Register custom widgets.
	 */
	public function register_widgets() {
		// Include custom widgets.
		require_once( CAKECIOUS_INCLUDES_DIR . '/widgets/class-cakecious-widget-posts.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/widgets/class-cakecious-widget-social.php' );
	}
	
	/**
	 * Register theme sidebars (widget area).
	 */
	public function register_sidebars() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'cakecious' ),
			'id'            => 'sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<' . cakecious_get_theme_mod( 'sidebar_widget_title_tag', 'h2' ) . ' class="widget-title">',
			'after_title'   => '</' . cakecious_get_theme_mod( 'sidebar_widget_title_tag', 'h2' ) . '>',
		) );

		for ( $i = 1; $i <= 6; $i++ ) {
			register_sidebar( array(
				/* translators: %s: footer widgets column number. */
				'name'          => sprintf( esc_html__( 'Footer Widgets Column %s', 'cakecious' ), $i ),
				'id'            => 'footer-widgets-' . $i,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . cakecious_get_theme_mod( 'footer_widgets_bar_widget_title_tag', 'h2' ) . ' class="widget-title">',
				'after_title'   => '</' . cakecious_get_theme_mod( 'footer_widgets_bar_widget_title_tag', 'h2' ) . '>',
			) );
		}
	}

	/**
	 * Enqueue frontend scripts.
	 *
	 * @param string $hook
	 */
	public function handle_frontend_scripts( $hook ) {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_javascripts' ) );

		add_filter( 'cakecious/frontend/dynamic_css', array( $this, 'add_dynamic_css' ) );
		add_filter( 'cakecious/frontend/dynamic_css', array( $this, 'add_page_settings_css' ), 25 );

		// DEPRECATED: Shouldn't be used for printing dynamic CSS.
		add_action( 'wp_head', array( $this, 'print_custom_css' ) );
	}

	/**
	 * Enqueue frontend styles.
	 *
	 * @param string $hook
	 */
	public function enqueue_frontend_styles( $hook ) {
		/**
		 * Hook: Enqueue others before main CSS
		 */
		do_action( 'cakecious/frontend/before_enqueue_main_css', $hook );

		// Main CSS
		wp_enqueue_style( 'cakecious', CAKECIOUS_CSS_URL . '/main' . CAKECIOUS_ASSETS_SUFFIX . '.css', array(), CAKECIOUS_VERSION );
		wp_style_add_data( 'cakecious', 'rtl', 'replace' );

		// Inline CSS
		wp_add_inline_style( 'cakecious', trim( apply_filters( 'cakecious/frontend/dynamic_css', '' ) ) );

		/**
		 * Hook: Enqueue others after main CSS
		 */
		do_action( 'cakecious/frontend/after_enqueue_main_css', $hook );
	}

	/**
	 * Enqueue frontend javascripts.
	 *
	 * @param string $hook
	 */
	public function enqueue_frontend_javascripts( $hook ) {
		// Fetched version from package.json
		$ver = array();

		// Comment reply (WordPress)
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		/**
		 * Hook: Scripts to be included before main JS
		 */
		do_action( 'cakecious/frontend/before_enqueue_main_js', $hook );

		// Main JS
		wp_enqueue_script( 'cakecious', CAKECIOUS_JS_URL . '/main' . CAKECIOUS_ASSETS_SUFFIX . '.js', array(), CAKECIOUS_VERSION, true );

		// Localize script
		wp_localize_script( 'cakecious', 'cakeciousConfig', apply_filters( 'cakecious/frontend/localize_script', array(
			'breakpoints' => array(
				'mobile'  => 500,
				'tablet'  => 768,
				'desktop' => 1024,
			),
		) ) );

		/**
		 * Hook: Scripts to be included after main JS
		 */
		do_action( 'cakecious/frontend/after_enqueue_main_js', $hook );
	}

	/**
	 * Print inline custom CSS.
	 * DEPRECATED: Shouldn't be used for printing dynamic CSS.
	 */
	public function print_custom_css() {
		echo '<style type="text/css" id="cakecious-custom-css">' . "\n" . wp_strip_all_tags( apply_filters( 'cakecious/frontend/inline_css', '' ) ) . "\n" . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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

		$postmessages = include( CAKECIOUS_INCLUDES_DIR . '/customizer/postmessages.php' );
		$defaults = include( CAKECIOUS_INCLUDES_DIR . '/customizer/defaults.php' );

		$generated_css = Cakecious_Customizer::instance()->convert_postmessages_to_css_string( $postmessages, $defaults );

		if ( ! empty( $generated_css ) ) {
			$css .= "\n/* Cakecious Dynamic CSS */\n" . $generated_css;
		}

		return $css;
	}

	/**
	 * Add current page settings CSS into the inline CSS.
	 *
	 * @param string $css
	 * @return string
	 */ 
	public function add_page_settings_css( $css ) {
		$css_array = array();

		/**
		 * Hero background image
		 */

		$hero_bg_image = '';

		$hero_bg = cakecious_get_current_page_setting( 'hero_bg' );

		switch ( $hero_bg ) {
			case 'thumbnail':
				if ( has_post_thumbnail() ) {
					$hero_bg_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				} else {
					$hero_bg_image = cakecious_get_theme_mod( 'hero_bg_image' );
				}
				break;
			
			case 'custom':
				$hero_bg_image = cakecious_get_current_page_setting( 'hero_bg_image' );
				break;

			default:
				$hero_bg_image = cakecious_get_theme_mod( 'hero_bg_image' );
				break;
		}

		if ( '' !== $hero_bg_image ) {
			$css_array['global']['.cakecious-hero-inner']['background-image'] = 'url(' . $hero_bg_image . ')';
		}

		/**
		 * Build the final CSS.
		 */

		$page_settings_css = cakecious_convert_css_array_to_string( $css_array );

		if ( '' !== trim( $page_settings_css ) ) {
			$css .= "\n/* Current Page Layout CSS */\n" . $page_settings_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		return $css;
	}

	/**
	 * Intercept saving mods on Child Theme and save it to Parent Theme instead.
	 *
	 * @param array $value
	 * @param array $old_value
	 * @return array
	 */
	function child_use_parent_mods__set( $value, $old_value ) {
		// Update parent theme mods.
		update_option( 'theme_mods_' . get_template(), $value );

		// Prevent update to child theme mods.
		return $old_value;
	}

	/**
	 * Intercept retrieving mods on Child Theme and return Parent Theme's mods instead.
	 *
	 * @param array $default
	 * @return array
	 */
	function child_use_parent_mods__get( $default ) {
		// Return parent theme mods.
		return get_option( 'theme_mods_' . get_template(), $default );
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Return theme info from style.css file header.
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
	 * Return array of compatible plugins.
	 *
	 * @return array
	 */
	public function get_compatible_plugins() {
		return array(
			'cakecious-features' => 'Cakecious_Pro',
			'contact-form-7' => 'WPCF7',
			'elementor' => '\Elementor\Plugin',
			'elementor-pro' => '\ElementorPro\Plugin',
			'brizy' => 'Brizy_Editor',
			'jetpack' => 'Jetpack',
			'woocommerce' => 'WooCommerce',
		);
	}

	/**
	 * Return array of migration checkpoints start from specified version.
	 *
	 * @return array
	 */
	public function get_migration_checkpoints() {
		return array(
			'0.6.0',
			'0.7.0',
			'1.1.0',
			'1.2.0',
			'1.3.0',
		);
	}
}

Cakecious::instance();