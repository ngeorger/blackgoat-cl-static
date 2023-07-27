<?php
/**
 * Cakecious Pro module: Preloader Screen
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Preloader_Screen extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'preloader-screen';

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
		add_action( 'cakecious/frontend/before_canvas', array( $this, 'render_preloader' ), 0 );

		// Page Settings
		add_filter( 'cakecious/dataset/fallback_page_settings', array( $this, 'add_fallback_page_settings' ) );

		// Customizer Preview scripts
		if ( is_customize_preview() ) {
			add_action( 'wp_print_footer_scripts', array( $this, 'add_customizer_preview_scripts' ), 99 );
		}
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
	 * Add custom javascripts and CSS on Customer preview for preloader screen features.
	 */
	public function add_customizer_preview_scripts() {
		?>
		<script type="text/javascript">
			(function( exports, $ ) {
				'use strict';

				var $window = $( window ),
				    $document = $( document ),
				    $body = $( 'body' );

				/**
				 * API on preview-ready event handlers
				 *
				 * All handlers need to be inside the 'preview-ready' state.
				 */
				wp.customize.bind( 'preview-ready', function() {
					/**
					 * Preloader Screen preview
					 */
					wp.customize.preview.bind( 'active', function() {
						wp.customize.preview.send( 'preloader-screen-preview' );
					} );
				});

			})( wp, jQuery );
		</script>
		<style type="text/css">
			@-webkit-keyframes cakecious-preloader-screen-preview-pace {
				0% {
					-webkit-transform: translate3d(0, 0, 0);
					transform: translate3d(0, 0, 0);
				}
				100% {
					-webkit-transform: translate3d(100%, 0, 0);
					transform: translate3d(100%, 0, 0);
				}
			}
			@keyframes cakecious-preloader-screen-preview-pace {
				0% {
					-webkit-transform: translate3d(0, 0, 0);
					transform: translate3d(0, 0, 0);
				}
				100% {
					-webkit-transform: translate3d(100%, 0, 0);
					transform: translate3d(100%, 0, 0);
				}
			}
			.cakecious-preloader-screen-preview .cakecious-preloader ~ * {
				opacity: 0;
			}
			.cakecious-preloader-screen-preview .cakecious-preloader .pace-progress {
				-webkit-animation: cakecious-preloader-screen-preview-pace 3s infinite ease-in-out;
				animation: cakecious-preloader-screen-preview-pace 3s infinite ease-in-out;
			}
			.cakecious-preloader-screen-preview .cakecious-preloader .customize-partial-edit-shortcut {
				display: none;
			}
		</style>
		<?php
	}

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/preloader-screen.php' );
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
		if ( 'preloader-screen' !== $tab ) {
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
			<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Preloader Screen', 'cakecious-features' ); ?></label></div>
			<div class="cakecious-admin-form-field">
				<?php
				$key = 'preloader_screen';
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
		$settings['preloader_screen'] = cakecious_get_theme_mod( 'preloader_screen', 0 );

		return $settings;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render preloader screen HTML tags on frontend (if enabled).
	 */
	public function render_preloader() {
		// Abort if preloader is deactivated.
		if ( 0 === intval( cakecious_get_current_page_setting( 'preloader_screen' ) ) ) {
			return;
		}

		// Abort if it's 404 page.
		if ( is_404() ) {
			return;
		}

		$type = cakecious_get_theme_mod( 'preloader_screen_type' );
		?>
		<div id="preloader" class="cakecious-preloader" data-type="<?php echo esc_attr( $type ); ?>">
			<?php switch ( $type ) {
				case 'progress-image':
				case 'progress-bar':
					$pace_args = array(
						'target'   => '#preloader .cakecious-preloader-pace',
						'ajax'     => false,
						'document' => false,
						'eventLag' => false,
					);

					if ( 'progress-image' === $type ) : ?>
						<?php
						$image_id = cakecious_get_theme_mod( 'preloader_screen_progress_image', 0 );
						$image_url = wp_get_attachment_url( $image_id );
						$image_path = get_attached_file( $image_id );

						if ( empty( $image_url ) ) {
							break;
						}

						$type = pathinfo( $image_url, PATHINFO_EXTENSION );
						if ( 'svg' === $type ) {
							$src = 'data:image/svg+xml;base64,' . base64_encode( trim( cakecious_inline_svg( $image_path, false ) ) );
						} else {
							$src = 'data:image/' . $type . ';base64,' . base64_encode( file_get_contents( $image_path ) );
						}
						?>
						<div class="cakecious-preloader-progress-image cakecious-preloader-pace">
							<img src="<?php echo esc_attr( $src ); ?>" width="auto" height="auto" alt="image">
						</div>
					<?php else: ?>
						<div class="cakecious-preloader-progress-bar cakecious-preloader-pace">
							<div class="cakecious-preloader-progress-bar-track"></div>
						</div>
					<?php endif; ?>

					<script type="text/javascript" src="<?php echo esc_url( CAKECIOUS_PRO_URI . 'assets/js/vendors/pace' . CAKECIOUS_ASSETS_SUFFIX . '.js' ); ?>" data-pace-options="<?php echo esc_attr( json_encode( $pace_args ) ); ?>"></script>
					<script type="text/javascript">
						(function() {
							Pace.on( 'hide', function() {
								document.querySelector( '.cakecious-preloader' ).classList.add( 'cakecious-loaded' );
							});
							Pace.on( 'start', function() {
	 							var fixPace99Bug = setInterval(function() {
	 								var $pace = document.querySelector( '.cakecious-preloader .pace-progress' ),
	 								    progress = $pace.getAttribute( 'data-progress' );

									if ( '99' === progress ) {
										clearInterval( fixPace99Bug );
										Pace.stop();
									}
								}, 100 );
							});
						})();
					</script>
					<?php
					break;

				case 'css-spinner':
				default:
					$spinner_key = cakecious_get_theme_mod( 'preloader_screen_css_spinner' );
					?>
					<div class="cakecious-preloader-css-spinner">
						<?php Cakecious_Helper_CSS_Spinner::render( $spinner_key ); ?>
					</div>
					
					<script type="text/javascript">
						(function() {
							window.addEventListener( 'load', function( event ) {
								document.querySelector( '.cakecious-preloader' ).classList.add( 'cakecious-loaded' );
							});
						})();
					</script>
					<?php
					break;
			} ?>
		</div>
		<?php
	}

}

Cakecious_Pro_Module_Preloader_Screen::instance();