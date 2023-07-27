<?php
/**
 * Cakecious Pro module: Blog Related Posts
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Blog_Related_Posts extends Cakecious_Pro_Module_Blog {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'blog-related-posts';

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
		
		// Customizer settings & values
		add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
		add_filter( 'cakecious/customizer/setting_defaults', array( $this, 'add_customizer_setting_defaults' ) );

		// Frontend
		add_action( 'wp', array( $this, 'init_frontend' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Register customizer sections, settings, and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register_customizer_settings( $wp_customize ) {
		$defaults = Cakecious_Customizer::instance()->get_setting_defaults();

		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/_sections.php' );
		require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/customizer/options/blog--related-posts.php' );
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
	 * Initialize related posts.
	 */
	public function init_frontend() {
		// Abort if current loaded page is not a single blog post page.
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		// Abort if related posts is disabled.
		if ( ! intval( cakecious_get_theme_mod( 'blog_related_posts' ) ) ) {
			return;
		}

		// Insert related posts to selected location.
		switch ( cakecious_get_theme_mod( 'blog_related_posts_position' ) ) {
			case 'before-comments':
				add_action( 'cakecious/frontend/after_main', array( $this, 'render_related_posts' ), 19 );
				break;
			
			case 'after-content':
			default:
				add_action( 'cakecious/frontend/after_main', array( $this, 'render_related_posts' ), 1 );
				break;
		}
	}
	
	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render related posts.
	 */
	public function render_related_posts() {
		$now = time();
		$post_id = get_the_ID();
		$meta = get_post_meta( $post_id, 'cakecious_related_posts', true );

		// Fetch query option values.
		$filters = array(
			'posts_per_page' => cakecious_get_theme_mod( 'blog_related_posts_per_page' ),
			'order' => cakecious_get_theme_mod( 'blog_related_posts_order' ),
			'query' => cakecious_get_theme_mod( 'blog_related_posts_query' ),
			'max_days' => cakecious_get_theme_mod( 'blog_related_posts_max_days' ),
		);

		/**
		 * Use existing cached query
		 */
		if (
			$now < cakecious_array_value( $meta, 'timestamp', 0 ) + ( cakecious_get_theme_mod( 'blog_related_posts_cache_duration' ) * 60 * 60 ) // Check if cache is not expired
			&& build_query( $filters ) === cakecious_array_value( $meta, 'filters', array() ) // Check if filters are still the same
		) {
			$args = array(
				'post__in' => cakecious_array_value( $meta, 'ids', array() ),
			);
		}

		/**
		 * Build new query
		 */
		else {
			// Order
			$order_chunks = explode( '|', $filters['order'] );
			$order_by = cakecious_array_value( $order_chunks, 0, 'date' );
			$order_mode = cakecious_array_value( $order_chunks, 1, 'DESC' );

			// Standard arguments
			$args = array(
				'post__not_in'   => array( $post_id ), // exclude current post
				'posts_per_page' => $filters['posts_per_page'],
				'orderby'        => $order_by,
				'order'          => $order_mode,
			);

			// Tax Query
			$tax_query = array();
			if ( false !== strpos( $filters['query'], '__' ) ) {
				$tax_query['relation'] = preg_replace( '/.*?__/', '', $filters['query'] );
			}
			$taxonomies = explode( '|', preg_replace( '/__.*/', '', $filters['query'] ) );
			foreach ( $taxonomies as $taxonomy ) {
				$terms = get_the_terms( get_the_ID(), $taxonomy );

				if ( is_array( $terms ) && 0 < count( $terms ) ) {
					$terms = wp_list_pluck( $terms, 'slug' );

					$tax_query[] = array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $terms,
					);
				}
			}
			$args['tax_query'] = $tax_query;

			// Date Query
			$date_query = array();
			if ( '' !== trim( $filters['max_days'] ) ) {
				$date_query[] = array(
					'after' => '-' . $max_days . ' day',
				);
			}
			$args['date_query'] = $date_query;

		}

		/**
		 * Run the query and then print
		 */

		// Use global WP_Query.
		global $wp_query;

		// Save current global WP_Query in a temporary variable.
		$main_wp_query = $wp_query;

		// Run custom query.
		$wp_query = new WP_Query( $args );

		// Update cache.
		$meta = array(
			'timestamp' => $now,
			'filters'   => build_query( $filters ),
			'ids'       => wp_list_pluck( $wp_query->posts, 'ID' ),
		);
		update_post_meta( $post_id, 'cakecious_related_posts', $meta );

		// Include the template part.
		if ( have_posts() ) {
			cakecious_get_template_part( 'blog-related-posts' );
		}

		// Revert back the global WP_Query.
		$wp_query = $main_wp_query;
		wp_reset_postdata();
	}
}

Cakecious_Pro_Module_Blog_Related_Posts::instance();