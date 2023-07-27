<?php
/**
 * Cakecious Pro module: White Label Admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_White_Label_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_White_Label_Admin
	 */
	private static $instance;

	/**
	 * White Label data
	 *
	 * @var array
	 */
	private $white_label;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Cakecious_Pro_Module_White_Label_Admin
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
		// Set the white label data variable.
		$this->white_label = get_option( 'cakecious_white_label', array() );

		// Settings API
		add_action( 'admin_init', array( $this, 'add_settings' ) );

		// Admin page
		add_action( 'cakecious/admin/menu', array( $this, 'add_admin_menu' ) );

		// Show / hide admin page
		register_deactivation_hook( CAKECIOUS_PRO_FILE, array( $this, 'show_admin_page_after_deactivation' ) );
		add_action( 'add_option_cakecious_white_label', array( $this, 'hide_admin_page_after_enabled' ), 10, 2 );
		add_action( 'update_option_cakecious_white_label', array( $this, 'hide_admin_page_after_enabled' ), 10, 2 );
		add_filter( 'pre_update_option_cakecious_white_label', array( $this, 'hide_admin_page_after_enabled_without_changes' ), 10, 3 );

		// Apply white label data if enabled.
		if ( $this->get_data( 'enabled' ) ) {
			// Remove theme dashboard welcome.
			remove_action( 'admin_notices', array( Cakecious_Admin::instance(), 'add_theme_welcome' ), 999 );

			// Remove theme notice.
			remove_action( 'admin_notices', array( Cakecious_Admin::instance(), 'add_rating_notice' ), 10 );

			// Remove admin page panels.
			remove_all_actions( 'cakecious/admin/dashboard/sidebar' );

			// Replace logo with custom theme name.
			if ( $this->get_data( 'cakecious_name' ) ) {
				remove_action( 'cakecious/admin/dashboard/logo', array( Cakecious_Admin::instance(), 'render_logo__image' ), 10 );
				add_action( 'cakecious/admin/dashboard/logo', array( $this, 'render_logo__text' ), 10 );
			}

			// Replace cakecious_get_theme_info values.
			add_filter( 'cakecious/theme_info', array( $this, 'replace_theme_info' ) );

			// Replace Cakecious_Pro::instance()->get_info() values.
			add_filter( 'cakecious/pro/plugin_info', array( $this, 'replace_plugin_info' ) );

			// Replace details on plugins page.
			add_filter( 'all_plugins', array( $this, 'replace_details_on_plugins_page' ) );

			// Replace details on themes page.
			add_filter( 'all_themes', array( $this, 'replace_details_on_network_themes_page' ) );
			add_filter( 'wp_prepare_themes_for_js', array( $this, 'replace_details_on_themes_page' ) );

			// Replace details on Customizer page.
			add_action( 'customize_register', array( $this, 'replace_details_on_customizer' ) );

			// Replace status text on Dashboard.
			add_filter( 'update_right_now_text', array( $this, 'replace_details_on_dashboard_status' ) );
		}
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Appearance > Cakecious White Label.
	 */
	public function add_admin_menu() {
		if ( 0 === intval( get_option( 'cakecious_white_label_hide' ) ) ) {
			add_theme_page(
				esc_html__( 'White Label', 'cakecious-features' ),
				esc_html__( 'White Label', 'cakecious-features' ),
				'edit_theme_options',
				'cakecious-white-label',
				array( $this, 'render_admin_page' )
			);
		}
	}
	
	/**
	 * Add settings via Options API.
	 */
	public function add_settings() {
		add_settings_section(
			'cakecious_white_label',
			null,
			null,
			'cakecious-white-label'
		);

		add_settings_field(
			'cakecious_white_label',
			null,
			array( $this, 'render_setting' ),
			'cakecious-white-label',
			'cakecious_white_label',
			array(
				'class' => 'hide-th',
			)
		);

		register_setting(
			'cakecious-white-label',
			'cakecious_white_label',
			array(
				'sanitize_callback' => array( $this, 'sanitize_setting' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * Reset option to hide white label page when deactivating plugin.
	 */
	public function show_admin_page_after_deactivation() {
		update_option( 'cakecious_white_label_hide', 0 );
	}

	/**
	 * Hide white label page when settings are saved.
	 *
	 * @param mixed $first_param
	 * @param mixed $value
	 */
	public function hide_admin_page_after_enabled( $first_param, $value ) {
		if ( intval( cakecious_array_value( $value, 'enabled' ) ) ) {
			$this->hide_admin_page();
		}
	}

	/**
	 * Hide white label page when settings are saved.
	 *
	 * @param mixed $value
	 * @param mixed $old_value
	 * @param mixed $option
	 * @return mixed
	 */
	public function hide_admin_page_after_enabled_without_changes( $value, $old_value, $option ) {
		if ( $value === $old_value || maybe_serialize( $value ) === maybe_serialize( $old_value ) ) {
			if ( intval( cakecious_array_value( $value, 'enabled' ) ) ) {

				$this->hide_admin_page();
			}
		}

		return $value;
	}

	/**
	 * Replace theme info with white label data.
	 *
	 * @param array $info
	 * @return array
	 */
	public function replace_theme_info( $info ) {
		$mapping = array(
			'name' => 'cakecious_name',
			'description' => 'cakecious_description',
			'author' => 'author_name',
			'author_url' => 'author_url',
			'screenshot' => 'cakecious_screenshot_url',
		);

		foreach ( $mapping as $original_key => $white_label_key ) {
			$value = $this->get_data( $white_label_key );
			if ( ! empty( $value ) ) {
				$info[ $original_key ] = $value;
			}
		}

		return $info;
	}

	/**
	 * Replace plugin info with white label data.
	 *
	 * @param array $info
	 * @return array
	 */
	public function replace_plugin_info( $info ) {
		$mapping = array(
			'name' => 'cakecious_pro_name',
			'description' => 'cakecious_pro_description',
			'author' => 'author_name',
			'author_url' => 'author_url',
		);

		foreach ( $mapping as $original_key => $white_label_key ) {
			$value = $this->get_data( $white_label_key );
			if ( ! empty( $value ) ) {
				$info[ $original_key ] = $value;
			}
		}

		return $info;
	}

	/**
	 * Replace cakecious pro info on plugins page.
	 *
	 * @param array $plugins
	 * @return array
	 */
	public function replace_details_on_plugins_page( $plugins ) {
		if ( isset( $plugins[ CAKECIOUS_PRO_FILE ] ) ) {
			$mapping = array(
				'Name' => 'cakecious_pro_name',
				'Description' => 'cakecious_pro_description',
				'Author' => 'author_name',
				'AuthorName' => 'author_name',
				'AuthorURI' => 'author_url',
				'PluginURI' => 'author_url',
			);

			foreach ( $mapping as $original_key => $white_label_key ) {
				$value = $this->get_data( $white_label_key );
				if ( ! empty( $value ) ) {
					$plugins[ CAKECIOUS_PRO_FILE ][ $original_key ] = $value;
				}
			}
		}

		return $plugins;
	}

	/**
	 * Replace theme info on network themes page.
	 *
	 * @param array $themes
	 * @return array
	 */
	public function replace_details_on_network_themes_page( $themes ) {
		if ( ! is_network_admin() ) {
			return $themes;
		}

		$slug = 'cakecious';

		if ( isset( $themes[ $slug ] ) ) {
			$mapping = array(
				'Name' => 'cakecious_name',
				'Description' => 'cakecious_description',
				'Author' => 'author_name',
				'AuthorURI' => 'author_url',
				'ThemeURI' => 'author_url',
			);

			foreach ( $mapping as $original_key => $white_label_key ) {
				$value = $this->get_data( $white_label_key );
				if ( ! empty( $value ) ) {
					if ( is_array( $themes[ $slug ][ $original_key ] ) ) {
						$themes[ $slug ][ $original_key ] = (array) $value;
					} else {
						$themes[ $slug ][ $original_key ] = $value;
					}

					if ( 'name' === $original_key ) {
						foreach ( $themes as $theme_slug => $theme_data ) {
							if ( isset( $theme_data['parent'] ) && 'Cakecious' == $theme_data['parent'] ) {
								$themes[ $theme_slug ]['parent'] = $value;
							}
						}
					}
				}
			}
		}
		
		return $themes;
	}

	/**
	 * Replace theme info on themes page.
	 *
	 * @param array $themes
	 * @return array
	 */
	public function replace_details_on_themes_page( $themes ) {
		$slug = 'cakecious';

		if ( isset( $themes[ $slug ] ) ) {

			$mapping = array(
				'name' => 'cakecious_name',
				'description' => 'cakecious_description',
				'author' => 'author_name',
				'screenshot' => 'cakecious_screenshot_url',
			);

			foreach ( $mapping as $original_key => $white_label_key ) {
				$value = $this->get_data( $white_label_key );
				if ( ! empty( $value ) ) {
					if ( is_array( $themes[ $slug ][ $original_key ] ) ) {
						$themes[ $slug ][ $original_key ] = (array) $value;
					} else {
						$themes[ $slug ][ $original_key ] = $value;
					}

					switch ( $original_key ) {
						case 'author':
							$url = $this->get_data( $white_label_key );

							if ( ! empty( $url ) ) {
								$themes[ $slug ]['authorAndUri'] = '<a href="' . esc_url( $url ) . '">' . $value . '</a>';
							}
							break;

						case 'name':
							foreach ( $themes as $theme_slug => $theme_data ) {
								if ( isset( $theme_data['parent'] ) && 'Cakecious' == $theme_data['parent'] ) {
									$themes[ $theme_slug ]['parent'] = $value;
								}
							}
							break;
					}
				}
			}
		}

		return $themes;
	}

	/**
	 * Replace cakecious pro info on Customizer page.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function replace_details_on_customizer( $wp_customize ) {
		$panel = $wp_customize->get_panel( 'themes' );

		$wp_customize->add_panel( new WP_Customize_Themes_Panel( $wp_customize, 'themes', array(
			'title'       => $this->get_data( 'cakecious_name' ),
			'description' => $panel->description,
			'capability'  => $panel->capability,
			'priority'    => $panel->priority,
		) ) );
	}

	/**
	 * Replace "WordPress %1$s running %2$s theme." text on Dashboard page.
	 *
	 * @param string $content
	 */
	public function replace_details_on_dashboard_status( $content ) {
		$name = $this->get_data( 'cakecious_name' );
		
		if ( ! empty( $name ) ) {
			$content = str_replace( '%2$s', '<a href="themes.php">' . $name . '</a>', $content );
		}

		return $content;
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Helper function to get white label data.
	 *
	 * @param string $key
	 * @return string
	 */
	private function get_data( $key ) {
		return cakecious_array_value( $this->white_label, $key );
	}

	private function hide_admin_page() {
		// Update DB.
		update_option( 'cakecious_white_label_hide', 1 );

		// Add success notice.
		Cakecious_Pro_Notice::instance()->add_notice( array(
			'type' => 'success',
			/* translators: %s: module name */
			'text' => esc_html__( 'White Label mode is now activated. The White Label settings page and all default branding panels are now hidden. You can show the White Label settings page again by reactivating Cakecious Pro plugin.', 'cakecious-features' ),
		) );

		// Redirect to Cakecious dashboard page.
		wp_safe_redirect( admin_url( 'themes.php?page=cakecious' ) );
		exit;
	}

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
		<div class="wrap cakecious-white-label-wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<?php settings_errors(); ?>
			<hr class="wp-header-end">

			<form action="options.php" method="post">
				<?php
				settings_fields( 'cakecious-white-label' );
				do_settings_sections( 'cakecious-white-label' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render option field for "cakecious_white_label" setting.
	 */
	public function render_setting() {
		$option_key = 'cakecious_white_label';

		$values = get_option( $option_key, array() );
		?>
		<p class="description"><?php esc_html_e( 'White Label mode allows you to remove Cakecious\'s default branding details and replace them with your own branding details. It is mostly used if you are building websites for clients.', 'cakecious-features' ); ?></p>
		<br>
		<div class="cakecious-admin-white-label cakecious-admin-form metabox-holder">

			<?php $key = 'enabled'; ?>
			<input type="checkbox" id="cakecious-enable-white-label" name="<?php echo esc_attr( $option_key . '[' . $key . ']' ); ?>" value="1" <?php echo ( cakecious_array_value( $values, $key ) ? 'checked' : '' ); ?>>

			<div class="postbox">
				<h2 class="hndle">
					<label for="cakecious-enable-white-label"><?php esc_html_e( 'Enable White Label mode', 'cakecious-features' ); ?></label>
				</h2>
				<div class="inside">
					<h3><?php esc_html_e( 'Agency / Author', 'cakecious-features' ); ?></h3>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Agency / author name', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'author_name';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'text',
								'value'       => cakecious_array_value( $values, $key, '' ),
								'class'       => 'widefat',
							) );
							?>
						</div>
					</div>
					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Agency / author URL', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'author_url';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'url',
								'value'       => cakecious_array_value( $values, $key, '' ),
								'class'       => 'widefat',
							) );
							?>
						</div>
					</div>

					<br><hr><br>

					<h3><?php esc_html_e( 'Cakecious (Theme)', 'cakecious-features' ); ?></h3>
				
					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Theme name', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'cakecious_name';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'text',
								'value'       => cakecious_array_value( $values, $key, '' ),
								'class'       => 'widefat',
							) );
							?>
						</div>
					</div>
					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Theme description', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'cakecious_description';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'textarea',
								'value'       => cakecious_array_value( $values, $key, '' ),
								'class'       => 'widefat',
								'rows'        => 5,
							) );
							?>
						</div>
					</div>
					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Theme screenshot URL', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'cakecious_screenshot_url';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'url',
								'value'       => cakecious_array_value( $values, $key, '' ),
								'class'       => 'widefat',
							) );
							?>
						</div>
					</div>

					<br><hr><br>

					<h3><?php esc_html_e( 'Cakecious Pro', 'cakecious-features' ); ?></h3>
				
					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Plugin name', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'cakecious_pro_name';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'text',
								'value'       => cakecious_array_value( $values, $key, '' ),
								'class'       => 'widefat',
							) );
							?>
						</div>
					</div>
					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Plugin description', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'cakecious_pro_description';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'textarea',
								'value'       => cakecious_array_value( $values, $key, '' ),
								'class'       => 'widefat',
								'rows'        => 5,
							) );
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="notice inline notice-warning">
				<p><?php esc_html_e( 'Once enabled, this page would be hidden. If you want to change settings on this page again later, you MUST reactivate the Cakecious Pro plugin (deactivate and activate again).', 'cakecious-features' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Render custom admin logo text.
	 */
	public function render_logo__text() {
		?>
		<span><?php echo esc_html( $this->get_data( 'cakecious_name' ) ); ?></span>
		<?php
	}

	/**
	 * ====================================================
	 * Sanitization functions
	 * ====================================================
	 */

	/**
	 * Sanitize white label data input.
	 *
	 * @param array $data
	 * @return array
	 */
	public function sanitize_setting( $data ) {
		$sanitized = array();

		foreach ( $data as $key => $value ) {
			// Skip if value is empty.
			if ( empty( $value ) ) continue;

			$sanitized[ $key ] = $value;
		}

		return $sanitized;
	}
}

Cakecious_Pro_Module_White_Label_Admin::instance();