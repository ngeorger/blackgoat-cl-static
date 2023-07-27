<?php
/**
 * Cakecious Pro module: Blog Layout Plus
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Blog_Layout_Plus extends Cakecious_Pro_Module_Blog {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'blog-layout-plus';

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

		// Template filters
		add_action( 'wp', array( $this, 'init_frontend' ) );
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

		$css .= Cakecious_Customizer::instance()->convert_postmessages_to_css_string( $postmessages );

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
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/blog--archive.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/blog--entry-list.php' );
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
	 * Initialize frontend filters.
	 */
	function init_frontend() {
		/**
		 * ====================================================
		 * Content list hooks
		 * ====================================================
		 */

		// Add featured media.
		if ( 'disabled' !== cakecious_get_theme_mod( 'entry_list_thumbnail' ) ) {
			add_filter( 'cakecious/frontend/loop_classes', array( $this, 'add_loop_list_classes' ) );
			add_action( 'cakecious/frontend/entry_list/media', array( $this, 'entry_list_thumbnail' ), 10 );
			add_filter( 'cakecious/frontend/entry_list/thumbnail_classes', array( $this, 'add_entry_list_thumbnail_classes' ) );
		}

		// Add list entry header elements.
		$priority = 10;
		foreach ( cakecious_get_theme_mod( 'entry_list_header', array() ) as $element ) {
			$function_name = 'entry_list_' . str_replace( '-', '_', $element );

			// If function exists, attach to hook.
			if ( method_exists( $this, $function_name ) ) {
				add_action( 'cakecious/frontend/entry_list/header', array( $this, $function_name ), $priority );
			}

			// Increment priority number.
			$priority = $priority + 10;
		}

		// Add list entry footer elements.
		$priority = 10;
		foreach ( cakecious_get_theme_mod( 'entry_list_footer', array() ) as $element ) {
			$function_name = 'entry_list_' . str_replace( '-', '_', $element );

			// If function exists, attach to hook.
			if ( method_exists( $this, $function_name ) ) {
				add_action( 'cakecious/frontend/entry_list/footer', array( $this, $function_name ), $priority );
			}

			// Increment priority number.
			$priority = $priority + 10;
		}
	}

	/**
	 * Add custom classes to the array of posts loop classes.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_loop_list_classes( $classes ) {
		if ( 'list' === cakecious_get_theme_mod( 'blog_index_loop_mode' ) ) {
			$classes['display'] = esc_attr( 'cakecious-loop-list-thumbnail-position--' . cakecious_get_theme_mod( 'entry_list_thumbnail' ) );
		}

		return $classes;
	}

	/**
	 * Add custom classes to entry list thumbnail.
	 *
	 * @param array $classes
	 * @return array
	 */
	public function add_entry_list_thumbnail_classes( $classes ) {
		if ( intval( cakecious_get_theme_mod( 'entry_list_thumbnail_ignore_padding' ) ) ) {
			$classes['ignore-padding'] = 'cakecious-entry-thumbnail-ignore-padding';
		}

		if ( intval( cakecious_get_theme_mod( 'entry_list_thumbnail_full_height' ) ) ) {
			$classes['full-height'] = 'cakecious-entry-thumbnail-full-height';
		}

		return $classes;
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Print entry list featured media.
	 */
	public function entry_list_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		?>
		<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/entry_list/thumbnail_classes', array( 'entry-thumbnail', 'entry-list-thumbnail' ) ) ) ); ?>">
			<?php the_post_thumbnail(
				get_the_ID(),
				apply_filters( 'cakecious/frontend/entry_list/thumbnail_size', 'medium_large' )
			); ?>
		</a>
		<?php
	}

	/**
	 * Print entry list title.
	 */
	public function entry_list_title() {
		cakecious_entry_small_title();
	}

	/**
	 * Print entry list header meta.
	 */
	public function entry_list_header_meta() {
		cakecious_entry_meta( cakecious_get_theme_mod( 'entry_list_header_meta' ) );
	}

	/**
	 * Print entry list footer meta.
	 */
	public function entry_list_footer_meta() {
		cakecious_entry_meta( cakecious_get_theme_mod( 'entry_list_footer_meta' ) );
	}
}

Cakecious_Pro_Module_Blog_Layout_Plus::instance();