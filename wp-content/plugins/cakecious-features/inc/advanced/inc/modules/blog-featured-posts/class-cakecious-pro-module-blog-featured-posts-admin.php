<?php
/**
 * Blog Featured Posts Admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Blog_Featured_Posts_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_Blog_Featured_Posts_Admin
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
	 * @return Cakecious_Pro_Module_Blog_Featured_Posts_Admin
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
		if ( cakecious_get_theme_mod( 'blog_featured_posts' ) ) {
			// Add custom column
			add_filter( 'manage_post_posts_columns', array( $this, 'add_column' ) );
			add_action( 'manage_post_posts_custom_column', array( $this, 'render_column' ), 10, 2 );

			// Add custom bulk action
			add_filter( 'bulk_actions-edit-post', array( $this, 'add_bulk_action' ) );
			add_filter( 'handle_bulk_actions-edit-post', array( $this, 'add_bulk_action_handler' ), 10, 3 );

			// Add individual action handler
			add_action( 'post_action_cakecious-mark-featured-post', array( $this, 'post_action_mark_featured_post' ) );
			add_action( 'post_action_cakecious-unmark-featured-post', array( $this, 'post_action_unmark_featured_post' ) );
			add_filter( 'removable_query_args', array( $this, 'add_removable_query_args' ) );
			
			// Add notices
			add_action( 'admin_notices', array( $this, 'add_notices' ) );

			// Add custom filter
			add_action( 'restrict_manage_posts', array( $this, 'add_filter' ) );
			add_filter( 'parse_query', array( $this, 'run_filter' ) );
			
			// Add metabox into edit page
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 10, 2 );
			add_action( 'save_post', array( $this, 'save_meta_box' ) );
		}
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add custom column.
	 *
	 * @param array $columns
	 * @return array
	 */
	public function add_column( $columns ) {
		$columns['cakecious-featured-post'] = esc_html__( 'Featured?', 'cakecious-features' );

		return $columns;
	}

	/**
	 * Add custom bulk action.
	 *
	 * @param array $bulk_actions
	 * @return array
	 */
	public function add_bulk_action( $bulk_actions ) {
		$bulk_actions['cakecious-mark-featured-posts'] = esc_html__( 'Mark as Featured', 'cakecious-features' );
		$bulk_actions['cakecious-unmark-featured-posts'] = esc_html__( 'Unmark as Featured', 'cakecious-features' );

		return $bulk_actions;
	}

	/**
	 * Add custom bulk action handler for featured posts.
	 *
	 * @param array $redirect_url
	 * @param string $doaction
	 * @param array $items
	 * @return array
	 */
	public function add_bulk_action_handler( $redirect_url, $doaction, $items ) {
		$actions = array( 'cakecious-mark-featured-posts', 'cakecious-unmark-featured-posts' );

		// Abort if current action is not related to Featured Posts.
		if ( ! in_array( $doaction, $actions ) ) {
			return $redirect_url;
		}

		// Remove query parameters from the redirect URL.
		$redirect_url = remove_query_arg( $actions, $redirect_url );

		// Get featured posts IDs.
		$ids = get_option( 'cakecious_featured_posts', array() );

		// Process the action.
		if ( 'cakecious-mark-featured-posts' === $doaction ) {
			$ids = array_merge( $ids, $items );

			$redirect_url = add_query_arg( array(
				'cakecious-featured-posts-marked' => count( $items ),
				'ids'                        => implode( ',', $items ),
			), $redirect_url );
		}
		elseif ( 'cakecious-unmark-featured-posts' === $doaction ) {
			$ids = array_diff( $ids, $items );

			$redirect_url = add_query_arg( array(
				'cakecious-featured-posts-unmarked' => count( $items ),
				'ids'                          => implode( ',', $items ),
			), $redirect_url );
		}

		// Update option.
		update_option( 'cakecious_featured_posts', $ids );
		
		// Return redirect URL.
		return $redirect_url;
	}

	/**
	 * Post action to mark the selected post as featured.
	 *
	 * @param integer $post_id
	 */
	public function post_action_mark_featured_post( $post_id ) {
		/**
		 * Check authority.
		 */

		check_admin_referer( 'cakecious-mark-featured-post-' . $post_id );

		global $post_type, $post_type_object, $post;

		if ( ! $post ) {
			wp_die( __( 'You attempted to edit an item that doesn&#8217;t exist. Perhaps it was deleted?' ) );
		}

		if ( ! $post_type_object ) {
			wp_die( __( 'Invalid post type.' ) );
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( __( 'Sorry, you are not allowed to edit this item.' ) );
		}

		/**
		 * Mark as featured post.
		 */
		
		$ids = get_option( 'cakecious_featured_posts', array() );

		$ids = array_merge( $ids, array( $post_id ) );

		update_option( 'cakecious_featured_posts', $ids );

		/**
		 * Redirect to posts list page.
		 */

		wp_redirect(
			add_query_arg(
				array(
					'cakecious-featured-posts-marked' => 1,
					'ids'                        => $post_id,
				),
				admin_url( 'edit.php' )
			)
		);
		exit();
	}


	/**
	 * Post action to unmark the selected post as featured.
	 *
	 * @param integer $post_id
	 */
	public function post_action_unmark_featured_post( $post_id ) {
		/**
		 * Check authority.
		 */

		check_admin_referer( 'cakecious-unmark-featured-post-' . $post_id );

		global $post_type, $post_type_object, $post;

		if ( ! $post ) {
			wp_die( __( 'You attempted to edit an item that doesn&#8217;t exist. Perhaps it was deleted?' ) );
		}

		if ( ! $post_type_object ) {
			wp_die( __( 'Invalid post type.' ) );
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( __( 'Sorry, you are not allowed to edit this item.' ) );
		}

		/**
		 * Unmark as featured post.
		 */
		
		$ids = get_option( 'cakecious_featured_posts', array() );

		$ids = array_diff( $ids, array( $post_id ) );

		update_option( 'cakecious_featured_posts', $ids );

		/**
		 * Redirect to posts list page.
		 */

		wp_redirect(
			add_query_arg(
				array(
					'cakecious-featured-posts-unmarked' => 1,
					'ids'                          => $post_id,
				),
				admin_url( 'edit.php' )
			)
		);
		exit();
	}

	/**
	 * Add "cakecious-featured-posts-marked" and "cakecious-featured-posts-unmarked" into removable query arguments.
	 *
	 * So that the URL has no "cakecious-featured-posts-marked" and "cakecious-featured-posts-unmarked" parameter.
	 *
	 * @param array $removable_query_args
	 * @return array
	 */
	public function add_removable_query_args( $removable_query_args ) {
		$removable_query_args[] = 'cakecious-featured-posts-marked';
		$removable_query_args[] = 'cakecious-featured-posts-unmarked';

		return $removable_query_args;
	}

	/**
	 * Add custom filter.
	 */
	public function add_filter() {
		$post_type = 'post';
		if ( isset( $_GET['post_type'] ) ) {
			$post_type = $_GET['post_type'];
		}

		// Abort if post type is not "post".
		if ( 'post' !== $post_type ) {
			return;
		}

		?>
		<label class="cakecious-filter-featured-posts"><input type="checkbox" name="cakecious-featured-post" value="1" <?php checked( 1, isset( $_GET['cakecious-featured-post'] ) ? $_GET['cakecious-featured-post'] : 0 ); ?>> <?php esc_html_e( 'Featured Posts', 'cakecious-features' ); ?></label>
		<?php
	}

	/**
	 * Add custom bulk action notice.
	 */
	public function add_notices() {
		if ( ! empty( $_REQUEST['cakecious-featured-posts-marked'] ) ) {
			$count = intval( $_REQUEST['cakecious-featured-posts-marked'] );
			printf( '<div id="message" class="updated notice is-dismissible"><p>' . _n( '%s post marked as Featured.', '%s posts marked as Featured.', $count, 'cakecious-features' ) . '</p></div>', $count );
		}
		elseif ( ! empty( $_REQUEST['cakecious-featured-posts-unmarked'] ) ) {
			$count = intval( $_REQUEST['cakecious-featured-posts-unmarked'] );
			printf( '<div id="message" class="updated notice is-dismissible"><p>' . _n( '%s post unmarked as Featured.', '%s posts unmarked as Featured.', $count, 'cakecious-features' ) . '</p></div>', $count );
		}

		$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'cakecious-featured-posts-marked', 'cakecious-featured-posts-unmarked' ), $_SERVER['REQUEST_URI'] );
	}

	/**
	 * Run custom filter.
	 *
	 * @param WP_Query $query
	 * @return WP_Query
	 */
	public function run_filter( $query ) {
		// Modify the query only if it's main query in admin page.
		if ( ! ( is_admin() && $query->is_main_query() ) ) { 
			return $query;
		}

		// We want to modify the query for the targeted custom post and filter option
		if ( ! ( 'post' === $query->query['post_type'] && isset( $_REQUEST['cakecious-featured-post'] ) ) ) {
			return $query;
		}

		// For the default value of our filter no modification is required
		if ( ! intval( $_REQUEST['cakecious-featured-post'] ) ) {
			return $query;
		}

		/**
		 * Modify the query_vars.
		 */

		// Get current featured posts list.
		$ids = get_option( 'cakecious_featured_posts', array() );

		// Get current "post__in".
		$in = $query->get( 'post__in' );

		// If "post__in" is empty or undefined, set it to empty array.
		if ( empty( $in ) ) {
			$in = array();
		}

		// Merge with featured posts IDs.
		$in = array_merge( $ids, $in );

		// Assign the merged "post__in" into the query.
		$query->set( 'post__in', $in );

		return $query;
	}

	/**
	 * Add meta box on post editor.
	 *
	 * @param string $post_type
	 * @param WP_Post $post
	 */
	public function add_meta_box( $post_type, $post ) {
		add_meta_box(
			'cakecious_featured_post',
			/* translators: %s: plugin name */
			sprintf( esc_html__( 'Featured Post (%s)', 'cakecious-features' ), Cakecious_Pro::instance()->get_info( 'name' ) ),
			array( $this, 'render_meta_box' ),
			'post',
			'side',
			'high'
		);
	}

	/**
	 * Save meta box.
	 *
	 * @param integer $post_id
	 */
	public function save_meta_box( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST[ 'cakecious_featured_post_settings_nonce'] ) ) return;

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['cakecious_featured_post_settings_nonce'], 'cakecious_featured_post_settings' ) ) return;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		/**
		 * Add/remove post ID from featured posts list.
		 */

		// Get featured posts IDs.
		$ids = get_option( 'cakecious_featured_posts', array() );

		if ( isset( $_POST['cakecious-featured-post'] ) && intval( $_POST['cakecious-featured-post'] ) ) {
			$ids = array_merge( $ids, array( $post_id ) );
		} else {
			$ids = array_diff( $ids, array( $post_id ) );
		}

		update_option( 'cakecious_featured_posts', $ids );
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render custom column's cell value.
	 *
	 * @param string $column
	 * @param integer $post_id
	 */
	public function render_column( $column, $post_id ) {
		if ( 'cakecious-featured-post' !== $column ) {
			return;
		}

		$is_featured = in_array( $post_id, get_option( 'cakecious_featured_posts', array() ) );

		$action = $is_featured ? 'cakecious-unmark-featured-post' : 'cakecious-mark-featured-post';

		// Remove "filter_action" query arg from current URL (conflict with "action").
		// And then add "post" and "action" args into the link URL.
		$url = wp_nonce_url( add_query_arg( array(
			'post' => $post_id,
			'action' => $action,
		), admin_url( 'post.php' ) ), $action . '-' . $post_id );
		?>
		<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $is_featured ? 'cakecious-unmark-featured-post' : 'cakecious-mark-featured-post' ); ?>"><span class="dashicons dashicons-yes-alt"></span></a>
		<?php
	}

	/**
	 * Render meta box on post edit page.
	 *
	 * @param WP_Post $post
	 */
	public function render_meta_box( $post ) {
		$is_featured = in_array( $post->ID, get_option( 'cakecious_featured_posts', array() ) );

		wp_nonce_field( 'cakecious_featured_post_settings', 'cakecious_featured_post_settings_nonce' );
		?>
		<div class="cakecious-admin-form">
			<div class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-field">
					<label><input type="checkbox" name="cakecious-featured-post" value="1" <?php checked( 1, isset( $is_featured ) ? $is_featured : 0 ); ?>> <?php esc_html_e( 'Mark this post as "Featured Post"', 'cakecious-features' ); ?></label>
				</div>
			</div>
		</div>
		<?php
	}
}

Cakecious_Pro_Module_Blog_Featured_Posts_Admin::instance();