<?php
/**
 * Cakecious Admin page basic functions
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Admin {
	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Admin
	 */
	private static $instance;

	/**
	 * Parent menu slug of all theme pages
	 *
	 * @var string
	 */
	private $_menu_id = 'cakecious';

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Cakecious_Admin
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
		// General admin hooks on every admin pages
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_javascripts' ) );

		add_action( 'admin_notices', array( $this, 'add_theme_welcome' ), 999 );

		// Classic editor hooks
		// TODO
		// add_action( 'init', array( $this, 'add_editor_css' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'add_classic_editor_custom_css' ) );
		// add_filter( 'block_editor_settings', array( $this, 'add_gutenberg_custom_css' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );

		// Cakecious admin page hooks
		add_action( 'cakecious/admin/dashboard/header', array( $this, 'render_admin_page__logo' ), 10 );
		add_action( 'cakecious/admin/dashboard/content', array( $this, 'render_admin_page__modules' ), 10 );

		$this->_includes();
	}

	/**
	 * Include additional files.
	 */
	private function _includes() {
		require_once( CAKECIOUS_INCLUDES_DIR . '/admin/class-cakecious-admin-fields.php' );

		// Only include metabox on post add/edit page and term add/edit page.
		global $pagenow;
		if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit-tags.php', 'term.php' ) ) ) {
			require_once( CAKECIOUS_INCLUDES_DIR . '/admin/class-cakecious-admin-metabox-page-settings.php' );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Appearance > Cakecious.
	 */
	public function register_admin_menu() {
		add_theme_page(
			cakecious_get_theme_info( 'name' ),
			cakecious_get_theme_info( 'name' ),
			'edit_theme_options',
			'cakecious',
			array( $this, 'render_admin_page' )
		);

		/**
		 * Hook: cakecious/admin/menu
		 */
		do_action( 'cakecious/admin/menu' );
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_styles( $hook ) {
		/**
		 * Hook: Styles to be included before admin CSS
		 */
		do_action( 'cakecious/admin/before_enqueue_admin_css', $hook );

		// Register CSS files
		wp_register_style( 'alpha-color-picker', CAKECIOUS_CSS_URL . '/vendors/alpha-color-picker' . CAKECIOUS_ASSETS_SUFFIX . '.css', array( 'wp-color-picker' ), CAKECIOUS_VERSION );

		// Enqueue CSS files
		wp_enqueue_style( 'cakecious-admin', CAKECIOUS_CSS_URL . '/admin/admin.css', array(), CAKECIOUS_VERSION );
		wp_style_add_data( 'cakecious-admin', 'rtl', 'replace' );
		wp_style_add_data( 'cakecious-admin', 'suffix', CAKECIOUS_ASSETS_SUFFIX );

		/**
		 * Hook: Styles to be included after admin CSS
		 */
		do_action( 'cakecious/admin/after_enqueue_admin_css', $hook );
	}

	/**
	 * Enqueue admin javascripts.
	 *
	 * @param string $hook
	 */
	public function enqueue_admin_javascripts( $hook ) {
		// Fetched version from package.json
		$ver = array();
		$ver['html5sortable'] = '';

		/**
		 * Hook: Styles to be included before admin JS
		 */
		do_action( 'cakecious/admin/before_enqueue_admin_js', $hook );

		// Register JS files
		wp_register_script( 'alpha-color-picker', CAKECIOUS_JS_URL . '/vendors/alpha-color-picker' . CAKECIOUS_ASSETS_SUFFIX . '.js', array( 'jquery', 'wp-color-picker' ), CAKECIOUS_VERSION, true );
		wp_register_script( 'html5sortable', CAKECIOUS_JS_URL . '/vendors/html5sortable' . CAKECIOUS_ASSETS_SUFFIX . '.js', array(), $ver['html5sortable'], true );

		// Enqueue JS files.
		wp_enqueue_script( 'cakecious-admin', CAKECIOUS_JS_URL . '/admin/admin' . CAKECIOUS_ASSETS_SUFFIX . '.js', array( 'jquery' ), CAKECIOUS_VERSION, true );

		/**
		 * Hook: Styles to be included after admin JS
		 */
		do_action( 'cakecious/admin/after_enqueue_admin_js', $hook );
	}

	/**
	 * Add welcome panel on the Appearance > Themes page.
	 */
	public function add_theme_welcome() {
		if ( 'themes' !== get_current_screen()->id ) {
			return;
		}
		?>
		<div class="cakecious-admin-themes-welcome notice is-dismissible">
			<h2><?php esc_html_e( 'Welcome to Cakecious!', 'cakecious' ); ?></h2>
			<p><?php esc_html_e( 'Thank you for installing Cakecious! Please visit the theme dashboard for more info about Cakecious features.', 'cakecious' ); ?></p>
			<p><?php esc_html_e( 'Next step is to go to Appearance -> Install Plugins to install and activate required plugins. Please note Install Plugins menu exists only if there are some plugins to be activated.', 'cakecious' ); ?></p>
		</div>
	<?php
	}

	/**
	 * Add CSS for editor page.
	 */
	public function add_editor_css() {
		add_editor_style( CAKECIOUS_CSS_URL . '/admin/editor' . CAKECIOUS_ASSETS_SUFFIX . '.css' );

		add_editor_style( Cakecious_Customizer::instance()->generate_active_google_fonts_embed_url() );
	}

	/**
	 * Add custom CSS to classic editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_classic_editor_custom_css( $settings ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}
		// Skip Gutenberg editor page.
		$current_screen = get_current_screen();
		if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
			return $settings;
		}

		global $post;

		if ( empty( $post ) ) {
			return $settings;
		}

		$css_array = array(
			'global' => array(),
		);

		// TinyMCE HTML
		$css_array['global']['html']['background-color'] = '#fcfcfc';

		// Typography
		$active_google_fonts = array();
		$typography_types = array(
			'body' => 'body',
			'blockquote' => 'blockquote',
			'h1' => 'h1',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
		);
		$fonts = cakecious_get_all_fonts();

		foreach ( $typography_types as $type => $selector ) {
			// Font Family
			$font_family = cakecious_get_theme_mod( $type . '_font_family' );
			$font_stack = $font_family;
			if ( '' !== $font_family && 'inherit' !== $font_family ) {
				$chunks = explode( '|', $font_family );
				if ( 2 === count( $chunks ) ) {
					$font_stack = cakecious_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}
			if ( ! empty( $font_stack ) ) {
				$css_array['global'][ $selector ]['font-family'] = $font_stack;
			}

			// Font weight
			$font_weight = cakecious_get_theme_mod( $type . '_font_weight' );
			if ( ! empty( $font_weight ) ) {
				$css_array['global'][ $selector ]['font-weight'] = $font_weight;
			}

			// Font style
			$font_style = cakecious_get_theme_mod( $type . '_font_style' );
			if ( ! empty( $font_style ) ) {
				$css_array['global'][ $selector ]['font-style'] = $font_style;
			}

			// Text transform
			$text_transform = cakecious_get_theme_mod( $type . '_text_transform' );
			if ( ! empty( $text_transform ) ) {
				$css_array['global'][ $selector ]['text-transform'] = $text_transform;
			}

			// Font size
			$font_size = cakecious_get_theme_mod( $type . '_font_size' );
			if ( ! empty( $font_size ) ) {
				$css_array['global'][ $selector ]['font-size'] = $font_size;
			}

			// Line height
			$line_height = cakecious_get_theme_mod( $type . '_line_height' );
			if ( ! empty( $line_height ) ) {
				$css_array['global'][ $selector ]['line-height'] = $line_height;
			}

			// Letter spacing
			$letter_spacing = cakecious_get_theme_mod( $type . '_letter_spacing' );
			if ( ! empty( $letter_spacing ) ) {
				$css_array['global'][ $selector ]['letter-spacing'] = $letter_spacing;
			}
		}

		// Content wrapper width for content layout with sidebar
		// $css_array['global']['body.cakecious-editor-left-sidebar']['width'] =
		// $css_array['global']['body.cakecious-editor-right-sidebar']['width'] = 'calc(' . cakecious_get_content_width_by_layout() . 'px + 2rem)';

		// // Content wrapper width for narrow content layout
		// $css_array['global']['body.cakecious-editor-narrow']['width'] = 'calc(' . cakecious_get_content_width_by_layout( 'narrow' ) . 'px + 2rem)';

		// // Content wrapper width for full content layout
		// $css_array['global']['body.cakecious-editor-wide']['width'] = 'calc(' . cakecious_get_content_width_by_layout( 'wide' ) . 'px + 2rem)';

		// Build CSS string.
		// $styles = str_replace( '"', '\"', cakecious_convert_css_array_to_string( $css_array ) );
		$styles = wp_slash( cakecious_convert_css_array_to_string( $css_array ) );

		// Merge with existing styles or add new styles.
		if ( ! isset( $settings['content_style'] ) ) {
			$settings['content_style'] = $styles . ' ';
		} else {
			$settings['content_style'] .= ' ' . $styles . ' ';
		}

		return $settings;
	}

	/**
	 * Enqueue Block Editor assets.
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_style( 'cakecious-editor-block', CAKECIOUS_CSS_URL . '/admin/editor-block' . CAKECIOUS_ASSETS_SUFFIX . '.css', array(), CAKECIOUS_VERSION );
		wp_style_add_data( 'cakecious-editor-block', 'rtl', 'replace' );
	}

	/**
	 * Add custom CSS to Gutenberg editor.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_gutenberg_custom_css( $settings ) {
		$css_array = array();

		// Content width
		$css_array['global']['.wp-block']['max-width'] = 'calc(' . cakecious_get_theme_mod( 'content_narrow_width' ) . ' + ' . '30px)';
		$css_array['global']['.wp-block[data-align="wide"]']['max-width'] = 'calc(' . cakecious_get_theme_mod( 'container_width' ) . ' + ' . '30px)';
		$css_array['global']['.wp-block[data-align="full"]']['max-width'] = 'none';
		$css_array['global']['.editor-post-title__block .editor-post-title__input']['font-family'] = 'inherit';
		$css_array['global']['.editor-post-title__block .editor-post-title__input']['font-weight'] = 'inherit';
		$css_array['global']['.editor-post-title__block .editor-post-title__input']['font-style'] = 'inherit';
		$css_array['global']['.editor-post-title__block .editor-post-title__input']['text-transform'] = 'inherit';
		$css_array['global']['.editor-post-title__block .editor-post-title__input']['font-size'] = 'inherit';
		$css_array['global']['.editor-post-title__block .editor-post-title__input']['line-height'] = 'inherit';
		$css_array['global']['.editor-post-title__block .editor-post-title__input']['letter-spacing'] = 'inherit';

		// Typography
		$active_google_fonts = array();
		$typography_types = array(
			'body' => 'body',
			'blockquote' => 'blockquote',
			'h1' => 'h1, .editor-post-title__block .editor-post-title__input',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
			'title' => '.editor-post-title__block .editor-post-title__input',
		);
		$fonts = cakecious_get_all_fonts();

		foreach ( $typography_types as $type => $selector ) {
			// Font Family
			$font_family = cakecious_get_theme_mod( $type . '_font_family' );
			$font_stack = $font_family;
			if ( '' !== $font_family && 'inherit' !== $font_family ) {
				$chunks = explode( '|', $font_family );
				if ( 2 === count( $chunks ) ) {
					$font_stack = cakecious_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
				}
			}
			if ( ! empty( $font_stack ) ) {
				$css_array['global'][ $selector ]['font-family'] = $font_stack;
			}

			// Font weight
			$font_weight = cakecious_get_theme_mod( $type . '_font_weight' );
			if ( ! empty( $font_weight ) ) {
				$css_array['global'][ $selector ]['font-weight'] = $font_weight;
			}

			// Font style
			$font_style = cakecious_get_theme_mod( $type . '_font_style' );
			if ( ! empty( $font_style ) ) {
				$css_array['global'][ $selector ]['font-style'] = $font_style;
			}

			// Text transform
			$text_transform = cakecious_get_theme_mod( $type . '_text_transform' );
			if ( ! empty( $text_transform ) ) {
				$css_array['global'][ $selector ]['text-transform'] = $text_transform;
			}

			// Font size
			$font_size = cakecious_get_theme_mod( $type . '_font_size' );
			if ( ! empty( $font_size ) ) {
				$css_array['global'][ $selector ]['font-size'] = $font_size;
			}

			// Line height
			$line_height = cakecious_get_theme_mod( $type . '_line_height' );
			if ( ! empty( $line_height ) ) {
				$css_array['global'][ $selector ]['line-height'] = $line_height;
			}

			// Letter spacing
			$letter_spacing = cakecious_get_theme_mod( $type . '_letter_spacing' );
			if ( ! empty( $letter_spacing ) ) {
				$css_array['global'][ $selector ]['letter-spacing'] = $letter_spacing;
			}
		}

		// Relative heading margin top
		$css_array['global']['h1, h2, h3, h4, h5, h6']['margin-top'] = 'calc( 2 * ' . cakecious_get_theme_mod( 'body_font_size' ) . ') !important';

		// Add to settings array.
		$settings['styles']['cakecious-custom'] = array(
			'css' => cakecious_convert_css_array_to_string( $css_array ),
		);

		return $settings;
	}

	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render admin page.
	 */
	public function render_admin_page() {
		?>
		<div class="wrap cakecious-admin-wrap <?php echo esc_attr( cakecious_is_pro() ? 'cakecious-pro-installed' : '' ); ?>">
			<div class="cakecious-admin-header">
				<div class="cakecious-admin-wrapper wp-clearfix">
					<?php
					/**
					 * Hook: cakecious/admin/dashboard/header
					 */
					do_action( 'cakecious/admin/dashboard/header' );
					?>
				</div>
			</div>

			<div class="cakecious-admin-notices">
				<div class="cakecious-admin-wrapper">
					<h1 style="display: none;"></h1>

					<?php settings_errors(); ?>
				</div>
			</div>

			<div class="cakecious-admin-content metabox-holder">
				<div class="cakecious-admin-wrapper">
					<div class="cakecious-admin-content-row">
						<div class="cakecious-admin-primary">
							<?php
							/**
							 * Hook: cakecious/admin/dashboard/content
							 */
							do_action( 'cakecious/admin/dashboard/content' );
							?>
						</div>

						<?php if ( has_action( 'cakecious/admin/dashboard/sidebar' ) ) : ?>
							<div class="cakecious-admin-secondary">
								<?php
								/**
								 * Hook: cakecious/admin/dashboard/sidebar
								 */
								do_action( 'cakecious/admin/dashboard/sidebar' );
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	/**
	 * Render logo on Cakecious admin page.
	 */
	public function render_admin_page__logo() {
		?>
		<div class="cakecious-admin-logo">
			<span><?php esc_html_e('Cakecious WordPress Theme', 'cakecious'); ?></span>
			<span class="cakecious-admin-version"><?php echo cakecious_get_theme_info( 'version' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		</div>
	<?php
	}

	/**
	 * Render modules manager on Cakecious admin page.
	 */
	public function render_admin_page__modules() {
		$all_modules = array();
		$module_categories = cakecious_get_module_categories();

		// Fetch free modules.
		foreach ( cakecious_get_theme_modules() as $module_slug => $module_data ) {
			$data = wp_parse_args( $module_data, array(
				'label'    => '',
				'url'      => '',
				'category' => '',
				'actions'  => array(),
				'hide'     => false,
				'pro'      => false,
				'active'   => true,
			) );

			// Always flag all free modules as FREE.
			$data['pro'] = false;

			// Always make sure all free modules are active.
			$data['active'] = true;

			// Add action.
			$data['actions']['enabled'] = array(
				'label' => esc_html__( 'Core Module', 'cakecious' ),
			);

			// Add to collection.
			if ( ! empty( $data['category'] ) ) {
				$all_modules[ $data['category'] ][ $module_slug ] = $data;
			}
		}

		// Fetch pro modules.
		foreach ( cakecious_get_pro_modules() as $module_slug => $module_data ) {
			$data = wp_parse_args( $module_data, array(
				'label'    => '',
				'url'      => '',
				'category' => '',
				'actions'  => array(),
				'hide'     => false,
				'pro'      => true,
				'active'   => false,
			) );

			// Always flag all free modules as PRO.
			$data['pro'] = true;

			// Add to collection.
			if ( ! empty( $data['category'] ) ) {
				$all_modules[ $data['category'] ][ $module_slug ] = $data;
			}
		}

		?>
		<div class="cakecious-admin-modules postbox" action="" method="POST">
			<h2 class="hndle">
				<?php echo wp_kses_post( apply_filters( 'cakecious/pro/modules/list_heading', esc_html__( 'Welcome to Cakecious!', 'cakecious' ) ) ); ?>
			</h2>
			<div class="inside">
				<h3><?php echo esc_html( 'Important Information', 'cakecious' ); ?></h3>
				<p> <?php echo wp_kses_post( 'Thank you for using Cakecious WordPress Theme. We hope you enjoy using the theme. Below are some important links for you to get started easily with the theme.' ); ?></p>
				<?php if ( ! defined('CAKECIOUS_FW_ROOT') ) {
					echo '<p><b>';
					echo esc_html( 'Please install required plugins by going to Appearance/Install Plugins', 'cakecious' );
					echo '</p></b>';
				} else { ?>
					<p> <a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_dashboard' ?>"><?php _e( 'Start here', 'cakecious' ); ?></a> </p>
					<p> <a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_demosetup' ?>"><?php _e( 'Demo Import', 'cakecious' ); ?></a> </p>
					<p> <a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_help' ?>"><?php _e( 'Help & Support', 'cakecious' ); ?></a> </p>
					<p> <a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_options' ?>"><?php _e( 'Theme Options / Customize', 'cakecious' ); ?></a> </p>
				<?php
				}
				?>
			</div>
		</div>
	<?php
	}

}

Cakecious_Admin::instance();