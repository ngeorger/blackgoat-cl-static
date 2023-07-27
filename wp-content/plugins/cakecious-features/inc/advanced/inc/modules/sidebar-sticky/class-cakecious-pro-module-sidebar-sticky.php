<?php
/**
 * Cakecious Pro module: Sticky Sidebar
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Sidebar_Sticky extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'sidebar-sticky';

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
		add_filter( 'cakecious/frontend/sidebar_classes', array( $this, 'add_sidebar_classes' ) );

		/**
		 * Customizer settings & values
		 */

		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );

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
		if ( intval( cakecious_get_current_page_setting( 'sidebar_sticky' ) ) ) {
			$array['stickySidebar'] = array(
				'spacingTop'    => cakecious_get_theme_mod( 'sidebar_sticky_spacing_top' ),
				'spacingBottom' => cakecious_get_theme_mod( 'sidebar_sticky_spacing_bottom' ),
				'anchor'        => cakecious_get_theme_mod( 'sidebar_sticky_anchor' ),
			);
		}

		return $array;
	}

	/**
	 * Add custom classes to the array of sidebar classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_sidebar_classes( $classes ) {
		if ( intval( cakecious_get_current_page_setting( 'sidebar_sticky' ) ) ) {
			$classes['sticky-sidebar'] = esc_attr( 'cakecious-sidebar-sticky' );
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
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/content--sidebar-sticky.php' );
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
	 * Add Page Settings metabox fields.
	 */
	public function add_metabox_page_settings_fields( $obj, $tab ) {
		if ( 'content' !== $tab ) {
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
			<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Sticky sidebar', 'cakecious-features' ); ?></label></div>
			<div class="cakecious-admin-form-field">
				<?php
				$key = 'sticky_sidebar';
				Cakecious_Admin_Fields::render_field( array(
					'name'        => $option_key . '[' . $key . ']',
					'type'        => 'select',
					'choices'     => array(
						''  => esc_html__( '(Customizer)', 'cakecious-features' ),
						'0' => esc_html__( '&#x2718; No', 'cakecious-features' ),
						'1' => esc_html__( '&#x2714; Yes', 'cakecious-features' ),
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
		$settings['sidebar_sticky'] = cakecious_get_theme_mod( 'sidebar_sticky', 0 );

		return $settings;
	}
}

Cakecious_Pro_Module_Sidebar_Sticky::instance();