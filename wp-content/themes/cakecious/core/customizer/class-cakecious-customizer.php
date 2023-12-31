<?php
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Customizer {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Customizer
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
	 * @return Cakecious_Customizer
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
		// Google Fonts CSS
		add_action( 'cakecious/frontend/before_enqueue_main_css', array( $this, 'enqueue_frontend_google_fonts_css' ) );

		// Default values, postmessages, contexts
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_setting_postmessages' ) );
		add_filter( 'cakecious/customizer/control_contexts', array( $this, 'add_control_contexts' ) );

		// Customizer page
		add_action( 'customize_register', array( $this, 'register_custom_controls' ), 1 );
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		// add_action( 'customize_register', array( $this, 'move_other_sections' ), 999 ); // priority needs to be higher than 10 because "Menus" section is registered at "11" priority number.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if ( is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_preview_scripts' ) );
			add_action( 'wp_head', array( $this, 'print_preview_styles' ), 20 );
			add_action( 'wp_footer', array( $this, 'print_preview_scripts' ), 20 );
		}
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Enqueue Google Fonts CSS on frontend.
	 */
	public function enqueue_frontend_google_fonts_css() {
		// Customizer Google Fonts
		$google_fonts_url = $this->generate_active_google_fonts_embed_url();
		if ( ! empty( $google_fonts_url ) ) {
			wp_enqueue_style( 'cakecious-google-fonts', $google_fonts_url, array(), CAKECIOUS_VERSION );
		}
	}

	/**
	 * Add default values for all Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $defaults
	 * @return array
	 */
	public function add_setting_defaults( $defaults = array() ) {
		$add = include( CAKECIOUS_INCLUDES_DIR . '/customizer/defaults.php' );

		return array_merge_recursive( $defaults, $add );
	}

	/**
	 * Add postmessage rules for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $postmessages
	 * @return array
	 */
	public function add_setting_postmessages( $postmessages = array() ) {
		$add = include( CAKECIOUS_INCLUDES_DIR . '/customizer/postmessages.php' );

		return array_merge_recursive( $postmessages, $add );
	}

	/**
	 * Add dependency contexts for some Customizer settings.
	 * Triggered via filter to allow modification by users.
	 *
	 * @param array $contexts
	 * @return array
	 */
	public function add_control_contexts( $contexts = array() ) {
		$add = include( CAKECIOUS_INCLUDES_DIR . '/customizer/contexts.php' );

		return array_merge_recursive( $contexts, $add );
	}

	/**
	 * Register custom customizer controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_custom_controls( $wp_customize ) {
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/class-cakecious-customizer-sanitization.php' );

		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-section-spacer.php' );

		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control.php' );

		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-hr.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-heading.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-blank.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-toggle.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-color.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-shadow.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-slider.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-dimension.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-dimensions.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-typography.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-multicheck.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-radioimage.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-background.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-sortable.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/custom-controls/class-cakecious-customize-control-builder.php' );
		}

	/**
	 * Register customizer sections and settings.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_settings( $wp_customize ) {

		/**
		 * Register settings
		 */
		$defaults = $this->get_setting_defaults();

		// Sections and Panels
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/_sections.php' );

		// Global Modules
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/global--social.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/global--breadcrumb.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/global--color-palette.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/global--google-fonts.php' );

		// Typography & Colors
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--base.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--headings.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--blockquote.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--form-inputs.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--buttons.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--title.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--small-title.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/general--meta.php' );

		// Layout
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/canvas.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--builder.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--top-main-bottom-bar.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--mobile-main-bar.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--mobile-vertical-bar.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--logo.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--menu.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--html.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--search.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--cart.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/header--social.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/content--hero.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/content--section.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/content--main.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/content--sidebar.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/footer--builder.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/footer--widgets-bar.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/footer--bottom-bar.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/footer--copyright.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/footer--html.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/footer--social.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/footer--scroll-to-top.php' );

		// Blog
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/blog--archive.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/blog--single.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/blog--entry-default.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/blog--entry-grid.php' );

		// Pages
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/page--single.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/page--error-404.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/page--search.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/cpt--archive.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/cpt--single.php' );
		require_once( CAKECIOUS_INCLUDES_DIR . '/customizer/options/_page-settings.php' );
	}

	/**
	 * Move other sections to the bottom of Customizer panel.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function move_other_sections( $wp_customize ) {
		foreach ( $wp_customize->panels() as $key => $obj ) {
			if ( 160 >= $obj->priority ) {
				$obj->priority = $obj->priority + 1000;
			}
		}

		foreach ( $wp_customize->sections() as $key => $obj ) {
			if ( empty( $obj->panel ) && 160 >= intval( $obj->priority ) ) {
				$obj->priority += 1000;
			}
		}

		$wp_customize->get_section( 'custom_css' )->priority += 1000;
	}

	/**
	 * Enqueue customizer controls scripts & styles.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'cakecious-customize-controls', CAKECIOUS_CSS_URL . '/admin/customize-controls.css', array(), CAKECIOUS_VERSION );
		wp_style_add_data( 'cakecious-customize-controls', 'rtl', 'replace' );
		
		wp_enqueue_script( 'cakecious-customize-controls', CAKECIOUS_JS_URL . '/admin/customize-controls.js', array( 'customize-controls' ), CAKECIOUS_VERSION, true );

		wp_localize_script( 'cakecious-customize-controls', 'cakeciousCustomizerControlsData', array(
			'contexts' => $this->get_control_contexts(),
			'previewContexts' => $this->get_preview_contexts(),
			'headerFooterBuilderStructures' => array(
				'header_elements' => array(
					'vertical' => array(
						'vertical_bar' => array(
							'label'      => esc_html__( 'Vertical Bar', 'cakecious' ),
							'locations'  => array(
								'vertical_top',
								'vertical_middle',
								'vertical_bottom',
							),
						),
					),
					'horizontal' => array(
						'top_bar' => array(
							'label'     => esc_html__( 'Top Bar', 'cakecious' ),
							'locations' => array(
								'top_left',
								'top_center',
								'top_right',
							),
						),
						'main_bar' => array(
							'label'     => esc_html__( 'Main Bar', 'cakecious' ),
							'locations' => array(
								'main_left',
								'main_center',
								'main_right',
							),
						),
						'bottom_bar' => array(
							'label'     => esc_html__( 'Bottom Bar', 'cakecious' ),
							'locations' => array(
								'bottom_left',
								'bottom_center',
								'bottom_right',
							),
						),
					),
				),
				'header_mobile_elements' => array(
					'vertical' => array(
						'mobile_vertical_bar' => array(
							'label'     => esc_html__( 'Mobile Popup', 'cakecious' ),
							'locations' => array(
								'vertical_top',
							),
						),
					),
					'horizontal' => array(
						'mobile_main_bar' => array(
							'label'     => esc_html__( 'Mobile Main Bar', 'cakecious' ),
							'locations' => array(
								'main_left',
								'main_center',
								'main_right',
							),
						),
					),
				),
				'footer_elements' => array(
					'horizontal' => array(
						'bottom_bar' => array(
							'label'     => esc_html__( 'Bottom Bar', 'cakecious' ),
							'locations' => array(
								'bottom_left',
								'bottom_center',
								'bottom_right',
							),
						),
					),
				),
			),
		) );
	}

	/**
	 * Enqueue customizer preview scripts & styles.
	 */
	public function enqueue_preview_scripts() {
		wp_enqueue_script( 'cakecious-customize-preview', CAKECIOUS_JS_URL . '/admin/customize-preview.js', array( 'customize-preview' ), CAKECIOUS_VERSION, true );
		
		wp_localize_script( 'cakecious-customize-preview', 'cakeciousCustomizerPreviewData', array(
			'postMessages' => $this->get_setting_postmessages(),
			'fonts'        => cakecious_get_all_fonts(),
		) );
	}

	/**
	 * Print <style> tags for preview frame.
	 */
	public function print_preview_styles() {
		// Print global preview CSS.
		echo '<style id="cakecious-preview-css" type="text/css">.customize-partial-edit-shortcut button:hover,.customize-partial-edit-shortcut button:focus{border-color: currentColor}</style>' . "\n";

		/**
		 * Print saved theme_mods CSS.
		 */

		$postmessages = $this->get_setting_postmessages();
		$default_values = $this->get_setting_defaults();

		// Loop through each setting.
		foreach ( $postmessages as $key => $rules ) {
			// Get saved value.
			$setting_value = get_theme_mod( $key );

			// Get default value.
			$default_value = cakecious_array_value( $default_values, $key );
			if ( is_null( $default_value ) ) {
				$default_value = '';
			}

			// Temporary CSS array to organize output.
			$css_array = array();

			// Add CSS only if value is not the same as default value and not empty.
			if ( $setting_value !== $default_value && '' !== $setting_value ) {
				foreach ( $rules as $rule ) {
					// Check rule validity, and then skip if it's not valid.
					if ( ! $this->check_postmessage_rule_for_css_compatibility( $rule ) ) {
						continue;
					}

					// Sanitize rule.
					$rule = $this->sanitize_postmessage_rule_value( $rule, $setting_value );

					// Add to CSS array.
					$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
				}
			}

			echo '<style id="cakecious-customize-preview-css-' . $key . '" type="text/css">' . cakecious_convert_css_array_to_string( $css_array ) . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Print <script> tags for preview frame.
	 */
	public function print_preview_scripts() {
		?>
		<script type="text/javascript">
			(function() {
				'use strict';

				document.addEventListener( 'DOMContentLoaded', function() {
					if ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh && wp.customize.widgetsPreview && wp.customize.widgetsPreview.WidgetPartial ) {
						wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
							// Nav Menu
							if ( placement.partial.id.indexOf( 'nav_menu_instance' ) ) {
								window.cakecious.initAll();
							}
						} );
					}
				});
			})();
		</script>
		<?php
	}

	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Build CSS string from Customizer's postmessages.
	 *
	 * @param array $postmessages
	 * @param array $defaults
	 * @return string
	 */
	public function convert_postmessages_to_css_string( $postmessages = array(), $defaults = array() ) {
		$css_array = $this->convert_postmessages_to_css_array( $postmessages, $defaults );

		return cakecious_convert_css_array_to_string( $css_array );
	}

	/**
	 * Convert Customizer's postmessages array to CSS array.
	 *
	 * @param array $postmessages
	 * @param array $defaults
	 * @return string
	 */
	public function convert_postmessages_to_css_array( $postmessages = array(), $defaults = array() ) {
		// Temporary CSS array to organize output.
		// Media groups are defined now, for proper responsive orders.
		$css_array = array(
			'global' => array(),
			'@media screen and (max-width: 1023px)' => array(),
			'@media screen and (max-width: 499px)' => array(),
		);

		// Get saved theme mods as an array.
		$mods = get_theme_mods();
		if ( empty( $mods ) ) {
			$mods = array();
		}

		// Intersect the whole postmessages array with saved theme mods array.
		// This way we can optimize the iteration to only process the existing theme mods.
		$keys = array_intersect( array_keys( $postmessages ), array_keys( $mods ) );

		// Loop through each setting.
		foreach ( $keys as $key ) {
			// Get saved value.
			$setting_value = get_theme_mod( $key );

			// Skip this setting if value is not valid (only accepts string and number).
			if ( ! is_numeric( $setting_value ) && ! is_string( $setting_value ) ) continue;

			// Skip this setting if value is empty string.
			if ( '' === $setting_value ) continue;

			// Skip rule if value === default value.
			if ( $setting_value === cakecious_array_value( $defaults, $key ) ) continue;

			// Loop through each rule.
			foreach ( $postmessages[ $key ] as $rule ) {
				// Check rule validity, and then skip if it's not valid.
				if ( ! $this->check_postmessage_rule_for_css_compatibility( $rule ) ) {
					continue;
				}

				// Sanitize rule.
				$rule = $this->sanitize_postmessage_rule_value( $rule, $setting_value );

				// Add to CSS array.
				$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
			}
		}

		return $css_array;
	}

	/**
	 * Check a postmessage rule and return whether it's valid or not.
	 *
	 * @param array $rule
	 * @return boolean
	 */
	public function check_postmessage_rule_for_css_compatibility( $rule ) {
		// Check if there is no type defined, then return false.
		if ( ! isset( $rule['type'] ) ) return false;

		// Skip rule if it's not CSS related.
		if ( ! in_array( $rule['type'], array( 'css', 'font' ) ) ) return false;

		// Check if no element selector is defined, then return false.
		if ( ! isset( $rule['element'] ) ) return false;

		// Check if no property is defined, then return false.
		if ( ! isset( $rule['property'] ) || empty( $rule['property'] ) ) return false;

		// Passed all checks, return true.
		return true;
	}

	/**
	 * Sanitize a postmessage rule, run rule function, format original setting value and fill it into the rule.
	 *
	 * @param array $rule
	 * @param mixed $setting_value
	 * @return array
	 */
	public function sanitize_postmessage_rule_value( $rule, $setting_value ) {
		// Declare empty array to hold all available fonts.
		// Will be populated later, only when needed.
		$fonts = array();

		// If "media" attribute is not specified, set it to "global".
		if ( ! isset( $rule['media'] ) || empty( $rule['media'] ) ) $rule['media'] = 'global';

		// If "pattern" attribute is not specified, set it to "$".
		if ( ! isset( $rule['pattern'] ) || empty( $rule['pattern'] ) ) $rule['pattern'] = '$';

		// Check if there is function attached.
		if ( isset( $rule['function'] ) && isset( $rule['function']['name'] ) ) {
			// Apply function to the original value.
			switch ( $rule['function']['name'] ) {
				/**
				 * Explode raw value by space (' ') as the delimiter and then return value from the specified index.
				 *
				 * args[0] = index of exploded array to return
				 */
				case 'explode_value':
					if ( ! isset( $rule['function']['args'][0] ) ) break;

					$index = $rule['function']['args'][0];

					if ( ! is_numeric( $index ) ) break;

					$array = explode( ' ', $setting_value );

					$setting_value = isset( $array[ $index ] ) ? $array[ $index ] : '';
					break;

				/**
				 * Scale all dimensions found in the raw value according to the specified scale amount.
				 *
				 * args[0] = scale amount
				 */
				case 'scale_dimensions':
					if ( ! isset( $rule['function']['args'][0] ) ) break;

					$scale = $rule['function']['args'][0];

					if ( ! is_numeric( $scale ) ) break;

					$parts = explode( ' ', $setting_value );
					$new_parts = array();
					foreach ( $parts as $i => $part ) {
						$number = floatval( $part );
						$unit = str_replace( $number, '', $part );

						$new_parts[ $i ] = ( $number * $scale ) . $unit;
					}

					$setting_value = implode( ' ', $new_parts );
					break;
			}
		}

		// Parse value for "font" type.
		if ( 'font' === $rule['type'] ) {
			$chunks = explode( '|', $setting_value );

			if ( 2 === count( $chunks ) ) {
				// Populate $fonts array if haven't.
				if ( empty( $fonts ) ) {
					$fonts = cakecious_get_all_fonts();
				}
				$setting_value = cakecious_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
			}
		}

		// Replace any $ found in the pattern to value.
		$rule['value'] = str_replace( '$', $setting_value, $rule['pattern'] );

		// Replace any $ found in the media screen to value.
		$rule['media'] = str_replace( '$', $setting_value, $rule['media'] );

		return $rule;
	}

	/**
	 * Return all customizer default preset value.
	 *
	 * Fallback function since Cakecious 1.3.0.
	 *
	 * @return array
	 */
	public function get_default_colors() {
		return cakecious_get_default_colors();
	}

	/**
	 * Return all customizer setting postmessages.
	 * 
	 * @return array
	 */
	public function get_setting_postmessages() {
		return apply_filters( 'cakecious/customizer/setting_postmessages', array() );
	}

	/**
	 * Return all customizer setting .
	 * 
	 * @return array
	 */
	public function get_control_contexts() {
		return apply_filters( 'cakecious/customizer/control_contexts', array() );
	}

	/**
	 * Return all customizer setting defaults.
	 * 
	 * @return array
	 */
	public function get_setting_defaults() {
		return apply_filters( 'cakecious/customizer/setting_defaults', array() );
	}

	/**
	 * Return single customizer setting value.
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get_setting_value( $key, $default = null ) {
		$value = get_theme_mod( $key, null );

		// Fallback to defaults array
		if ( is_null( $value ) ) {
			$value = cakecious_array_value( $this->get_setting_defaults(), $key, null );
		}

		// Fallback to default parameter
		if ( is_null( $value ) ) {
			$value = $default;
		}

		$value = apply_filters( 'cakecious/customizer/setting_value', $value, $key );
		$value = apply_filters( 'cakecious/customizer/setting_value/' . $key, $value );

		return $value;
	}

	/**
	 * Return all binding contexts between Customizer's sections and live preview frame.
	 * 
	 * @return array
	 */
	public function get_preview_contexts() {
		$contexts = array();

		// Add "Homepage Settings"
		$contexts['static_front_page'] = esc_url( home_url() ); 

		// Add "404 Page"
		$contexts['cakecious_section_error_404'] = esc_url( home_url( '404' ) );

		// Add "Search Page"	
		$contexts['cakecious_section_search'] = esc_url( home_url( '?s=awesome' ) );

		$contexts = apply_filters( 'cakecious/customizer/preview_contexts', $contexts );

		return $contexts;
	}

	/**
	 * Return all page types for page settings.
	 * 
	 * @return array
	 */
	public function get_all_page_settings_types() {
		// Define sections with default page types.
		$page_sections = array(
			'page_single' => array(
				'section' => 'cakecious_section_page_single',
				'title' => esc_html__( 'Static Page', 'cakecious' ),
			),
			'search_results' => array(
				'section' => 'cakecious_section_search_results',
				'title' => esc_html__( 'Search Results Page', 'cakecious' ),
			),
			'error_404' => array(
				'section' => 'cakecious_section_error_404',
				'title' => esc_html__( 'Error 404 Page', 'cakecious' ),
			),
		);

		// Get post types.
		$post_types = cakecious_get_post_types_for_page_settings();

		foreach ( $post_types as $post_type ) {
			$post_type_obj = get_post_type_object( $post_type );

			switch ( $post_type ) {
				case 'post':
					$section_archive = 'cakecious_section_blog_index';
					$section_single = 'cakecious_section_blog_single';
					break;

				case 'product':
					$section_archive = 'woocommerce_product_catalog';
					$section_single = 'woocommerce_product_single';
					break;
				
				default:
					$section_archive = 'cakecious_section_' . $post_type . '_archive';
					$section_single = 'cakecious_section_' . $post_type . '_single';
					break;
			}

			/**
			 * Define sections.
			 */

			if ( 'page' !== $post_type ) {
				$key_archive = $post_type . '_archive';
				$page_sections[ $key_archive ] = array(
					'section' => $section_archive,
					/* translators: %s: post type's plural name. */
					'title' => sprintf( esc_html__( '%s Archive Page', 'cakecious' ), $post_type_obj->labels->name ),
				);
			}

			$key_single = $post_type . '_single';
			$page_sections[ $key_single ] = array(
				'section' => $section_single,
				/* translators: %s: post type's singular name. */
				'title' => sprintf( esc_html__( 'Single %s Page', 'cakecious' ), $post_type_obj->labels->singular_name ),
			);
		}

		// Sanitize $page_sections.
		foreach ( $page_sections as $ps_type => $ps_data ) {
			$page_sections[ $ps_type ] = wp_parse_args( $ps_data, array(
				'section'     => 'cakecious_section_page_' . $ps_type,
				'title'       => '',
				'description' => '',
			) );
		}

		return $page_sections;
	}
	
	/**
	 * Return all active fonts divided into each provider.
	 * 
	 * @param string $group
	 * @return array
	 */
	public function get_active_fonts( $group = null ) {
		$fonts = array(
			'web_safe_fonts' => array(),
			'custom_fonts' => array(),
			'google_fonts' => array(),
		);

		$count = 0;

		$saved_settings = get_theme_mods();
		if ( empty( $saved_settings ) ) {
			$saved_settings = array();
		}

		// Iterate through the saved customizer settings, to find all font family settings.
		foreach ( $saved_settings as $key => $value ) {
			// Check if this setting is not a font family, then skip this setting.
			if ( false === strpos( $key, '_font_family' ) ) {
				continue;
			}

			// Split value format to [font provider, font name].
			$args = explode( '|', $value );

			// Only add if value format is valid.
			if ( 2 === count( $args ) ) {
				// Add to active fonts list.
				// Make sure it is has not been added before.
				if ( ! in_array( $args[1], $fonts[ $args[0] ] ) ) {
					$fonts[ $args[0] ][] = $args[1];
				}

				// Increment counter.
				$count += 1;
			}
		}

		// Check using the counter, if there is no saved settings about font family, add the default system font as active.
		if ( 0 === $count ) {
			$fonts['web_safe_fonts'][] = 'Default System Font';
		}

		// Return values.
		if ( is_null( $group ) ) {
			return $fonts;
		} else {
			return cakecious_array_value( $fonts, $group, array() );
		}
	}

	/**
	 * Return Google Fonts embed link from Customizer typography options.
	 * 
	 * @return string
	 */
	public function generate_active_google_fonts_embed_url() {
		return cakecious_build_google_fonts_embed_url( $this->get_active_fonts( 'google_fonts' ) );
	}
}

Cakecious_Customizer::instance();