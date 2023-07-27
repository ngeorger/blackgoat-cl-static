<?php
/**
 * Cakecious Pro module: Header Mega Menu
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Header_Mega_Menu extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'header-mega-menu';

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

		// Mega Menu implementation
		add_filter( 'walker_nav_menu_start_el', array( $this, 'implement_mega_menu_items_start_el' ), 10, 4 );
		add_filter( 'nav_menu_css_class', array( $this, 'implement_mega_menu_items_class' ), 10, 4 );

		// Admin page
		if ( is_admin() ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/class-cakecious-pro-module-' . self::MODULE_SLUG . '-admin.php' );
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
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/header--mega-menu.php' );
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
	 * Modify mega menu items' HTML markup (both 1st and 2nd level).
	 *
	 * @param string $item_output
	 * @param WP_Post $item
	 * @param integer $depth
	 * @param stdClass $args
	 * @return string
	 */
	public function implement_mega_menu_items_start_el( $item_output, $item, $depth, $args ) {
		// Abort if nav menu location doesn't support mega menu.
		if ( ! in_array( $args->theme_location, $this->_get_supported_nav_menu_locations() ) ) {
			return $item_output;
		}

		/**
		 * 1st level menu item.
		 */
		if ( 0 === $depth ) {
			$mega_menu_data = get_post_meta( $item->ID, '_menu_item_cakecious_mega_menu_settings', true );

			// Return original HTML markup if menu item is not a mega menu.
			if ( 0 === intval( cakecious_array_value( $mega_menu_data, 'enabled' ) ) ) {
				return $item_output;
			}

			/**
			 * Add custom CSS for custom width.
			 */

			if ( 'custom' === cakecious_array_value( $mega_menu_data, 'size' ) ) {
				$custom_width = cakecious_array_value( $mega_menu_data, 'custom_width' );

				if ( ! empty( $custom_width ) ) {
					$item_output .= '<style type="text/css">';
					$item_output .= cakecious_minify_css_string( '.cakecious-header-section .cakecious-header-menu > .menu > .cakecious-mega-menu.menu-item-' . $item->ID . ' > .sub-menu { width:' . $custom_width . 'px; }' );
					$item_output .= '</style>';
				}
			}
		}

		/**
		 * 2nd level menu item.
		 */
		elseif ( 1 === $depth ) {
			// Return original HTML markup if menu item is not inside a mega menu.
			if ( ! $this->_is_sub_menu_item_inside_mega_menu( $item ) ) {
				return $item_output;
			}

			$mega_menu_data = get_post_meta( $item->ID, '_menu_item_cakecious_mega_menu_sub_settings', true );

			/**
			 * Generate inline CSS.
			 */

			$css = array();

			// Column width
			$column_width = cakecious_array_value( $mega_menu_data, 'column_width' );
			if ( ! empty( $column_width ) ) {
				$css['global'][ '.cakecious-header-section .cakecious-header-menu > .menu > .cakecious-mega-menu > .sub-menu > .menu-item-' . $item->ID ]['flex'] = '0 0 ' . $column_width . '%';
			}

			// Disable padding
			if ( intval( cakecious_array_value( $mega_menu_data, 'disable_padding' ) ) ) {
				$css['global'][ '.cakecious-header-section .cakecious-header-menu > .menu > .cakecious-mega-menu > .sub-menu > .menu-item-' . $item->ID ]['padding'] = 0;
			}

			/**
			 * Add inline CSS.
			 */

			if ( ! empty( $css ) ) {
				$item_output .= '<style type="text/css">';
				$item_output .= cakecious_convert_css_array_to_string( $css );
				$item_output .= '</style>';
			}

			/**
			 * Hide Label and disable link.
			 */

			$hide_label = cakecious_array_value( $mega_menu_data, 'hide_label' );
			$disable_label_link = cakecious_array_value( $mega_menu_data, 'disable_label_link' );

			if ( ! empty( $hide_label ) ) {
				$title = apply_filters( 'the_title', $item->title, $item->ID );
				$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

				$item_output = preg_replace( '/<a (.|\t|\n|\r)*?<\/a>/', '<span class="screen-reader-text">' . $title . '</span>', $item_output );
			}

			elseif ( ! empty( $disable_label_link ) ) {
				$title = apply_filters( 'the_title', $item->title, $item->ID );
				$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

				$item_output = preg_replace( '/<a (.|\t|\n|\r)*?<\/a>/', '<span class="cakecious-menu-item-link">' . $title . '</span>', $item_output );
			}

			/**
			 * Print custom content (if specified).
			 */

			$custom_content = cakecious_array_value( $mega_menu_data, 'custom_content' );

			if ( ! empty( $custom_content ) ) {
				$custom_content = do_shortcode( $custom_content );

				$item_output .= '<div class="cakecious-mega-menu-column-content">' . $custom_content . '</div>';
			}
		}

		return $item_output;
	}

	/**
	 * Modify mega menu items' class (both 1st and 2nd level).
	 *
	 * @param string $item_output
	 * @param WP_Post $item
	 * @param stdClass $args
	 * @param integer $depth
	 * @return string
	 */
	public function implement_mega_menu_items_class( $classes, $item, $args, $depth ) {
		if ( ! in_array( $args->theme_location, $this->_get_supported_nav_menu_locations() ) ) {
			return $classes;
		}

		if ( 0 === $depth ) {
			$mega_menu_data = get_post_meta( $item->ID, '_menu_item_cakecious_mega_menu_settings', true );

			// Mega menu class
			if ( intval( cakecious_array_value( $mega_menu_data, 'enabled' ) ) ) {
				$classes[] = esc_attr( 'cakecious-mega-menu' );

				// Mega menu full width
				if ( 'full-width' === cakecious_array_value( $mega_menu_data, 'size', '' ) ) {
					$classes[] = esc_attr( 'cakecious-mega-menu-full-width' );
				}
			}
		}

		elseif ( 1 === $depth ) {
			// Return original HTML markup if menu item is not inside a mega menu.
			if ( ! $this->_is_sub_menu_item_inside_mega_menu( $item ) ) {
				return $classes;
			}

			// Mega menu column class
			$classes[] = esc_attr( 'cakecious-mega-menu-column' );
		}

		return $classes;
	}
	
	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Get supported.
	 *
	 * @param string $item_output
	 * @param WP_Post $item
	 * @param stdClass $args
	 * @param integer $depth
	 * @return string
	 */
	private function _get_supported_nav_menu_locations() {
		return array(
			'header-menu-1',
			'header-menu-2',
			'header-menu-3',
		);
	}

	private function _is_sub_menu_item_inside_mega_menu( $item ) {
		$item_parent_id = intval( get_post_meta( $item->ID, '_menu_item_menu_item_parent', true ) );

		// Return false if it is a 1st level menu item.
		if ( 0 === $item_parent_id ) {
			return false;
		}

		// Return false if the parent item is not a 1st level menu item.
		if ( 0 !== intval( get_post_meta( $item_parent_id, '_menu_item_menu_item_parent', true ) ) ) {
			return false;
		}

		$parent_mega_menu_data = get_post_meta( $item_parent_id, '_menu_item_cakecious_mega_menu_settings', true );

		// If parent item has not enabled mega menu mode.
		if ( 1 !== intval( cakecious_array_value( $parent_mega_menu_data, 'enabled' ) ) ) {
			return false;
		}

		return true;
	}
}

Cakecious_Pro_Module_Header_Mega_Menu::instance();