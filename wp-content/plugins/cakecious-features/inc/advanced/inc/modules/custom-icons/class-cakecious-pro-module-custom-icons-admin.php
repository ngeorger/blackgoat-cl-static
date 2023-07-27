<?php
/**
 * Cakecious Pro module: Custom Icons Admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Custom_Icons_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_Custom_Icons_Admin
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
	 * @return Cakecious_Pro_Module_Custom_Icons_Admin
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
		// Upload mimes
		add_filter( 'upload_mimes', array( $this, 'add_upload_mimes' ) );

		// Settings API
		add_action( 'admin_init', array( $this, 'add_settings' ) );

		// Admin page
		add_action( 'cakecious/admin/menu', array( $this, 'add_admin_menu' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add upload mimes for icon files.
	 *
	 * @param array $mimes
	 * @return array
	 */
	public function add_upload_mimes( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * Add admin submenu page: Appearance > Custom Icons.
	 */
	public function add_admin_menu() {
		add_theme_page(
			esc_html__( 'Custom Icons', 'cakecious-features' ),
			esc_html__( 'Custom Icons', 'cakecious-features' ),
			'edit_theme_options',
			'cakecious-custom-icons',
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Add settings via Options API.
	 */
	public function add_settings() {
		foreach ( $this->get_tabs() as $tab => $label ) {
			add_settings_section(
				'cakecious_custom_icons__' . $tab,
				null,
				null,
				'cakecious-custom-icons--' . $tab
			);

			add_settings_field(
				'cakecious_custom_icons_' . $tab,
				null,
				array( $this, 'render_setting__' . $tab ),
				'cakecious-custom-icons--' . $tab,
				'cakecious_custom_icons__' . $tab,
				array(
					'class' => 'hide-th',
				)
			);

			register_setting(
				'cakecious-custom-icons--' . $tab,
				'cakecious_custom_icons_' . $tab,
				array(
					'sanitize_callback' => array( $this, 'sanitize_setting__' . $tab ),
					'default'           => array(),
				)
			);
		}
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
		$tabs = $this->get_tabs();
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : key( $tabs );

		?>
		<div class="wrap cakecious-custom-icons-wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<?php settings_errors(); ?>
			<hr class="wp-header-end">

			<div class="nav-tab-wrapper">
				<?php foreach ( $tabs as $tab => $label ) : ?>
					<a href="<?php echo esc_url( add_query_arg( array( 'tab' => $tab ) ) ); ?>" class="nav-tab <?php echo esc_attr( $current_tab === $tab ? 'nav-tab-active' : '' ); ?>"><?php echo do_shortcode($label); // WPCS: XSS OK. ?></a>
				<?php endforeach; ?>
			</div>

			<form action="options.php" method="post">
				<?php
				settings_fields( 'cakecious-custom-icons--' . $current_tab );
				do_settings_sections( 'cakecious-custom-icons--' . $current_tab );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render option field for "cakecious_custom_icons_override" setting.
	 */
	public function render_setting__override() {
		$all_icons = cakecious_get_all_icons();

		$option_key = 'cakecious_custom_icons_override';

		$add_social = get_option( 'cakecious_custom_icons_add_social', array() );
		$override = get_option( $option_key, array() );
		?>
		<p><?php esc_html_e( 'Upload custom SVG icon files to override theme\'s default icons.', 'cakecious-features' ); ?></p>
		<br>
		<div class="cakecious-admin-custom-icons-override cakecious-admin-form">
			<?php foreach ( $all_icons as $group => $icons ) : ?>
				<?php foreach ( $icons as $slug => $label ) : ?>

					<?php if ( 'social_icons' === $group && isset( $add_social[ $slug ] ) ) continue; ?>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php cakecious_icon( $slug ); ?><span><?php echo do_shortcode($label); // WPCS: XSS OK. ?></span></label></div>
						<div class="cakecious-admin-form-field">
							<?php Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $slug . ']',
								'type'        => 'upload',
								'value'       => cakecious_array_value( $override, $slug, '' ),
								'class'       => 'regular-text',
								'library'     => array( 'image' ),
								'frame_title' => esc_html__( 'Select .svg file', 'cakecious-features' ),
							) ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Render option field for "cakecious_custom_icons_override" setting.
	 */
	public function render_setting__add_social() {
		$option_key = 'cakecious_custom_icons_add_social';

		$add_social = get_option( $option_key, array() );
		?>
		<p><?php esc_html_e( 'Add new social icons and specifiy its SVG icon. The added social icons would be listed on Social links options on Customizer.', 'cakecious-features' ); ?></p>
		<p style="color: red;"><?php esc_html_e( '* All fields are required, otherwise the icons will not be saved.', 'cakecious-features' ); ?></p>
		<br>
		<div class="cakecious-admin-custom-icons-add-social cakecious-admin-repeater-control cakecious-admin-form">
			<ul data-repeater-list="cakecious_custom_icons_add_social" class="cakecious-admin-repeater-control-list">
				<?php if ( 0 < count( $add_social ) ) {
					foreach ( $add_social as $i => $icon ) {
						$this->render_setting__add_social__item( $icon );
					}
				} else {
					$this->render_setting__add_social__item();
				} ?>
			</ul>
			<input data-repeater-create type="button" class="cakecious-admin-repeater-control-add button" value="<?php esc_attr_e( 'Add Custom Icon', 'cakecious-features' ); ?>">
		</div>
		<?php
	}

	/**
	 * Render each item of "cakecious_custom_icons_override" setting field.
	 *
	 * @param array $icon
	 */
	public function render_setting__add_social__item( $icon = array() ) {
		$is_template = false;

		if ( empty( $icon ) ) {
			$is_template = true;
		}

		$icon = wp_parse_args( $icon, array(
			'slug'  => '',
			'label' => '',
			'svg'   => '',
		) );
		?>
		<li data-repeater-item class="cakecious-custom-icons-add-social-item cakecious-admin-repeater-control-item postbox" <?php echo $is_template ? 'style="display: none;"' : ''; ?>>
			<div class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Slug (unique)', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php
					$key = 'slug';
					Cakecious_Admin_Fields::render_field( array(
						'name'        => $key,
						'type'        => 'text',
						'placeholder' => esc_html__( 'e.g. "custom-social"', 'cakecious-features' ),
						'value'       => cakecious_array_value( $icon, $key ),
						'class'       => 'regular-text',
					) );
					?>
				</div>
			</div>
			<div class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Label', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php
					$key = 'label';
					Cakecious_Admin_Fields::render_field( array(
						'name'        => $key,
						'type'        => 'text',
						'placeholder' => esc_html__( 'e.g. "Custom Social"', 'cakecious-features' ),
						'value'       => cakecious_array_value( $icon, $key ),
						'class'       => 'regular-text',
					) );
					?>
				</div>
			</div>
			<div class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'SVG icon file', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php
					$key = 'svg';
					Cakecious_Admin_Fields::render_field( array(
						'name'        => 'svg',
						'type'        => 'upload',
						'value'       => cakecious_array_value( $icon, $key ),
						'class'       => 'regular-text',
						'library'     => array( 'image' ),
						'frame_title' => esc_html__( 'Select .SVG file', 'cakecious-features' ),
					) );
					?>
				</div>
			</div>

			<a href="javascript:;" data-repeater-delete type="button" class="cakecious-admin-repeater-control-delete button button-small"><span class="dashicons dashicons-no-alt"></span></a>
		</li>
		<?php
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Return list of available tabs.
	 *
	 * @return array
	 */
	private function get_tabs() {
		return array(
			'override'   => esc_html__( 'Override Default Icons', 'cakecious-features' ),
			'add_social' => esc_html__( 'Add Social Icons', 'cakecious-features' ),
		);
	}

	/**
	 * ====================================================
	 * Sanitization functions
	 * ====================================================
	 */

	/**
	 * Sanitize override icons array input.
	 *
	 * @param array $data
	 * @return array
	 */
	public function sanitize_setting__override( $data ) {
		$sanitized = array();

		foreach ( $data as $key => $value ) {
			// Skip if value is empty.
			if ( empty( $value ) ) continue;

			$sanitized[ $key ] = $value;
		}

		return $sanitized;
	}

	/**
	 * Sanitize new social icons array input.
	 *
	 * @param array $data
	 * @return array
	 */
	public function sanitize_setting__add_social( $data ) {
		$sanitized = array();

		foreach ( $data as $i => $icon ) {
			// Skip if icon has no slug.
			if ( empty( $icon['slug'] ) ) continue;
			
			// Skip if icon has no label.
			if ( empty( $icon['label'] ) ) continue;
			
			// Skip if icon has no svg.
			if ( empty( $icon['svg'] ) ) continue;

			$sanitized[ $icon['slug'] ] = $icon;
		}

		return $sanitized;
	}
}

Cakecious_Pro_Module_Custom_Icons_Admin::instance();