<?php
/**
 * Cakecious Pro module: Blog Featured Posts
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Blog_Featured_Posts extends Cakecious_Pro_Module_Blog {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'blog-featured-posts';

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

		add_action( 'pre_get_posts', array( $this, 'init_frontend' ) );
		add_action( 'cakecious/frontend/pro_localize_script', array( $this, 'add_localize_script' ) );
		add_filter( 'cakecious/frontend/pro_dynamic_css', array( $this, 'add_dynamic_css' ) );
		
		/**
		 * Customizer settings & values
		 */

		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );
		add_filter( 'cakecious/customizer/setting_postmessages', array( $this, 'add_customizer_setting_postmessages' ) );
		add_filter( 'cakecious/customizer/control_contexts', array( $this, 'add_customizer_control_contexts' ) );

		/**
		 * Admin page
		 */

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
	 * Initialize featured posts.
	 */
	public function init_frontend( $wp_query ) {
		/**
		 * Check all conditions.
		 */

		// Abort if current loaded page is not a blog posts index (home) page.
		if ( ! ( $wp_query->is_home() && $wp_query->is_main_query() ) ) {
			return;
		}

		// Abort if featured posts is disabled.
		if ( ! intval( cakecious_get_theme_mod( 'blog_featured_posts' ) ) ) {
			return;
		}

		// Get featured posts IDs.
		$ids = get_option( 'cakecious_featured_posts', array() );

		// Abort if no featured posts IDs found.
		if ( 1 > count( $ids ) ) {
			return;
		}

		/**
		 * Exclude featured posts from main feed.
		 */

		if ( intval( cakecious_get_theme_mod( 'blog_featured_posts_exclude_on_main_query' ) ) ) {
			// Get current "post__not_in".
			$not_in = $wp_query->get( 'post__not_in' );

			// If "post__not_in" is empty or undefined, set it to empty array.
			if ( empty( $not_in ) ) {
				$not_in = array();
			}

			// Merge with featured posts IDs.
			$not_in = array_merge( $ids, $not_in );

			// Assign the merged "post__not_in" into the query.
			$wp_query->set( 'post__not_in', $not_in );
		}

		/**
		 * Add action hook to render the featured posts.
		 */

		switch ( cakecious_get_theme_mod( 'blog_featured_posts_position' ) ) {
			case 'before-content':
				add_action( 'cakecious/frontend/after_header', array( $this, 'render_featured_posts' ) );
				break;

			case 'before-primary-and-sidebar':
			default:
				add_action( 'cakecious/frontend/before_primary_and_sidebar', array( $this, 'render_featured_posts' ) );
				break;
		}

		/**
		 * Add scripts for featured posts.
		 */

		switch ( cakecious_get_theme_mod( 'blog_featured_posts_layout' ) ) {
			case 'slider':
			case 'carousel':
			default:
				add_action( 'cakecious/frontend/before_enqueue_main_css', array( $this, 'enqueue_slider_css' ) );
				add_action( 'cakecious/frontend/before_enqueue_main_js', array( $this, 'enqueue_slider_js' ) );
				break;
		}
	}

	/**
	 * Enqueue slider CSS to frontend.
	 */
	public function enqueue_slider_css() {
		wp_enqueue_style( 'tiny-slider' );
	}

	/**
	 * Enqueue slider JS to frontend.
	 */
	public function enqueue_slider_js() {
		wp_enqueue_script( 'tiny-slider' );
	}

	/**
	 * Add localize script for frontend Javascript.
	 *
	 * @param string $array
	 * @return string
	 */
	public function add_localize_script( $array ) {
		$tns = array();

		$layout = cakecious_get_theme_mod( 'blog_featured_posts_layout' );

		// Slider & Carousel
		if ( in_array( $layout, array( 'slider', 'carousel' ) ) ) {
			$tns['autoplay'] = intval( cakecious_get_theme_mod( 'blog_featured_posts_autoplay' ) ) ? true : false;
			$tns['autoplayTimeout'] = 1000 * floatval( cakecious_get_theme_mod( 'blog_featured_posts_autoplay_delay' ) );
		}

		// Slider
		if ( 'slider' === $layout ) {
			$tns['mode'] = 'gallery';
			$tns['items'] = 1;
		}

		// Carousel
		if ( 'carousel' === $layout ) {
			$tns['mode'] = 'carousel';

			// Mobile
			$tns['items'] = intval( cakecious_get_theme_mod( 'blog_featured_posts_carousel_columns__mobile', cakecious_get_theme_mod( 'blog_featured_posts_carousel_columns', 1 ) ) );

			$tns['responsive'] = array(
				// Tablet
				768 => array(
					'items'  => intval( cakecious_get_theme_mod( 'blog_featured_posts_carousel_columns__tablet', cakecious_get_theme_mod( 'blog_featured_posts_carousel_columns', 2 ) ) ),
				),
				// Desktop
				1024 => array(
					'items'  => intval( cakecious_get_theme_mod( 'blog_featured_posts_carousel_columns', 3 ) ),
				),
			);
		}

		if ( ! empty( $tns ) ) {
			$array['blogFeaturedPosts']['tinySlider'] = $tns;
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
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/blog--featured-posts.php' );
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
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render featured posts.
	 */
	public function render_featured_posts() {
		// Use global WP_Query.
		global $wp_query;

		// Save current global WP_Query in a temporary variable.
		$main_wp_query = $wp_query;

		// Get featured posts layout to determine "posts per page".
		$layout = cakecious_get_theme_mod( 'blog_featured_posts_layout' );

		// Get "posts per page" based on layout.
		if ( 0 === strpos( $layout, 'grid-' ) ) {
			$posts_per_page = intval( str_replace( 'grid-', '', $layout ) );
		} else {
			$posts_per_page = intval( cakecious_get_theme_mod( 'blog_featured_posts_per_page' ) );
		}

		// Get featured posts IDs.
		$ids = get_option( 'cakecious_featured_posts', array() );

		// Run custom query.
		$wp_query = new WP_Query( array(
			'posts_per_page' => $posts_per_page,
			'post__in'       => $ids,
		) );

		// Include the template part.
		if ( have_posts() ) {
			cakecious_get_template_part( 'blog-featured-posts' );
		}

		// Revert back the global WP_Query.
		$wp_query = $main_wp_query;
		wp_reset_postdata();
	}
}

Cakecious_Pro_Module_Blog_Featured_Posts::instance();