<?php
/**
 * Cakecious Pro module: Custom Blocks (Hooks)
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Custom_Blocks extends Cakecious_Pro_Module {

	/**
	 * Module name
	 *
	 * @var string
	 */
	const MODULE_SLUG = 'custom-blocks';

	/**
	 * Post type slug
	 *
	 * @var string
	 */
	const POST_TYPE = 'cakecious_block';

	/**
	 * Array of active custom blocks on current loaded page.
	 *
	 * @var array
	 */
	private $rendered_custom_blocks = array();

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
		
		// Custom blocks post type
		add_action( 'init', array( $this, 'register_post_type' ) );

		// Frontend
		add_action( 'wp', array( $this, 'fetch_blocks_to_frontend' ), 999 );
		add_action( 'wp', array( $this, 'prevent_frontend_view_for_non_logged_in_users' ) );
		add_filter( 'single_template', array( $this, 'redirect_single_template' ) );

		// Shortcode
		add_shortcode( self::POST_TYPE, array( $this, 'shortcode' ) );

		// Admin page
		if ( is_admin() ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/class-cakecious-pro-module-' . self::MODULE_SLUG . '-admin.php' );
		} elseif ( is_admin_bar_showing() ) {
			// Force WP Admin Bar to rendered on wp_footer not wp_body_open.
			remove_action( 'wp_body_open', 'wp_admin_bar_render', 0 );
			
			// Setup Toolbar.
			add_action( 'admin_bar_menu', array( $this, 'add_toolbar_menu' ), 80 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_toolbar_style' ) );
		}
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Register custom post type.
	 */
	public function register_post_type() {
		/**
		 * Register the custom post type.
		 */
		register_post_type( self::POST_TYPE, array(
			'labels'              => array(
				'name'                  => esc_html_x( 'Blocks', 'Post type general name', 'cakecious-features' ),
				'singular_name'         => esc_html_x( 'Block', 'Post type singular name', 'cakecious-features' ),
				'menu_name'             => esc_html_x( 'Blocks', 'Admin Menu text', 'cakecious-features' ),
				'name_admin_bar'        => esc_html_x( 'Block', 'Add New on Toolbar', 'cakecious-features' ),
				'add_new'               => esc_html__( 'Add New', 'cakecious-features' ),
				'add_new_item'          => esc_html__( 'Add New Block', 'cakecious-features' ),
				'new_item'              => esc_html__( 'New Block', 'cakecious-features' ),
				'edit_item'             => esc_html__( 'Edit Block', 'cakecious-features' ),
				'view_item'             => esc_html__( 'View Block', 'cakecious-features' ),
				'all_items'             => esc_html__( 'All Blocks', 'cakecious-features' ),
				'search_items'          => esc_html__( 'Search Blocks', 'cakecious-features' ),
				'parent_item_colon'     => esc_html__( 'Parent Blocks:', 'cakecious-features' ),
				'not_found'             => esc_html__( 'No Block found.', 'cakecious-features' ),
				'not_found_in_trash'    => esc_html__( 'No Block found in Trash.', 'cakecious-features' ),
				'featured_image'        => esc_html_x( 'Block Cover Image', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'cakecious-features' ),
				'set_featured_image'    => esc_html_x( 'Set cover image', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'cakecious-features' ),
				'remove_featured_image' => esc_html_x( 'Remove cover image', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'cakecious-features' ),
				'use_featured_image'    => esc_html_x( 'Use as cover image', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.3', 'cakecious-features' ),
				'archives'              => esc_html_x( 'Block archives', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'cakecious-features' ),
				'insert_into_item'      => esc_html_x( 'Insert into Block', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'cakecious-features' ),
				'uploaded_to_this_item' => esc_html_x( 'Uploaded to this Block', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'cakecious-features' ),
				'filter_items_list'     => esc_html_x( 'Filter Block list', 'Screen reader text for the filter links heading on the post type listing screen. Default "Filter posts list"/"Filter pages list". Added in 4.4', 'cakecious-features' ),
				'items_list_navigation' => esc_html_x( 'Blocks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default "Posts list navigation"/"Pages list navigation". Added in 4.4', 'cakecious-features' ),
				'items_list'            => esc_html_x( 'Blocks list', 'Screen reader text for the items list heading on the post type listing screen. Default "Posts list"/"Pages list". Added in 4.4', 'cakecious-features' ),
			),
			'public'              => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'rewrite'             => false,
			'supports'            => array( 'title', 'editor' ),
			'show_in_rest'        => true,
		) );

		/**
		 * Set Custom Blocks as one of the page builders' default supported post types.
		 */

		// Elementor
		add_post_type_support( self::POST_TYPE, 'elementor' );

		// Brizy
		add_filter( 'brizy_supported_post_types', function( $post_types ) {
			$post_types[] = self::POST_TYPE;

			return $post_types;
		});
	}

	/**
	 * Fetch blocks attached to current page's hooks.
	 */
	public function fetch_blocks_to_frontend() {
		if ( is_admin() || is_singular( self::POST_TYPE ) ) return;

		// Iterate through each content block.
		// Check each display rules and attached hook.
		$all_blocks = get_posts( array(
			'post_type' => self::POST_TYPE,
			'posts_per_page' => -1,
		) );
		foreach ( $all_blocks as $block ) {
			if ( $this->check_block_status_on_current_page( $block ) ) {
				$settings = $this->get_block_settings( $block );

				// Get hook action.
				$hook_action = $settings['hook_action'];

				// Skip this block if no attached hook action specified.
				if ( empty( $hook_action ) ) {
					continue;
				}

				// More procedure for some specific actions.
				switch ( $hook_action ) {
					case 'custom':
						$hook_action = $settings['hook_action_custom'];
						break;

					case 'cakecious/frontend/header':
						// Remove actions from original Cakecious theme.
						remove_action( 'cakecious/frontend/header', 'cakecious_main_header' );
						remove_action( 'cakecious/frontend/header', 'cakecious_mobile_header' );
						remove_action( 'cakecious/frontend/before_canvas', 'cakecious_mobile_vertical_header' );

						// Remove actions from original Cakecious Pro modules.
						if ( class_exists( 'Cakecious_Pro_Module_Header_Vertical' ) ) {
							remove_action( 'cakecious/frontend/before_canvas', array( Cakecious_Pro_Module_Header_Vertical::instance(), 'render_vertical_header' ) );
						}
						break;

					case 'cakecious/frontend/footer':
						// Remove actions from original Cakecious Pro modules.
						remove_action( 'cakecious/frontend/footer', 'cakecious_main_footer' );
						break;
				}

				// Add this content block to the attached action.
				add_action( $hook_action, function() use( $block, $hook_action ) {
					$this->render_block( $block, $hook_action );
				}, $settings['hook_priority'] );

				// Add scripts of this content block.
				$this->enqueue_block_scripts( $block );
			}
		}
	}

	/**
	 * Don't display cakecious_block post type on frontend.
	 */
	public function prevent_frontend_view_for_non_logged_in_users() {
		if ( is_singular( self::POST_TYPE ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * Change single post template.
	 *
	 * @param  string $template
	 * @return string
	 */
	public function redirect_single_template( $template ) {
		global $post;

		if ( self::POST_TYPE === $post->post_type ) {
			$template = CAKECIOUS_PRO_DIR . 'inc/modules/' . self::MODULE_SLUG . '/template.php';
		}

		return $template;
	}

	/**
	 * Add active custom blocks list to toolbar menu.
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 */
	public function add_toolbar_menu( $wp_admin_bar ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$slug = 'cakecious-custom-blocks';

		$wp_admin_bar->add_node( array(
			'id'     => $slug,
			'title'  => esc_html__( 'Cakecious Custom Blocks', 'cakecious-features' ),
		) );

		if ( 0 < count( $this->rendered_custom_blocks ) ) {
			foreach ( $this->rendered_custom_blocks as $item ) {
				$wp_admin_bar->add_node( array(
					'id'     => $slug . '--' . $item['id'],
					'parent' => $slug,
					'title'  => '<span class="cakecious-toolbar-custom-block-title">' . $item['title'] . '</span><span class="cakecious-toolbar-custom-block-meta">' . $item['hook'] . '</span>',
					'href'   => esc_url( add_query_arg( array( 'post' => $item['id'], 'action' => 'edit' ), admin_url( 'post.php' ) ) ),
				) );
			}
		} else {
			$wp_admin_bar->add_node( array(
				'id'     => $slug . '--empty',
				'parent' => $slug,
				'title'  => '<span class="cakecious-toolbar-custom-block-meta">' . esc_html__( 'No Custom Block attached on this page.', 'cakecious-features' ) . '</span>',
			) );
		}
	}

	/**
	 * Add style for active custom blocks list on toolbar menu.
	 */
	public function add_toolbar_style() {
		$css = '
		#wpadminbar #wp-admin-bar-cakecious-custom-blocks > .ab-item:before {
			content: "\f180";
			top: 2px;
		}

		#wpadminbar #wp-admin-bar-cakecious-custom-blocks .ab-submenu {
			white-space: nowrap;
		}

		#wpadminbar #wp-admin-bar-cakecious-custom-blocks .ab-submenu .ab-item {
			height: auto;
			padding: 5px 10px;
		}

		#wpadminbar #wp-admin-bar-cakecious-custom-blocks .cakecious-toolbar-custom-block-title {
			display: block;
			font-size: inherit;
			line-height: 20px;
		}

		#wpadminbar #wp-admin-bar-cakecious-custom-blocks .cakecious-toolbar-custom-block-meta {
			display: block;
			font-size: 11px;
			font-style: italic;
			line-height: 14px;
			opacity: 0.5;
		}
		';
		wp_add_inline_style( 'admin-bar', cakecious_minify_css_string( $css ) );
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render shortcode.
	 *
	 * @param array $args
	 * @return string
	 */
	public function shortcode( $args ) {
		$args = shortcode_atts( array(
			'id' => 0,
		), $args, self::POST_TYPE );

		if ( empty( $args['id'] ) ) {
			return;
		}

		if ( ! $this->check_block_status_on_current_page( $args['id'] ) ) {
			return;
		}

		// Render the custom block.
		ob_start();
		$this->render_block( $args['id'] );
		return ob_get_clean();
	}

	/**
	 * Enqueue custom block scripts.
	 *
	 * @param integer|WP_Post $block
	 */
	public function enqueue_block_scripts( $block ) {
		if ( ! is_a( $block, 'WP_Post' ) ) {
			$block = get_post( $block );
		}

		// Abort if there is no block with specified ID were found.
		if ( empty( $block ) ) {
			return;
		}

		// Abort if block is not yet published.
		if ( 'publish' !== get_post_status( $block ) ) {
			return;
		}

		// Get the editor/builder.
		$builder = $this->get_block_builder( $block );

		/**
		 * Get block scripts based on its editor/builder.
		 */

		switch ( $builder ) {
			case 'elementor':
				add_action( 'wp_enqueue_scripts', function() {
					// Enqueue Elementor scripts.
					\Elementor\Plugin::instance()->frontend->enqueue_styles();

					// Enqueue Elementor Pro scripts.
					if ( class_exists( '\ElementorPro\Plugin' ) ) {
						\ElementorPro\Plugin::instance()->enqueue_styles();
					}

					// Enqueue current page scripts.
					if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
						$css_file = new \Elementor\Core\Files\CSS\Post( $block->ID );
					} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
						$css_file = new \Elementor\Post_CSS_File( $block->ID );
					}
					$css_file->enqueue();
				});
				break;

			case 'brizy':
				$brizy_post   = Brizy_Editor_Post::get( $block->ID );
				$brizy_public = Brizy_Public_Main::get( $brizy_post );
				
				// Enqueue general Brizy scripts.
				add_filter( 'body_class', array( $brizy_public, 'body_class_frontend' ) );
				add_action( 'wp_enqueue_scripts', array( $brizy_public, '_action_enqueue_preview_assets' ), 9999 );

				// Enqueue current page scripts.
				add_action( 'wp_head', function() use ( $brizy_post ) {
					$brizy_project = Brizy_Editor_Project::get();
					$brizy_html    = new Brizy_Editor_CompiledHtml( $brizy_post->get_compiled_html() );

					echo apply_filters( 'brizy_content', $brizy_html->get_head(), $brizy_project, $brizy_post->get_wp_post() );
				} );
				break;
		}
	}

	/**
	 * Render custom block.
	 *
	 * @param integer|WP_Post $block
	 * @param string $hook_action
	 */
	public function render_block( $block, $hook_action = null ) {
		/**
		 * Validity check.
		 */

		// Get the post object.
		if ( ! is_a( $block, 'WP_Post' ) ) {
			$block = get_post( $block );
		}

		// Abort if there is no block with specified ID were found.
		if ( empty( $block ) ) {
			return;
		}

		// Abort if block is not yet published.
		if ( 'publish' !== get_post_status( $block ) ) {
			return;
		}

		/**
		 * Add to rendered custom blocks list.
		 */

		$this->add_rendered_custom_block( $block, $hook_action );

		/**
		 * Quickly render the block if it's attached to "Scripts" template hooks.
		 */

		if ( in_array( $hook_action, array( 'wp_head', 'wp_body_open', 'wp_footer' ) ) ) {
			$content = $block->post_content;

			if ( function_exists( 'has_blocks' ) && has_blocks( $content ) ) {
				$content = do_blocks( $content );
			}

			// Render the markup.
			echo "\n" . '<!-- [cakecious-block-' . $block->ID . '] -->' . $content . '<!-- [/cakecious-block-' . $block->ID . '] -->' . "\n"; // WPCS: XSS OK.

			// Exit this function immediately, nothing else to do.
			return;
		}

		/**
		 * Detect the content builder.
		 */

		$builder = $this->get_block_builder( $block );

		/**
		 * Build the block wrapper.
		 */

		// Define array for wrapper classes.
		$wrapper_classes = array( 'cakecious-block', 'cakecious-block-' . $block->ID );

		// Add block responsive visibility class.
		$settings = $this->get_block_settings( $block );
		foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device ) {
			if ( ! in_array( $device, $settings['devices'] ) ) {
				$wrapper_classes[] = 'cakecious-hide-on-' . $device;
			}
		}

		// Add builder class.
		switch ( $builder ) {
			case 'elementor':
				$wrapper_classes[] = 'cakecious-block-built-with-elementor';
				break;

			case 'brizy':
				$wrapper_classes[] = 'cakecious-block-built-with-brizy';

				// Original Brizy classes
				$wrapper_classes[] = 'brz'; // Mandatory Brizy content wrapper class, because all Brizy CSS use this selector wrapper.
				$wrapper_classes[] = ( function_exists( 'wp_is_mobile' ) && wp_is_mobile() ) ? 'brz-is-mobile' : '';
				break;

			case 'divi-builder':
				$wrapper_classes[] = 'cakecious-block-built-with-divi-builder';
				break;
		}

		// Add "added via shortcode" class.
		if ( is_null( $hook_action ) ) {
			$wrapper_classes[] = 'cakecious-block-via-shortcode';
		}

		// Add custom additional classes.
		if ( ! empty( $settings['class'] ) ) {
			$wrapper_classes[] = $settings['class'];
		}

		// Wrapper tag.
		$before_block = '<' . $settings['tag'] . ( ! empty( $settings['id'] ) ? ' id="' . esc_attr( $settings['id'] ) . '"' : '' ) . ' class="' . esc_attr( implode( ' ', $wrapper_classes ) ) . '">';
		$after_block = '</' . $settings['tag'] . '>';

		// Whether to add content wrapper or not.
		if ( $settings['use_container'] ) {
			$before_block = $before_block . '<div class="cakecious-wrapper cakecious-block-wrapper"' . ( ! empty( $settings['container_width'] ) ? ' style="width: ' . $settings['container_width'] . 'px;"' : '' ) . '>';
			$after_block = '</div>' . $after_block;
		}

		/**
		 * Get block content based on its editor/builder.
		 */

		switch ( $builder ) {
			case 'elementor':
				// Fetch content using Elementor functions.
				$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $block->ID );
				break;

			case 'brizy':
				$brizy_post = Brizy_Editor_Post::get( $block->ID );
				$brizy_project = Brizy_Editor_Project::get();
				$brizy_html = new Brizy_Editor_CompiledHtml( $brizy_post->get_compiled_html() );
				$brizy_public = Brizy_Public_Main::get( $brizy_post ); // Mandatory, because it contains additional "brizy_content" filter.

				// Fetch content using Brizy filters.
				$content = apply_filters( 'brizy_content', $brizy_html->get_body(), $brizy_project, $brizy_post->get_wp_post() );

				// Parse shortcode.
				$content = do_shortcode( $content );

				// Print scripts manually if rendered via shortcode.
				// Because when the shortcode is processed, it's already too late to print Brizy scripts on <head>.
				if ( is_null( $hook_action ) ) {
					// Print block scripts at the bottom of <body>.
					// It should be rendered after Brizy's main CSS.
					// Can't find any better location to print the scripts.
					add_action( 'wp_print_footer_scripts', function() use ( $brizy_post, $brizy_project, $brizy_html ) {
						echo apply_filters( 'brizy_content', $brizy_html->get_head(), $brizy_project, $brizy_post->get_wp_post() );
					} );

					// Enqueue Brizy scripts.
					$brizy_public->_action_enqueue_preview_assets();
				}
				break;

			case 'divi-builder':
				global $wp_filter;

				// Temporarily switch the global $post to current block.
				global $post;
				$post = $block;

				// Add wrapper manually
				//
				// Can't use this call:
				// $content = et_builder_add_builder_content_wrapper( $block->post_content );
				//
				// Because 'et_builder_add_builder_content_wrapper' function is restricted only for singular template.
				$outer_class   = apply_filters( 'et_builder_outer_content_class', array( 'et-boc' ) );
				$outer_classes = implode( ' ', $outer_class );
				// $outer_id      = apply_filters( 'et_builder_outer_content_id', 'et-boc' );
				$inner_class   = apply_filters( 'et_builder_inner_content_class', array( 'et_builder_inner_content' ) );
				$inner_classes = implode( ' ', $inner_class );

				$is_dbp                   = et_is_builder_plugin_active();
				// $dbp_compat_wrapper_open  = $is_dbp ? '<div id="et_builder_outer_content" class="et_builder_outer_content">' : '';
				$dbp_compat_wrapper_open  = $is_dbp ? '<div class="et_builder_outer_content">' : '';
				$dbp_compat_wrapper_close = $is_dbp ? '</div>' : '';

				$content = sprintf(
					'<div class="%1$s">
						%2$s
						<div class="%3$s">
							%4$s
						</div>
						%5$s
					</div>',
					esc_attr( $outer_classes ),
					et_core_intentionally_unescaped( $dbp_compat_wrapper_open, 'fixed_string' ),
					esc_attr( $inner_classes ),
					$block->post_content,
					et_core_intentionally_unescaped( $dbp_compat_wrapper_close, 'fixed_string' )
				);

				// Apply the_content filters.
				$content = apply_filters( 'the_content', $block->post_content );

				// Revert back to original global $post.
				wp_reset_postdata();
				break;
			
			default:
				$content = $block->post_content;

				// Define filter function names for default content rendering, similar to 'the_content'.
				// We can't use 'the_content' hook because 3rd party plugins might have added a lot of filters that seems to be irrelevant to our Custom Blocks.
				// 
				// TODO: Regularly check 'the_content' filters and their order to make sure the filters works similar to WordPress's default.
				$filters = array(
					// 9
					'do_blocks' => 9,
					// 10
					'wptexturize' => 10,
					'wpautop' => 10,
					'shortcode_unautop' => 10,
					'prepend_attachment' => 10,
					// 'wp_make_content_images_responsive' => 10, --> deprecated
					'wp_filter_content_tags' => 10,
					// 11
					'capital_P_dangit' => 11,
					'do_shortcode' => 11,
					// 20
					'convert_smilies' => 20,
				);

				// Detect whether content is built using Gutenberg or Classic Editor.
				// And then remove unnecessary filter based on its editor type.
				if ( function_exists( 'has_blocks' ) && has_blocks( $content ) ) {
					unset( $filters['wpautop'] );
				} else {
					unset( $filters['do_blocks'] );
				}

				// Add filters to our own hook.
				foreach ( $filters as $filter => $priority ) {
					if ( function_exists( $filter ) ) {
						add_filter( 'cakecious/frontend/custom_block_content', $filter, $priority );
					}
				}

				// Apply filters hook to the content.
				$content = apply_filters( 'cakecious/frontend/custom_block_content', $content );
				break;
		}

		/**
		 * Render the block.
		 */

		// Render the markup.
		echo "\n" . '<!-- [cakecious-block-' . $block->ID . '] -->' . $before_block . $content . $after_block . '<!-- [/cakecious-block-' . $block->ID . '] -->' . "\n"; // WPCS: XSS OK.
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Return all display rules for specified post.
	 *
	 * @param WP_Post $obj
	 * @return array
	 */
	public function get_current_page_rules__post( $obj ) {
		$return = array( 'general|global' );
			
		if ( $obj->ID == get_option( 'page_on_front' ) ) {
			$return[] = 'general|front_page';
		}

		$post_type = get_post_type( $obj );

		$return[] = 'general|singular';
		$return[] = 'posts|' . $post_type;
		$return[] = 'posts|' . $post_type . ':' . $obj->ID;
		
		$the_taxonomies = get_taxonomies( array(
			'object_type' => array( $post_type ),
			'public'      => true,
			'rewrite'     => true,
		) );

		foreach ( $the_taxonomies as $taxonomy ) {
			$terms_objects = get_the_terms( $obj, $taxonomy );

			if ( is_array( $terms_objects ) ) {
				foreach ( $terms_objects as $term_obj ) {
					$return[] = 'posts_in_tax|' . $taxonomy . ':' . $term_obj->term_id;
				}
			}
		}

		return $return;
	}

	/**
	 * Return all display rules for specified term.
	 *
	 * @param WP_Term $obj
	 * @return array
	 */
	public function get_current_page_rules__term( $obj ) {
		$return = array( 'general|global' );

		$return[] = 'general|archive';
		$return[] = 'tax_archive|' . $obj->taxonomy;
		$return[] = 'tax_archive|' . $obj->taxonomy . ':' . $obj->term_id;

		return $return;
	}

	/**
	 * Return all display rules for current loaded page.
	 *
	 * @return array
	 */
	public function get_current_page_rules() {
		$return = array( 'general|global' );
			
		if ( is_front_page() ) {
			$return[] = 'general|front_page';
		}

		if ( is_home() ) {
			$return[] = 'general|archive';
			$return[] = 'post_type_archive|post';
		}

		if ( is_singular() ) {
			$obj = get_queried_object();

			$return[] = 'general|singular';
			$return[] = 'posts|' . get_post_type();
			$return[] = 'posts|' . get_post_type() . ':' . get_the_ID();

			$the_taxonomies = get_taxonomies( array(
				'object_type' => array( get_post_type() ),
				'public'      => true,
				'rewrite'     => true,
			) );

			foreach ( $the_taxonomies as $taxonomy ) {
				$return[] = 'posts_in_tax|' . $taxonomy;

				$terms_objects = get_the_terms( $obj, $taxonomy );

				if ( is_array( $terms_objects ) ) {
					foreach ( $terms_objects as $term_obj ) {
						$return[] = 'posts_in_tax|' . $taxonomy . ':' . $term_obj->term_id;
					}
				}
			}
		}

		elseif ( is_archive() ) {
			$return[] = 'general|archive';

			if ( is_post_type_archive() ) {
				$obj = get_queried_object();
				
				$return[] = 'post_type_archive|' . $obj->name;
			}

			elseif ( is_tax() || is_category() || is_tag() ) {
				$obj = get_queried_object();

				$return[] = 'tax_archive|' . $obj->taxonomy;
				$return[] = 'tax_archive|' . $obj->taxonomy . ':' . $obj->term_id;
			}

			elseif ( is_year() || is_month() || is_date() || is_time() ) {
				$return[] = 'general|date_archive';
			}

			elseif ( is_author() ) {
				$return[] = 'general|author_archive';
			}
		}

		elseif ( is_search() ) {
			$return[] = 'general|search';
		}

		elseif ( is_404() ) {
			$return[] = 'general|not_found';
		}

		return $return;
	}

	/**
	 * Return all user roles for current loaded page.
	 *
	 * @return array
	 */
	public function get_current_user_roles() {
		$return = array( 'public' );

		if ( is_user_logged_in() ) {
			$return[] = 'logged_in';

			$user = wp_get_current_user();
			$return = array_merge( $return, $user->roles );
		} else {
			$return[] = 'logged_out';
		}

		return $return;
	}

	/**
	 * Render custom block.
	 *
	 * @param integer|WP_Post $block
	 * @param string $hook_action
	 */
	public function add_rendered_custom_block( $block, $hook_action = null ) {
		$hook_title = esc_html__( 'via Shortcode' );

		if ( ! is_null( $hook_action ) ) {
			$hook_names = $this->get_all_template_hooks( true );

			if ( isset( $hook_names['hook_action'] ) ) {
				$hook_title = $hook_names['hook_action'];
			} else {
				$hook_title = sprintf(
					/* translators: %1$s: custom hook name. */
					esc_html__( 'Hook: %1$s', 'cakecious-features' ),
					$hook_action
				);
			}
		}

		$this->rendered_custom_blocks[ $block->ID ] = array(
			'id'    => $block->ID,
			'title' => get_the_title( $block ),
			'hook'  => $hook_title,
		);
	}

	/**
	 * Return the builder slug that is used to build the specified block id.
	 *
	 * @param integer|WP_Post $block
	 * @return string
	 */
	public function get_block_builder( $block ) {
		// Check if it's built with Elementor.
		if ( class_exists( '\Elementor\Plugin' ) && intval( \Elementor\Plugin::instance()->db->is_built_with_elementor( $block->ID ) ) ) {
			return 'elementor';
		}

		// Check if it's built with Brizy.
		elseif ( class_exists( 'Brizy_Editor_Post' ) && Brizy_Editor_Post::get( $block->ID )->uses_editor() ) {
			return 'brizy';
		}

		// Check if it's built with Divi.
		elseif ( class_exists( 'ET_Builder_Plugin' ) && et_pb_is_pagebuilder_used( $block->ID ) ) {
			return 'divi-builder';
		}

		return 'default';
	}

	/**
	 * Return settings of the specified block id.
	 *
	 * @param integer|WP_Post $block
	 * @return array
	 */
	public function get_block_settings( $block ) {
		if ( is_a( $block, 'WP_Post' ) ) {
			$block = $block->ID;
		}

		$settings = get_post_meta( $block, '_' . self::POST_TYPE . '_settings', true );
		$settings = wp_parse_args( $settings, array(
			'hook_action'        => '',
			'hook_action_custom' => '',
			'hook_priority'      => 10,

			'display_rules'      => array(),
			'exclusion_rules'    => array(),
			'user_roles'         => array(),
			'devices'            => array(),

			'tag'                => 'div',
			'id'                 => '',
			'class'              => '',
			'use_container'      => 0,
			'container_width'    => '',
		) );

		return $settings;
	}

	/**
	 * Return boolean whether the specififed block is available on current page or not.
	 *
	 * @param integer|WP_Post $block
	 * @return boolean
	 */
	public function check_block_status_on_current_page( $block ) {
		if ( ! is_a( $block, 'WP_Post' ) ) {
			$block = get_post( $block );
		}

		$settings = $this->get_block_settings( $block );

		// Fetch current page diplay rules.
		$current_page_rules = $this->get_current_page_rules();
		$current_user_roles = $this->get_current_user_roles();

		// Skip if content block doesn't have any assigned display rule.
		if ( empty( $settings['display_rules'] ) ) return false;

		// Skip if content block doesn't have any assigned user role.
		if ( empty( $settings['user_roles'] ) ) return false;

		// Check each display rule if matches current page.
		// Skip if there is no display rule matched.
		if ( 0 === count( array_intersect( $settings['display_rules'], $current_page_rules ) ) ) return false;

		// Check each exclusion rule if matches current page.
		// Skip if there is any exclusion rule matched.
		if ( 0 < count( array_intersect( $settings['exclusion_rules'], $current_page_rules ) ) ) return false;

		// Check each user role if matches current user.
		// Skip if there is no user role matched.
		if ( 0 === count( array_intersect( $settings['user_roles'], $current_user_roles ) ) ) return false;

		return true;
	}

	/**
	 * Return all available Blocks.
	 *
	 * @param boolean $flatten
	 * @return array
	 */
	public function get_all_template_hooks( $flatten = false ) {
		$hooks = array(
			esc_attr__( 'Page Canvas', 'cakecious-features' ) => array(
				'cakecious/frontend/before_canvas' => esc_attr__( 'Before Page Canvas', 'cakecious-features' ),
				'cakecious/frontend/after_canvas' => esc_attr__( 'After Page Canvas', 'cakecious-features' ),
			),
			esc_attr__( 'Header', 'cakecious-features' ) => array(
				'cakecious/frontend/header' => esc_attr__( 'Replace Header (Desktop & Mobile Header)', 'cakecious-features' ),
				'cakecious/frontend/before_header' => esc_attr__( 'Before Header', 'cakecious-features' ),
				'cakecious/frontend/after_header' => esc_attr__( 'After Header', 'cakecious-features' ),
			),
			esc_attr__( 'Content & Sidebar', 'cakecious-features' ) => array(
				'cakecious/frontend/before_primary_and_sidebar' => esc_attr__( 'Before Main Content & Sidebar', 'cakecious-features' ),
				'cakecious/frontend/before_primary_and_sidebar' => esc_attr__( 'After Main Content & Sidebar', 'cakecious-features' ),
				'cakecious/frontend/before_main' => esc_attr__( 'Before Main Content', 'cakecious-features' ),
				'cakecious/frontend/after_main' => esc_attr__( 'After Main Content', 'cakecious-features' ),
				'cakecious/frontend/before_sidebar' => esc_attr__( 'Before Sidebar', 'cakecious-features' ),
				'cakecious/frontend/after_sidebar' => esc_attr__( 'After Sidebar', 'cakecious-features' ),
			),
			esc_attr__( 'Post / Page Content', 'cakecious-features' ) => array(
				'cakecious/frontend/entry/before_header' => esc_attr__( 'Before Post Entry Header', 'cakecious-features' ),
				'cakecious/frontend/entry/header' => esc_attr__( 'Post Entry Header', 'cakecious-features' ),
				'cakecious/frontend/entry/after_header' => esc_attr__( 'After Post Entry Header', 'cakecious-features' ),
				'cakecious/frontend/entry/before_content' => esc_attr__( 'Before Post Entry Content', 'cakecious-features' ),
				'cakecious/frontend/entry/after_content' => esc_attr__( 'After Post Entry Content', 'cakecious-features' ),
				'cakecious/frontend/entry/before_footer' => esc_attr__( 'Before Post Entry Footer', 'cakecious-features' ),
				'cakecious/frontend/entry/footer' => esc_attr__( 'Post Entry Footer', 'cakecious-features' ),
				'cakecious/frontend/entry/after_footer' => esc_attr__( 'After Post Entry Footer', 'cakecious-features' ),
			),
			esc_attr__( 'Comments', 'cakecious-features' ) => array(
				'cakecious/frontend/before_comments' => esc_attr__( 'Before Comments Section', 'cakecious-features' ),
				'cakecious/frontend/before_comments_list' => esc_attr__( 'Before Comments List', 'cakecious-features' ),
				'cakecious/frontend/after_comments_list' => esc_attr__( 'After Comments List', 'cakecious-features' ),
				'cakecious/frontend/after_comments' => esc_attr__( 'After Comments Section', 'cakecious-features' ),
			),
			esc_attr__( 'Footer', 'cakecious-features' ) => array(
				'cakecious/frontend/footer' => esc_attr__( 'Replace Footer (Widgets & Bottom Bar)', 'cakecious-features' ),
				'cakecious/frontend/before_footer' => esc_attr__( 'Before Footer', 'cakecious-features' ),
				'cakecious/frontend/after_footer' => esc_attr__( 'After Footer', 'cakecious-features' ),
			),
			esc_attr__( 'Scripts', 'cakecious-features' ) => array(
				'wp_head' => esc_attr__( 'Inside <head> tag', 'cakecious-features' ),
				'wp_body_open' => esc_attr__( 'After opening <body> tag', 'cakecious-features' ),
				'wp_footer' => esc_attr__( 'Before closing </body> tag', 'cakecious-features' ),
			),
			esc_attr__( 'Other Template Hooks', 'cakecious-features' ) => array(
				'custom' => esc_attr__( 'Enter the hook name: ...', 'cakecious-features' ),
			),
		);

		$hooks = apply_filters( 'cakecious/pro/blocks/hooks', $hooks );

		if ( $flatten ) {
			$hooks = cakecious_flatten_array( $hooks );
		}

		return $hooks;
	}

	/**
	 * Return all display rules.
	 *
	 * @param boolean $flatten
	 * @return array
	 */
	public function get_all_display_rules( $flatten = false ) {
		$rules = array();

		$rules[ esc_attr__( 'General', 'cakecious-features' ) ] = array(
			'general|global'         => esc_attr__( 'Entire Website', 'cakecious-features' ),
			'general|singular'       => esc_attr__( 'All Singulars (any post type)', 'cakecious-features' ),
			'general|archive'        => esc_attr__( 'All Archives (any post type)', 'cakecious-features' ),
			'general|search'         => esc_attr__( 'Search Results', 'cakecious-features' ),
			'general|not_found'      => esc_attr__( 'Not Found (404)', 'cakecious-features' ),
			'general|date_archive'   => esc_attr__( 'Date Archive', 'cakecious-features' ),
			'general|author_archive' => esc_attr__( 'Author Archive', 'cakecious-features' ),
			'general|front_page'     => esc_attr__( 'Front Page', 'cakecious-features' ),
		);

		$rules[ esc_attr__( 'Pages', 'cakecious-features' ) ][ 'posts|page' ] = esc_html__( 'Static Pages (singular)', 'cakecious-features' );

		$post_types = array_merge(
			array( 'post' ),
			get_post_types( array(
				'public'             => true,
				'publicly_queryable' => true,
				'rewrite'            => true,
			), 'names' )
		);
		foreach ( $post_types as $post_type ) {
			$obj = get_post_type_object( $post_type );

			$tax_objects = get_taxonomies( array(
				'object_type' => array( $post_type ),
				'public'      => true,
				'rewrite'     => true,
			), 'objects' );

			// Posts archive.
			/* translators: %s: post type plural label. */
			$rules[ esc_attr( $obj->labels->name ) ][ 'post_type_archive|' . $obj->name ] = sprintf( esc_html__( '%s Archive', 'cakecious-features' ), $obj->labels->name );

			foreach ( $tax_objects as $tax_obj ) {
				// Taxonomy archive.
				/* translators: %s: taxonomy singular label. */
				$rules[ esc_attr( $obj->labels->name ) ][ 'tax_archive|' . $tax_obj->name ] = sprintf( esc_html__( '%s Archive', 'cakecious-features' ), $tax_obj->labels->singular_name );
			}

			// Posts
			/* translators: %s: post type plural label. */
			$rules[ esc_attr( $obj->labels->name ) ][ 'posts|' . $obj->name ] = sprintf( esc_html__( '%s (singular)', 'cakecious-features' ), $obj->labels->name );

			foreach ( $tax_objects as $tax_obj ) {
				// Posts in specific taxonomy
				/* translators: %1$s: post type plural label, %1$s: taxonomy singular label. */
				$rules[ esc_attr( $obj->labels->name ) ][ 'posts_in_tax|' . $tax_obj->name ] = sprintf( esc_html__( '%1$s in %2$s', 'cakecious-features' ), $obj->labels->name, $tax_obj->labels->singular_name );
			}
		}

		$rules = apply_filters( 'cakecious/pro/blocks/page_rules', $rules );

		if ( $flatten ) {
			$rules = cakecious_flatten_array( $rules );
		}

		return $rules;
	}

	/**
	 * Return all user roles.
	 *
	 * @param boolean $flatten
	 * @return array
	 */
	public function get_all_user_roles( $flatten = false ) {
		$specific = array();
		foreach ( get_editable_roles() as $key => $value ) {
			$specific[ $key ] = $value['name'];
		}

		$roles = array(
			esc_attr__( 'Basic', 'cakecious-features' ) => array(
				'public'     => esc_attr__( 'All Users', 'cakecious-features' ),
				'logged_out' => esc_attr__( 'Logged out Users', 'cakecious-features' ),
				'logged_in'  => esc_attr__( 'Logged in Users', 'cakecious-features' ),
			),
			esc_attr__( 'Specific Roles', 'cakecious-features' ) => $specific,
		);

		$roles = apply_filters( 'cakecious/pro/blocks/user_roles', $roles );

		if ( $flatten ) {
			$roles = cakecious_flatten_array( $roles );
		}

		return $roles;
	}
}

Cakecious_Pro_Module_Custom_Blocks::instance();