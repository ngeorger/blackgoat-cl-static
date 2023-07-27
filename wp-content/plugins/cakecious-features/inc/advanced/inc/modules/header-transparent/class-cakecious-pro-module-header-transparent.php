<?php
/**
 * Cakecious Pro module: Transparent Header
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Header_Transparent extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'header-transparent';

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
		add_filter( 'cakecious/frontend/pro_dynamic_css', array( $this, 'add_dynamic_css' ) );

		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );
		add_filter( 'cakecious/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		// Metabox
		add_action( 'cakecious/admin/metabox/page_settings/fields', array( $this, 'add_metabox_page_settings_fields' ), 10, 2 );

		// Template filters
		add_filter( 'cakecious/frontend/header_classes', array( $this, 'add_header_classes' ) );
		add_filter( 'cakecious/frontend/header_mobile_classes', array( $this, 'add_header_mobile_classes' ) );

		// Page Settings
		add_filter( 'cakecious/dataset/fallback_page_settings', array( $this, 'add_fallback_page_settings' ) );
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
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--transparent.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--alt-colors.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_page-settings.php' );
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
	 * Add dependency contexts for some Customizer settings.
	 *
	 * @param array $contexts
	 * @return array
	 */
	public function add_customizer_control_contexts( $contexts = array() ) {
		$add = include( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/contexts.php' );

		return array_merge_recursive( $contexts, $add );
	}

	/**
	 * Add Page Settings metabox fields.
	 */
	public function add_metabox_page_settings_fields( $obj, $tab ) {
		if ( 'header' !== $tab ) {
			return;
		}

		$option_key = 'cakecious_page_settings';

		if ( is_a( $obj, 'WP_Post' ) ) {
			$values = get_post_meta( $obj->ID, '_' . $option_key, true );
		} elseif ( is_a( $obj, 'WP_Term' ) ) {
			$values = get_term_meta( $obj->term_id, $option_key, true );
		} else {
			$values = array();
		}

		?>
		<div class="cakecious-admin-form-row">
			<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Transparent desktop header', 'cakecious-features' ); ?></label></div>
			<div class="cakecious-admin-form-field">
				<?php
				$key = 'header_transparent';
				Cakecious_Admin_Fields::render_field( array(
					'name'        => $option_key . '[' . $key . ']',
					'type'        => 'select',
					'choices'     => array(
						''  => esc_html__( '(Customizer)', 'cakecious-features' ),
						'0' => esc_html__( 'No', 'cakecious-features' ),
						'1' => esc_html__( 'Yes', 'cakecious-features' ),
					),
					'value'       => cakecious_array_value( $values, $key ),
				) );
				?>
			</div>
		</div>

		<div class="cakecious-admin-form-row">
			<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Transparent mobile header', 'cakecious-features' ); ?></label></div>
			<div class="cakecious-admin-form-field">
				<?php
				$key = 'header_mobile_transparent';
				Cakecious_Admin_Fields::render_field( array(
					'name'        => $option_key . '[' . $key . ']',
					'type'        => 'select',
					'choices'     => array(
						''  => esc_html__( '(Customizer)', 'cakecious-features' ),
						'0' => esc_html__( 'No', 'cakecious-features' ),
						'1' => esc_html__( 'Yes', 'cakecious-features' ),
					),
					'value'       => cakecious_array_value( $values, $key ),
				) );
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Add custom classes to the array of main header classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_header_classes( $classes ) {
		if ( intval( cakecious_get_current_page_setting( 'header_transparent' ) ) ) {
			$classes['transparent'] = esc_attr( 'cakecious-header-main-transparent cakecious-header-transparent' );
		}

		return $classes;
	}

	/**
	 * Add custom classes to the array of mobile header classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_header_mobile_classes( $classes ) {
		if ( intval( cakecious_get_current_page_setting( 'header_mobile_transparent' ) ) ) {
			$classes['transparent'] = esc_attr( 'cakecious-header-mobile-transparent cakecious-header-transparent' );
		}

		return $classes;
	}

	/**
	 * Modify fallback page settings.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_fallback_page_settings( $settings ) {
		$settings['header_transparent'] = cakecious_get_theme_mod( 'header_transparent', 0 );
		$settings['header_mobile_transparent'] = cakecious_get_theme_mod( 'header_mobile_transparent', 0 );

		return $settings;
	}
}

Cakecious_Pro_Module_Header_Transparent::instance();