<?php
/**
 * Cakecious Pro module: Custom Fonts Admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Custom_Fonts_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_Custom_Fonts_Admin
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
	 * @return Cakecious_Pro_Module_Custom_Fonts_Admin
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
	 * Add upload mimes for font files.
	 *
	 * @param array $mimes
	 * @return array
	 */
	public function add_upload_mimes( $mimes ) {
		$mimes['otf'] = 'application/x-font-otf';
		$mimes['woff2'] = 'application/x-font-woff2';
		$mimes['woff'] = 'application/x-font-woff';
		$mimes['ttf'] = 'application/x-font-ttf';
		$mimes['eot'] = 'application/vnd.ms-fontobject';
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * Add admin submenu page: Appearance > Custom Fonts.
	 */
	public function add_admin_menu() {
		add_theme_page(
			esc_html__( 'Custom Fonts', 'cakecious-features' ),
			esc_html__( 'Custom Fonts', 'cakecious-features' ),
			'edit_theme_options',
			'cakecious-custom-fonts',
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Add settings via Options API.
	 */
	public function add_settings() {
		add_settings_section(
			'cakecious_settings__custom_fonts',
			null,
			null,
			'cakecious-custom-fonts'
		);

		add_settings_field(
			'cakecious_custom_fonts',
			null,
			array( $this, 'render_setting__upload_custom_fonts' ),
			'cakecious-custom-fonts',
			'cakecious_settings__custom_fonts',
			array(
				'class' => 'hide-th',
			)
		);

		register_setting(
			'cakecious-custom-fonts',
			'cakecious_custom_fonts',
			array(
				'sanitize_callback' => array( $this, 'sanitize_setting__upload_custom_fonts' ),
				'default'           => array(),
			)
		);
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
		<div class="wrap cakecious-custom-fonts-wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<?php settings_errors(); ?>
			<hr class="wp-header-end">

			<form action="options.php" method="post">
				<?php
				settings_fields( 'cakecious-custom-fonts' );
				do_settings_sections( 'cakecious-custom-fonts' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render option field for "cakecious_custom_fonts" setting.
	 */
	public function render_setting__upload_custom_fonts() {
		$fonts = get_option( 'cakecious_custom_fonts', array() );

		$config = array(
			'defaultValues' => array(
				'name'     => '',
				'variants' => array( '400|normal' ),
			),
			'initEmpty' => 1 > count( $fonts ) ? true : false,
		);

		?>
		<p class="description"><?php esc_html_e( 'You can add as many custom fonts as you want. The uploaded fonts would be available on Customizer and Elementor Page Builder options for styling your typography.', 'cakecious-features' ); ?></p>
		<p class="description"><?php esc_html_e( 'All the added fonts would be automatically enqueued on frontend, so please only add the fonts that you will use.', 'cakecious-features' ); ?></p>
		<p class="description"><?php esc_html_e( 'Each font should have name and at least one variant, otherwise the font would not be saved.', 'cakecious-features' ); ?></p>
		<p class="description"><?php esc_html_e( 'Please upload the font files in proper web font formats. You can use online service like Transfonter to convert your font into web font formats.', 'cakecious-features' ); ?></p>
		<p class="description"><?php esc_html_e( 'The most essential format is .woff (and .woff2), because it has the best performance and supported by major browsers.', 'cakecious-features' ); ?></p>
		<br>
		<div class="cakecious-admin-repeater-control cakecious-admin-custom-fonts cakecious-admin-form metabox-holder" data-config="<?php echo esc_attr( json_encode( $config ) ); ?>">
			<ul data-repeater-list="cakecious_custom_fonts" class="cakecious-admin-repeater-control-list">
				<?php if ( 0 < count( $fonts ) ) {
					foreach ( $fonts as $i => $font ) {
						$this->render_setting__upload_custom_fonts__item( $font );
					}
				} else {
					$this->render_setting__upload_custom_fonts__item();
				} ?>
			</ul>
			<input data-repeater-create type="button" class="cakecious-admin-repeater-control-add button" value="<?php esc_attr_e( 'Add Custom Font', 'cakecious-features' ); ?>">
		</div>
		<?php
	}

	/**
	 * Render each item of "cakecious_custom_fonts" setting field.
	 */
	public function render_setting__upload_custom_fonts__item( $font = array() ) {
		$is_template = false;

		if ( empty( $font ) ) {
			$is_template = true;
		}

		$font = wp_parse_args( $font, array(
			'name'     => '',
			'variants' => array(),
		) );

		$weights = array(
			'400' => esc_html__( 'Regular', 'cakecious-features' ),
			'100' => esc_html__( 'Thin', 'cakecious-features' ),
			'200' => esc_html__( 'Extra Light', 'cakecious-features' ),
			'300' => esc_html__( 'Light', 'cakecious-features' ),
			'500' => esc_html__( 'Medium', 'cakecious-features' ),
			'600' => esc_html__( 'Semi Bold', 'cakecious-features' ),
			'700' => esc_html__( 'Bold', 'cakecious-features' ),
			'800' => esc_html__( 'Extra Bold', 'cakecious-features' ),
			'900' => esc_html__( 'Black', 'cakecious-features' ),
		);
		?>
		<li data-repeater-item class="cakecious-admin-custom-font cakecious-admin-repeater-control-item postbox" <?php echo $is_template ? 'style="display: none;"' : ''; ?>>
			
			<div class="cakecious-admin-custom-font-name">
				<?php Cakecious_Admin_Fields::render_field( array(
					'name'        => 'name',
					'type'        => 'text',
					'value'       => cakecious_array_value( $font, 'name' ),
					'placeholder' => esc_attr__( 'Font name (e.g. Proxima Nova)', 'cakecious-features' ),
					'class'       => 'widefat',
				) ); ?>
				<p class="description"><?php esc_html_e( 'The name of the font as it appears in the typography options.', 'cakecious-features' ); ?></p>
			</div>

			<br>
			<h2><?php esc_html_e( 'Add variants and upload font files', 'cakecious-features' ); ?></h2>

			<div class="cakecious-admin-custom-font-variants">
				<?php
				foreach ( $weights as $weight => $weight_label ) :
					foreach ( array( 'normal', 'italic' ) as $style ) :
						$variant = $weight . '|' . $style;
						?>
						<div class="cakecious-admin-custom-font-variant">
							<input type="checkbox" name="variants" value="<?php echo esc_attr( $variant ); ?>" <?php echo ( in_array( $variant, $font['variants'] ) ? 'checked' : '' ); ?>>
							<div class="postbox">
								<h2 class="hndle"><?php echo ( $weight_label . ' (' . $weight . ')' . ( 'italic' === $style ?  ' ' . esc_html__( 'Italic', 'cakecious-features' ) : '' ) ); ?></h2>
								<div class="inside">
									<ul class="cakecious-admin-font-variant-files">
										<?php foreach ( array( 'woff2', 'woff', 'ttf', 'eot', 'svg' ) as $extension ) : ?>
											<li class="cakecious-admin-font-variant-file">
												<label><?php printf( '.%s', $extension ); ?></label>
												<?php Cakecious_Admin_Fields::render_field( array(
													'name'        => 'file_' . $variant . '_' . $extension,
													'type'        => 'upload',
													'value'       => cakecious_array_value( $font, 'file_' . $variant . '_' . $extension ),
													'class'       => 'widefat',
													'library'     => array( 'application', 'image' ),
													'frame_title' => sprintf( esc_html__( 'Select .%s file', 'cakecious-features' ), $extension ),
												) ); ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
						<?php
					endforeach;
				endforeach;
				?>
			</div>

			<a href="javascript:;" data-repeater-delete type="button" class="cakecious-admin-repeater-control-delete button button-small"><span class="dashicons dashicons-no-alt"></span></a>

		</li>
		<?php
	}

	/**
	 * ====================================================
	 * Sanitization functions
	 * ====================================================
	 */

	/**
	 * Sanitize custom fonts array input.
	 *
	 * @param array $data
	 * @return array
	 */
	public function sanitize_setting__upload_custom_fonts( $data ) {
		$sanitized = array();

		foreach ( $data as $i => $font ) {
			// Skip if font has no name.
			if ( empty( $font['name'] ) ) continue;
			
			// Skip if font has no variants.
			if ( empty( $font['variants'] ) ) continue;

			// Save non-empty value of current font data.
			$array = array();
			foreach ( $font as $key => $value ) {
				if ( '' !== $value ) {
					$array[ $key ] = $value;
				}
			}

			$sanitized[ $font['name'] ] = $array;
		}

		return $sanitized;
	}
}

Cakecious_Pro_Module_Custom_Fonts_Admin::instance();