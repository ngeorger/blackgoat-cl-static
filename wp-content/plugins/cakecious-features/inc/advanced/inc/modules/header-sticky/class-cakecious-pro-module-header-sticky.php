<?php
/**
 * Cakecious Pro module: Sticky Header
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Header_Sticky extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'header-sticky';

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

		/**
		 * Frontend
		 */

		add_filter( 'cakecious/frontend/pro_localize_script', array( $this, 'add_localize_script' ) );
		add_filter( 'cakecious/frontend/pro_dynamic_css', array( $this, 'add_dynamic_css' ) );

		add_filter( 'cakecious/frontend/header_' . cakecious_get_theme_mod( 'header_sticky_bar' ) . '_bar_classes', array( $this, 'add_header_sticky_bar_classes' ) );
		add_action( 'cakecious/frontend/logo', array( $this, 'render_header_sticky_logo' ), 20 );

		add_filter( 'cakecious/frontend/header_mobile_main_bar_classes', array( $this, 'add_header_mobile_sticky_bar_classes' ) );
		add_action( 'cakecious/frontend/mobile_logo', array( $this, 'render_header_mobile_sticky_logo' ), 20 );

		/**
		 * Customizer settings & values
		 */

		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );
		add_filter( 'cakecious/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		/**
		 * Individual Page Settings
		 */

		add_action( 'cakecious/admin/metabox/page_settings/fields', array( $this, 'add_metabox_page_settings_fields' ), 10, 2 );
		add_filter( 'cakecious/dataset/fallback_page_settings', array( $this, 'add_fallback_page_settings' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add localize script for frontend Javascript.
	 *
	 * @param string $array
	 * @return string
	 */
	public function add_localize_script( $array ) {
		if ( intval( cakecious_get_current_page_setting( 'header_sticky' ) ) ) {
			$bar = cakecious_get_theme_mod( 'header_sticky_bar' );

			$array['stickyHeader'] = array(
				'bar'             => $bar,
				'normalHeight'    => intval( cakecious_get_theme_mod( 'header_' . $bar . '_bar_height' ) ),
				'stickyHeight'    => min( intval( cakecious_get_theme_mod( 'header_sticky_height' ) ), intval( cakecious_get_theme_mod( 'header_' . $bar . '_bar_height' ) ) ),
				'stickyDisplay'   => cakecious_get_theme_mod( 'header_sticky_display' ),
				'logoNormalWidth' => intval( cakecious_get_theme_mod( 'header_logo_width' ) ),
				'logoStickyWidth' => intval( cakecious_get_theme_mod( 'header_sticky_logo_width', cakecious_get_theme_mod( 'header_logo_width' ) ) ),
				
				'containedWidth'  => intval( cakecious_get_theme_mod( 'container_width' ) ),
			);
		}

		if ( intval( cakecious_get_current_page_setting( 'header_mobile_sticky' ) ) ) {
			$array['stickyMobileHeader'] = array(
				'normalHeight'    => intval( cakecious_get_theme_mod( 'header_mobile_main_bar_height' ) ),
				'stickyHeight'    => min( intval( cakecious_get_theme_mod( 'header_mobile_sticky_height' ) ), intval( cakecious_get_theme_mod( 'header_mobile_main_bar_height' ) ) ),
				'stickyDisplay'   => cakecious_get_theme_mod( 'header_mobile_sticky_display' ),
				'logoNormalWidth' => intval( cakecious_get_theme_mod( 'header_mobile_logo_width' ) ),
				'logoStickyWidth' => intval( cakecious_get_theme_mod( 'header_mobile_sticky_logo_width', cakecious_get_theme_mod( 'header_mobile_logo_width' ) ) ),
			);
		}

		return $array;
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

		$postmessages = include( CAKECIOUS_PRO_DIR . '/inc/modules/' . self::MODULE_SLUG . '/customizer/postmessages.php' );
		$defaults = include( CAKECIOUS_PRO_DIR . '/inc/modules/' . self::MODULE_SLUG . '/customizer/defaults.php' );

		$css .= Cakecious_Customizer::instance()->convert_postmessages_to_css_string( $postmessages, $defaults );

		return $css;
	}

	/**
	 * Add custom classes to the array of sticky header bar classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_header_sticky_bar_classes( $classes ) {
		if ( intval( cakecious_get_current_page_setting( 'header_sticky' ) ) ) {
			$classes['sticky'] = esc_attr( 'cakecious-header-sticky' );
			$classes['sticky_display'] = esc_attr( 'cakecious-header-sticky-display-' . cakecious_get_theme_mod( 'header_sticky_display' ) );
		}

		return $classes;
	}

	/**
	 * Add custom classes to the array of sticky mobile header bar classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_header_mobile_sticky_bar_classes( $classes ) {
		if ( intval( cakecious_get_current_page_setting( 'header_mobile_sticky' ) ) ) {
			$classes['sticky'] = esc_attr( 'cakecious-header-sticky' );
			$classes['sticky_display'] = esc_attr( 'cakecious-header-sticky-display-' . cakecious_get_theme_mod( 'header_mobile_sticky_display' ) );
		}

		return $classes;
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--sticky.php' );
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
			<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Sticky desktop header', 'cakecious-features' ); ?></label></div>
			<div class="cakecious-admin-form-field">
				<?php
				$key = 'header_sticky';
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
			<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Sticky mobile header', 'cakecious-features' ); ?></label></div>
			<div class="cakecious-admin-form-field">
				<?php
				$key = 'header_mobile_sticky';
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
	 * Modify fallback page settings.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function add_fallback_page_settings( $settings ) {
		$settings['header_sticky'] = cakecious_get_theme_mod( 'header_sticky', 0 );
		$settings['header_mobile_sticky'] = cakecious_get_theme_mod( 'header_mobile_sticky', 0 );

		return $settings;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render sticky logo.
	 */
	public function render_header_sticky_logo() {
		?>
		<span class="cakecious-sticky-logo cakecious-logo"><?php cakecious_logo( cakecious_get_theme_mod( 'custom_logo_sticky', cakecious_get_theme_mod( 'custom_logo' ) ) ); ?></span>
		<?php
	}

	/**
	 * Render sticky mobile logo.
	 */
	public function render_header_mobile_sticky_logo() {
		?>
		<span class="cakecious-sticky-logo cakecious-logo"><?php cakecious_logo( cakecious_get_theme_mod( 'custom_logo_mobile_sticky', cakecious_get_theme_mod( 'custom_logo_mobile' ) ) ); ?></span>
		<?php
	}
}

Cakecious_Pro_Module_Header_Sticky::instance();