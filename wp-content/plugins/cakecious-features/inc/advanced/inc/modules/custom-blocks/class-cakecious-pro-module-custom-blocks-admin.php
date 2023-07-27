<?php
/**
 * Custom Blocks Admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Custom_Blocks_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_Custom_Blocks_Admin
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
	 * @return Cakecious_Pro_Module_Custom_Blocks_Admin
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
		// Admin menu
		add_action( 'cakecious/admin/menu', array( $this, 'add_admin_menu' ) );
		
		// List page
		add_filter( 'views_edit-' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE, array( $this, 'render_description' ) );
		add_filter( 'manage_' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_posts_columns', array( $this, 'manage_list_columns' ) );
		add_action( 'manage_' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_posts_custom_column', array( $this, 'manage_list_columns_content' ), 10, 2 );

		// Edit page
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_meta_box' ) );

		// Page Settings Metabox
		add_action( 'cakecious/admin/metabox/page_settings/fields', array( $this, 'add_metabox_page_settings_fields' ), 10, 2 );

		// AJAX callbacks
		add_action( 'wp_ajax_cakecious_pro__get_posts_as_select2_choices', array( $this, 'ajax_get_posts_as_select2_choices' ) );
		add_action( 'wp_ajax_cakecious_pro__get_terms_as_select2_choices', array( $this, 'ajax_get_terms_as_select2_choices' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add admin submenu page: Appearance > Custom Blocks.
	 */
	public function add_admin_menu() {
		add_theme_page(
			null,
			esc_html__( 'Custom Blocks', 'cakecious-features' ),
			'edit_pages',
			'edit.php?post_type=' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE
		);
	}

	/**
	 * Add columns on posts list.
	 *
	 * @param array $columns
	 * @return array
	 */
	public function manage_list_columns( $columns ) {
		$new = array(
			'hook' => esc_html__( 'Attached Hook', 'cakecious-features' ),
			'display' => esc_html__( 'Display on', 'cakecious-features' ),
			'roles' => esc_html__( 'Visible to', 'cakecious-features' ),
			'responsive' => esc_html__( 'Responsive Visibility', 'cakecious-features' ),
			'shortcode' => esc_html__( 'Shortcode', 'cakecious-features' ),
		);

		$return = array();
		foreach ( $columns as $key => $label ) {
			$return[ $key ] = $label;
			
			if ( 'title' == $key ) {
				$return = array_merge( $return, $new );
			}
		}

		return $return;
	}

	/**
	 * Add columns content on posts list.
	 *
	 * @param array $column_name
	 * @param integer $post_id
	 * @return array
	 */
	public function manage_list_columns_content( $column_name, $post_id ) {
		$settings = Cakecious_Pro_Module_Custom_Blocks::instance()->get_block_settings( $post_id );

		switch ( $column_name ) {
			case 'hook':
				$hooks = Cakecious_Pro_Module_Custom_Blocks::instance()->get_all_template_hooks( true );

				if ( ! empty( $settings['hook_action'] ) ) {
					if ( 'custom' === $settings['hook_action'] ) {
						printf(
							/* translators: %s: The hook action tag entered by user. */
							esc_html__( 'Custom Hook: %s', 'cakecious-features' ),
							$settings['hook_action_custom']
						);
					} else {
						echo esc_html( cakecious_array_value( $hooks, $settings['hook_action'] ) );
					}

					echo esc_html( ' (' . $settings['hook_priority'] . ')' );
				}

				break;

			case 'display':
				if ( isset( $settings['display_rules'] ) ) {
					foreach ( $settings['display_rules'] as $rule ) {
						$rule_chunks = explode( ':', $rule );
						echo '<span class="dashicons dashicons-yes"></span>' . $this->_get_display_rule_string( cakecious_array_value( $rule_chunks, 0 ), cakecious_array_value( $rule_chunks, 1 ) ) . '<br>';
					}

					if ( isset( $settings['exclusion_rules'] ) ) {
						foreach ( $settings['exclusion_rules'] as $rule ) {
							$rule_chunks = explode( ':', $rule );
							echo '<span class="dashicons dashicons-no-alt"></span>' . $this->_get_display_rule_string( cakecious_array_value( $rule_chunks, 0 ), cakecious_array_value( $rule_chunks, 1 ) ) . '<br>';
						}
					}
				}
				
				break;

			case 'responsive':
				foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device ) {
					$active = in_array( $device, $settings['devices'] );
					echo '<span class="dashicons dashicons-' . ( 'mobile' === $device ? 'smartphone' : $device ) . '" style="opacity:' . ( $active ? '1' : '0.25' ) . ';" title="' . sprintf( $active ? esc_html__( 'Show on %s', 'cakecious-features' ) : esc_html__( 'Hide on %s', 'cakecious-features' ), $device ) . '"></span>';
				}
				break;

			case 'roles':
				$roles = Cakecious_Pro_Module_Custom_Blocks::instance()->get_all_user_roles( true );
				
				if ( isset( $settings['user_roles'] ) ) {
					foreach ( $settings['user_roles'] as $role ) {
						echo $roles[ $role ] . '<br>';
					}
				} else {
					echo '&mdash;';
				}
				break;
			
			case 'shortcode':
				$shortcode = '[' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . ' id="' . $post_id . '"]';
				echo '<code>' . esc_attr( $shortcode ) . '</code>';
				break;
		}
	}

	/**
	 * Add meta box to Block edit page.
	 *
	 * @param string $post_type
	 * @param WP_Post $post
	 */
	public function add_meta_box( $post_type, $post ) {
		add_meta_box(
			Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings',
			esc_html__( 'Block Settings', 'cakecious-features' ),
			array( $this, 'render_meta_box' ),
			Cakecious_Pro_Module_Custom_Blocks::POST_TYPE,
			'normal',
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
		if ( ! isset( $_POST[ Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST[ Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings_nonce'], Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$settings = array();

		// Always save display rules, exclusion rules, and user roles even if no value is selected.
		// This is because the jQuery repeater doesn't include empty list as $_POST value.
		$settings = array(
			'display_rules' => array(),
			'exclusion_rules' => array(),
			'user_roles' => array(),
		);

		if ( isset( $_POST[ Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings'] ) ) {
			foreach ( $_POST[ Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings'] as $key => $value ) {
				switch ( $key ) {
					case 'display_rules':
					case 'exclusion_rules':
						$settings[ $key ] = array();

						foreach ( $value as $rule ) {
							if ( '' ===  $rule['type'] ) continue;

							$settings[ $key ][] = $rule['type'] . ( ! empty( $rule['value'] ) ? ':' . $rule['value'] : '' );
						}
						break;

					case 'user_roles':
						$settings[ $key ] = array();

						foreach ( $value as $role ) {
							if ( '' === $role['value'] ) continue;

							$settings[ $key ][] = $role['value'];
						}
						break;

					case 'id':
					case 'class':
						$settings[ $key ] = sanitize_html_class( $value );
						break;

					case 'container_width':
						$settings[ $key ] = absint( $value );
						break;
					
					default:
						if ( '' !== $value ) {
							$settings[ $key ] = $value;
						}
						break;
				}
			}
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, '_' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings', $settings );
	}

	/**
	 * Add Page Settings metabox fields.
	 */
	public function add_metabox_page_settings_fields( $obj, $tab ) {
		if ( 'custom-blocks' !== $tab ) {
			return;
		}

		$current_conditions = array();
		$list = array();

		// Check current edited page display conditions.
		if ( is_a( $obj, 'WP_Post' ) ) {
			$current_conditions = Cakecious_Pro_Module_Custom_Blocks::instance()->get_current_page_rules__post( $obj );
		}
		elseif ( is_a( $obj, 'WP_Term' ) ) {
			$current_conditions = Cakecious_Pro_Module_Custom_Blocks::instance()->get_current_page_rules__term( $obj );
		}

		$hooks = Cakecious_Pro_Module_Custom_Blocks::instance()->get_all_template_hooks( true );

		// Iterate through each content block.
		// Check each display rules and attached hook.
		$all_blocks = get_posts( array(
			'post_type' => Cakecious_Pro_Module_Custom_Blocks::POST_TYPE,
			'posts_per_page' => -1,
		) );
		foreach ( $all_blocks as $block ) {
			// Get block settings.
			$settings = Cakecious_Pro_Module_Custom_Blocks::instance()->get_block_settings( $block );

			// Skip if no action hook found in the block.
			if ( '' === cakecious_array_value( $settings, 'hook_action' ) ) {
				continue;
			}

			// Get hook name.
			$hook_name = cakecious_array_value( $hooks, cakecious_array_value( $settings, 'hook_action' ) );
			if ( 'custom' === $hook_name ) {
				$hook_name .= ': ' . cakecious_array_value( $settings, 'hook_action_custom' );
			}

			// Check exclusion rules.
			// Skip if any of current page conditions matches any of the exclusion rules.
			if ( 0 < count( array_intersect( $current_conditions, cakecious_array_value( $settings, 'exclusion_rules', array() ) ) ) ) {
				continue;
			}

			// Check display rules.
			// Add to inserted blocks list if any of current page conditions matches any of the display rules.
			if ( 0 < count( array_intersect( $current_conditions, cakecious_array_value( $settings, 'display_rules', array() ) ) ) ) {
				$list[] = array(
					'title'         => get_the_title( $block ),
					'hook_name'     => $hook_name,
					'hook_priority' => cakecious_array_value( $settings, 'hook_priority', 10 ),
					'edit_link'     => esc_url( add_query_arg( array( 'post' => $block->ID, 'action' => 'edit' ), admin_url( 'post.php' ) ) ),
				);
			}
		}
		?>
		<div class="cakecious-admin-form-row cakecious-admin-inserted-custom-blocks-list">
			<div class="cakecious-admin-form-field">
				<h4><?php esc_html_e( 'List of custom blocks that were inserted to this page via template hooks', 'cakecious-features' ); ?></h4>
				<table>
					<thead>
						<tr>
							<th width="70%"><?php esc_html_e( 'Title', 'cakecious-features' ); ?></th>
							<th width="30%"><?php esc_html_e( 'Attached Hook', 'cakecious-features' ); ?></th>
							<th width="100px"><?php esc_html_e( 'Priority', 'cakecious-features' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ( 1 > count( $list ) ) : ?>
							<tr>
								<td colspan="3"><?php esc_html_e( 'No block inserted to this page yet.', 'cakecious-features' ); ?></td>
							</tr>
						<?php else : ?>
							<?php foreach ( $list as $item ) : ?>
								<tr>
									<td>
										<a href="<?php echo esc_url( cakecious_array_value( $item, 'edit_link' ) ); ?>"><?php echo esc_html( cakecious_array_value( $item, 'title' ) ); ?></a>
									</td>
									<td><?php echo esc_html( cakecious_array_value( $item, 'hook_name' ) ); ?></td>
									<td><?php echo esc_html( cakecious_array_value( $item, 'hook_priority' ) ); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
				<p style="margin: 0.75em 0; font-style: italic;"><?php esc_html_e( 'NOTE: Blocks that were added via shortcode are not included in the above list.', 'cakecious-features' ); ?></p>
				<p style="margin: 1.25em 0 0;">
					<a href="<?php echo esc_url( add_query_arg( array( 'post_type' => 'cakecious_block' ), admin_url( 'edit.php' ) ) ); ?>" class="button button-secondary"><?php esc_html_e( 'Add or Manage Custom Blocks', 'cakecious-features' ); ?></a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Return a display rule string.
	 *
	 * @param string $type
	 * @param string $value
	 * @return string
	 */
	private function _get_display_rule_string( $type, $value = null ) {
		$rules = Cakecious_Pro_Module_Custom_Blocks::instance()->get_all_display_rules( true );

		$type_chunks = explode( '|', $type );

		$label = cakecious_array_value( $rules, $type );

		if ( ! empty( $value ) ) {
			switch ( cakecious_array_value( $type_chunks, 0 ) ) {
				case 'posts':
					$label .= ': ' . get_the_title( $value );
					break;

				case 'tax_archive':
				case 'posts_in_tax':
					$label .= ': ' . get_term_field( 'name', $value, cakecious_array_value( $type_chunks, 1 ) );
					break;
			}
		}

		return $label;
	}

	/**
	 * Return all posts by specified post type as choices.
	 *
	 * @param string $post_type
	 * @return array
	 */
	private function _get_posts_as_choices( $post_type ) {
		$choices = array();

		// Get posts by specified post type.
		$posts = get_posts( array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		) );

		// Add posts into choices.
		foreach ( $posts as $post ) {
			$choices[ $post->ID ] = get_post_field( 'post_title', $post->ID, 'attribute' );
		}

		return $choices;
	}

	/**
	 * Return all terms by specified taxonomy as choices.
	 *
	 * @param string $taxonomy
	 * @return array
	 */
	private function _get_terms_as_choices( $taxonomy ) {
		$choices = array();

		// Get posts by specified post type.
		$terms = get_terms( array(
			'taxonomy' => $taxonomy,
			'orderby' => 'name',
			'order' => 'ASC',
		) );

		// Add terms into choices.
		foreach ( $terms as $term ) {
			$choices[ $term->term_id ] = get_term_field( 'name', $term->term_id, $taxonomy, 'attribute' );
		}

		return $choices;
	}

	/**
	 * ====================================================
	 * AJAX functions
	 * ====================================================
	 */

	/**
	 * AJAX callback to get all posts by specified post type for select's options on Block Settings meta box.
	 */
	public function ajax_get_posts_as_select2_choices() {
		check_ajax_referer( 'cakecious-pro-admin', '_ajax_nonce' );

		if ( ! isset( $_REQUEST['post_type'] ) ) {
			wp_send_json_error( esc_html__( 'No valid post type specified', 'cakecious-features' ) );
		}

		// Default choices.
		if ( isset( $_REQUEST['use_all_as_option'] ) && intval( $_REQUEST['use_all_as_option'] ) ) {
			$data = array(
				array(
					'id' => '',
					'text' => esc_attr__( 'All', 'cakecious-features' ),
				),
			);
		} else {
			$data = array();
		}

		// Add posts into choices.
		foreach ( $this->_get_posts_as_choices( $_REQUEST['post_type'] ) as $id => $text ) {
			$data[] = array(
				'id'   => $id,
				'text' => $text,
			);
		}

		wp_send_json_success( $data );
	}

	/**
	 * AJAX callback to get all terms by specified taxonomy for select's options on Block Settings meta box.
	 */
	public function ajax_get_terms_as_select2_choices() {
		check_ajax_referer( 'cakecious-pro-admin', '_ajax_nonce' );

		if ( ! isset( $_REQUEST['taxonomy'] ) ) {
			wp_send_json_error( esc_html__( 'No valid taxonomy specified', 'cakecious-features' ) );
		}

		// Default choices.
		if ( isset( $_REQUEST['use_all_as_option'] ) && intval( $_REQUEST['use_all_as_option'] ) ) {
			$data = array(
				array(
					'id' => '',
					'text' => esc_attr__( 'All', 'cakecious-features' ),
				),
			);
		} else {
			$data = array();
		}

		// Add terms into choices.
		foreach ( $this->_get_terms_as_choices( $_REQUEST['taxonomy'] ) as $id => $text ) {
			$data[] = array(
				'id'   => $id,
				'text' => $text,
			);
		}

		wp_send_json_success( $data );
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Add description on top of the list page.
	 *
	 * @param string $views
	 * @return string
	 */
	public function render_description( $views ) {
		?>
		<div class="notice notice-info">
			<p><?php esc_html_e( 'Custom Block is a reusable and portable content that can be inserted into anywhere on your website via template hooks or shortcode.', 'cakecious-features' ); ?> &nbsp; <a href="https://docs.bolvo.com/article/cakecious-pro-modules/custom-blocks/" class="button button-secondary" target="_blank" rel="noopener"><?php esc_html_e( 'Learn More', 'cakecious-features' ); ?></a></p>
		</div>
		<?php

		return $views;
	}

	/**
	 * Render settings meta box on Block edit page.
	 *
	 * @param WP_Post $post
	 */
	public function render_meta_box( $post ) {
		$option_key = Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings';

		// Fetch settings values from DB and sanitize them.
		$settings = get_post_meta( $post->ID, '_' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings', true );

		$settings = wp_parse_args( $settings, array(
			'hook_action'        => '',
			'hook_action_custom' => '',
			'hook_priority'      => '',

			'display_rules'      => array( 'general|global' ),
			'exclusion_rules'    => array(),
			'user_roles'         => array( 'public' ),
			'devices'            => array( 'desktop', 'tablet', 'mobile' ),

			'tag'                => 'div',
			'id'                 => '',
			'class'              => '',
			'use_container'      => 0,
			'container_width'    => '',
		) );

		// Add a nonce field so we can check for it later.
		wp_nonce_field( Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings', Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . '_settings_nonce' );
		?>
		<div id="cakecious-metabox-page-settings" class="cakecious-admin-metabox-page-settings cakecious-admin-metabox cakecious-admin-form">
			<ul class="cakecious-admin-metabox-nav">
				<li class="cakecious-admin-metabox-nav-item active"><a href="#cakecious-block-settings--location"><?php esc_html_e( 'Location', 'cakecious-features' ); ?></a>
				<li class="cakecious-admin-metabox-nav-item"><a href="#cakecious-block-settings--rules"><?php esc_html_e( 'Display Rules', 'cakecious-features' ); ?></a>
				<li class="cakecious-admin-metabox-nav-item"><a href="#cakecious-block-settings--markup"><?php esc_html_e( 'Markup & Styles', 'cakecious-features' ); ?></a>
			</ul>

			<div class="cakecious-admin-metabox-panels">

				<div id="cakecious-block-settings--location" class="cakecious-admin-metabox-panel active">
					<div class="cakecious-admin-form-row cakecious-block-hook">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Insert into template hook', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<div class="cakecious-block-hook-action">
								<div class="cakecious-block-hook-action-select">
									<?php
									$key = 'hook_action';
									Cakecious_Admin_Fields::render_field( array(
										'name'        => $option_key . '[' . $key . ']',
										'type'        => 'select',
										'value'       => $settings[ $key ],
										'choices'     => array_merge(
											array( '' => esc_html__( '-- None --', 'cakecious-features' ) ),
											Cakecious_Pro_Module_Custom_Blocks::instance()->get_all_template_hooks()
										),
										'class'       => 'widefat',
									) );
									?>
								</div>
								<div class="cakecious-block-hook-action-custom" style="<?php echo esc_attr( 'custom' === $settings['hook_action'] ? '' : 'display: none;' ); ?>">
									<?php
									$key = 'hook_action_custom';
									Cakecious_Admin_Fields::render_field( array(
										'name'        => $option_key . '[' . $key . ']',
										'type'        => 'text',
										'value'       => $settings[ $key ],
										'class'       => 'widefat',
									) );
									?>
								</div>
								<div class="cakecious-block-hook-action-notice" style="<?php echo esc_attr( 'custom' === $settings['hook_action'] ? '' : 'display: none;' ); ?>">
									<div class="notice notice-alt notice-info inline">
										<p><?php esc_html_e( 'You can insert the Custom Block into any template hook from other plugins. For example, setting the hook name to "woocommerce_before_shop_loop" will insert the Custom Block above the WooCommerce\'s products catalog grid.', 'cakecious-features' ); ?></p>
									</div>
								</div>
							</div>

							<div class="cakecious-block-hook-priority" style="<?php echo esc_attr( 'custom' === $settings['hook_action'] ? '' : 'display: none;' ); ?>">
								<strong><?php esc_html_e( 'Priority:', 'cakecious-features' ); ?>&nbsp;</strong>
								<?php
								$key = 'hook_priority';
								Cakecious_Admin_Fields::render_field( array(
									'name'        => $option_key . '[' . $key . ']',
									'type'        => 'number',
									'value'       => $settings[ $key ],
									'min'         => 0,
									'step'        => 1,
									'placeholder' => 10,
									'disabled'    => '' == $settings[ $key ] ? true : false,
								) );
								?>&nbsp;<span class="description"><?php esc_html_e( 'Smaller would be displayed first.', 'cakecious-features' ); ?></span>
							</div>
						</div>
					</div>

					<hr class="cakecious-block-location-separator">

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Insert via shortcode', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<div class="description" style="padding-top: 0.5em;">
								<code id="cakecious-block-shortcode"><?php echo esc_attr( $shortcode = '[' . Cakecious_Pro_Module_Custom_Blocks::POST_TYPE . ' id="' . $post->ID . '"]' ); ?></code>	
							</div>
							<p><?php esc_html_e( 'Copy and paste this shortcode into any content, widget, or text editor that supports shortcode.', 'cakecious-features' ); ?></p>
						</div>
					</div>
				</div>

				<div id="cakecious-block-settings--rules" class="cakecious-admin-metabox-panel">
					<?php
					$display_item = function( $rule = '' ) {
						$is_template = false;

						// Check if it's a template
						if ( empty( $rule ) ) {
							$is_template = true;
						}

						// Convert the rule into an array and sanitize it.
						$rule = explode( ':', $rule );

						$is_with_value = is_null( cakecious_array_value( $rule, 1 ) ) ? false : true;
						?>
						<li data-repeater-item class="cakecious-block-display-rule cakecious-admin-repeater-control-item" <?php echo $is_template ? 'style="display: none;"' : ''; ?>>
							<div class="cakecious-admin-form-row">
								<div class="cakecious-block-display-rule-type cakecious-admin-form-field">
									<?php
									Cakecious_Admin_Fields::render_field( array(
										'name'        => 'type',
										'type'        => 'select',
										'value'       => cakecious_array_value( $rule, 0 ),
										'choices'     => array_merge(
											array( '' => esc_html__( '-- None selected --', 'cakecious-features' ) ),
											Cakecious_Pro_Module_Custom_Blocks::instance()->get_all_display_rules()
										),
										'class'       => 'widefat',
									) );
									?>
								</div>
								<div class="cakecious-block-display-rule-value cakecious-admin-form-field" style="<?php echo $is_with_value ? '' : 'display: none;'; ?>">
									<?php
									$type = explode( '|', cakecious_array_value( $rule, 0 ) );
									$choices = array();

									switch ( cakecious_array_value( $type, 0 ) ) {
										case 'posts':
											$choices = array( '' => esc_attr__( 'All', 'cakecious-features' ) ) + $this->_get_posts_as_choices( cakecious_array_value( $type, 1 ) );
											break;

										case 'tax_archive':
											$choices = array( '' => esc_attr__( 'All', 'cakecious-features' ) ) + $this->_get_terms_as_choices( cakecious_array_value( $type, 1 ) );
											break;

										case 'posts_in_tax':
											$choices = $this->_get_terms_as_choices( cakecious_array_value( $type, 1 ) );
											break;
									}

									Cakecious_Admin_Fields::render_field( array(
										'name'        => 'value',
										'type'        => 'select',
										'value'       => cakecious_array_value( $rule, 1 ),
										'choices'     => $choices,
										'class'       => 'widefat',
									) );
									?>
								</div>
							</div>

							<a href="javascript:;" data-repeater-delete type="button" class="cakecious-admin-repeater-control-delete"><span class="dashicons dashicons-dismiss"></span></a>
						</li>
						<?php
					}
					?>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Show on', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'display_rules';

							$display_config = array(
								'defaultValues' => array(
									'type'  => '',
									'value' => '',
								),
								'initEmpty' => 1 > count( $settings[ $key ] ) ? true : false,
							);
							?>
							<div class="cakecious-block-display-rules cakecious-admin-repeater-control cakecious-admin-form" data-config="<?php echo esc_attr( json_encode( $display_config ) ); ?>">
								<ul data-repeater-list="<?php echo esc_attr( $option_key . '[' . $key . ']' ); ?>" class="cakecious-admin-repeater-control-list">
									<?php if ( 0 < count( $settings[ $key ] ) ) {
										foreach ( $settings[ $key ] as $i => $rule ) {
											$display_item( $rule );
										}
									} else {
										$display_item();
									} ?>
								</ul>
								<input data-repeater-create type="button" class="cakecious-admin-repeater-control-add button" value="<?php esc_attr_e( 'Add Rule', 'cakecious-features' ); ?>">
							</div>
						</div>
					</div>

					<hr>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Hide on', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'exclusion_rules';

							$display_config = array(
								'defaultValues' => array(
									'type'  => '',
									'value' => '',
								),
								'initEmpty' => 1 > count( $settings[ $key ] ) ? true : false,
							);
							?>
							<div class="cakecious-block-display-rules cakecious-admin-repeater-control cakecious-admin-form" data-config="<?php echo esc_attr( json_encode( $display_config ) ); ?>">
								<ul data-repeater-list="<?php echo esc_attr( $option_key . '[' . $key . ']' ); ?>" class="cakecious-admin-repeater-control-list">
									<?php if ( 0 < count( $settings[ $key ] ) ) {
										foreach ( $settings[ $key ] as $i => $rule ) {
											$display_item( $rule );
										}
									} else {
										$display_item();
									} ?>
								</ul>
								<input data-repeater-create type="button" class="cakecious-admin-repeater-control-add button" value="<?php esc_attr_e( 'Add Rule', 'cakecious-features' ); ?>">
							</div>
						</div>
					</div>

					<hr>

					<?php
					$roles_item = function( $role = '' ) {
						$is_template = false;

						// Check if it's a template
						if ( empty( $role ) ) {
							$is_template = true;
						}
						?>
						<li data-repeater-item class="cakecious-block-user-role cakecious-admin-repeater-control-item" <?php echo $is_template ? 'style="display: none;"' : ''; ?>>
							<div class="cakecious-admin-form-row">
								<div class="cakecious-admin-form-field">
									<?php Cakecious_Admin_Fields::render_field( array(
										'name'        => 'value',
										'type'        => 'select',
										'value'       => $role,
										'choices'     => array_merge(
											array( '' => esc_html__( '-- None selected --', 'cakecious-features' ) ),
											Cakecious_Pro_Module_Custom_Blocks::instance()->get_all_user_roles()
										),
										'class'       => 'widefat',
									) ); ?>
								</div>
							</div>

							<a href="javascript:;" data-repeater-delete type="button" class="cakecious-admin-repeater-control-delete"><span class="dashicons dashicons-dismiss"></span></a>
						</li>
						<?php
					}
					?>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Visible to', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'user_roles';
							
							$roles_config = array(
								'defaultValues' => array(),
								'initEmpty' => 1 > count( $settings[ $key ] ) ? true : false,
							);
							?>
							<div class="cakecious-block-user-roles cakecious-admin-repeater-control cakecious-admin-form" data-config="<?php echo esc_attr( json_encode( $roles_config ) ); ?>">
								<ul data-repeater-list="<?php echo esc_attr( $option_key . '[' . $key . ']' ); ?>" class="cakecious-admin-repeater-control-list">
									<?php if ( 0 < count( $settings[ $key ] ) ) {
										foreach ( $settings[ $key ] as $i => $role ) {
											$roles_item( $role );
										}
									} else {
										$roles_item();
									} ?>
								</ul>
								<input data-repeater-create type="button" class="cakecious-admin-repeater-control-add button" value="<?php esc_attr_e( 'Add Role', 'cakecious-features' ); ?>">
							</div>
						</div>
					</div>

					<hr>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Responsive Display', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<fieldset>
								<?php
								$key = 'devices';

								$devices = array(
									'desktop' => esc_html__( 'Desktop', 'cakecious-features' ),
									'tablet' => esc_html__( 'Tablet', 'cakecious-features' ),
									'mobile' => esc_html__( 'Mobile', 'cakecious-features' ),
								);

								foreach( $devices as $device => $label ) :
									Cakecious_Admin_Fields::render_field( array(
										'type'         => 'checkbox',
										'name'         => $option_key . '[' . $key . '][]',
										'value'        => in_array( $device, $settings[ $key ] ) ? $device : '',
										'return_value' => $device,
										'label'        => $label,
										'wrapper'      => false,
									) );
									echo '<br>';
								endforeach;
								?>
							</fieldset>
						</div>
					</div>
				</div>

				<div id="cakecious-block-settings--markup" class="cakecious-admin-metabox-panel">
					<div class="notice notice-alt notice-info inline">
						<p><?php esc_html_e( 'If you insert this Custom Block into Scripts template hooks, please ignore these options.', 'cakecious-features' ); ?></p>
					</div>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Wrapper tag', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'tag';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'select',
								'value'       => $settings[ $key ],
								'choices'     => array(
									'div',
									'section',
									'header',
									'footer',
									'aside',
									'nav',
								),
							) );
							?>
						</div>
					</div>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Wrapper ID', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'id';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'text',
								'value'       => $settings[ $key ],
							) );
							?>
						</div>
					</div>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Wrapper class', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'class';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'text',
								'value'       => $settings[ $key ],
							) );
							?>
						</div>
					</div>

					<hr>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Content container', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'use_container';
							Cakecious_Admin_Fields::render_field( array(
								'type'         => 'checkbox',
								'name'         => $option_key . '[' . $key . ']',
								'value'        => $settings[ $key ],
								'return_value' => 1,
								'label'        => esc_html__( 'Enabled', 'cakecious-features' ),
							) );
							?>
							<p class="description"><?php esc_html_e( 'If you are using Page Builder to build the content, this option is most likely not needed.', 'cakecious-features' ); ?></p>
						</div>
					</div>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Container width', 'cakecious-features' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'container_width';
							Cakecious_Admin_Fields::render_field( array(
								'type'         => 'number',
								'name'         => $option_key . '[' . $key . ']',
								'placeholder'  => intval( cakecious_get_theme_mod( 'container_width' ) ),
								'min'          => 600,
								'max'          => 1600,
								'step'         => 1,
							) );
							esc_html_e( 'px', 'cakecious-features' );
							?>
						</div>
					</div>
				</div>

				<script type="text/javascript">
					(function($) {
						$( '#cakecious-metabox-page-settings' ).on( 'cakecious-admin-metabox.ready', function() {
							var $this = $( this ),
							    displayRuleValueOptionsCache = {};

							$this.find( '.cakecious-block-display-rules' ).each(function() {
								var $repeater = $( this );

								var initSelect2 = function() {
									$repeater.find( '.cakecious-block-display-rule select' ).select2( { width: '100%' } );
								};
								$repeater.on( 'cakecious-admin-repeater.ready', initSelect2 );
								$repeater.on( 'cakecious-admin-repeater.itemAdded', initSelect2 );

								// Display rules specific value
								var changeDisplayRuleType = function() {
									var $typeSelect = $( this ),
									    $rule = $typeSelect.closest( '.cakecious-block-display-rule' ),
									    $valueCol = $rule.find( '.cakecious-block-display-rule-value' ),
									    $valueSelect = $valueCol.find( 'select' ),
									    type = this.value,
									    typeChunks = type.split( '|' );

									// Hide value field on general and post type archive types.
									if ( 'general' === typeChunks[0] || 'post_type_archive' === typeChunks[0] || '' === typeChunks[0] ) {
										$valueCol.removeClass( 'cakecious-show' ).hide();
										$valueSelect.val( '' ).prop( 'disabled', true );

										// Reset options of value field.
										$valueSelect.empty();
									}
									// Show value field on other types.
									else {
										$valueCol.show();
										$valueSelect.val( '' ).prop( 'disabled', false );
										
										// Check if options for this type is already cached before.
										if ( displayRuleValueOptionsCache[ type ] ) {
											// Use the cache.
											$valueSelect.empty().select2({
												data: displayRuleValueOptionsCache[ type ],
											});
										}
										// Not yet cached before.
										else {
											var data = {
												_ajax_nonce: cakeciousProAdminData.ajaxNonce,
											};

											// Fetch the options using AJAX.
											switch ( typeChunks[0] ) {
												case 'posts':
													data.action = 'cakecious_pro__get_posts_as_select2_choices';
													data.post_type = typeChunks[1];
													data.use_all_as_option = 1;
													break;

												case 'tax_archive':
													data.action = 'cakecious_pro__get_terms_as_select2_choices';
													data.taxonomy = typeChunks[1];
													data.use_all_as_option = 1;
													break;

												case 'posts_in_tax':
													data.action = 'cakecious_pro__get_terms_as_select2_choices';
													data.taxonomy = typeChunks[1];
													data.use_all_as_option = 0;
													break;
											}

											$valueSelect.prop( 'disabled', true );

											$.ajax({
												method: 'POST',
												url: ajaxurl,
												cache: false,
												data: data,
											})
											.done(function( response, status, XHR ) {
												if ( response.success ) {
													// Set returned data as select's options.
													$valueSelect.empty().select2({
														data: response.data,
													});

													// Cache options.
													displayRuleValueOptionsCache[ type ] = response.data;
												} else {
													alert( response.data );
												}

												$valueSelect.prop( 'disabled', false );
											});
										}
									}
								};
								$repeater.on( 'change', '.cakecious-block-display-rule-type select', changeDisplayRuleType );
							});

							$this.find( '.cakecious-block-hook' ).each( function() {
								var $row = $( this ),
								    $hookSelect = $row.find( '.cakecious-block-hook-action-select select' ),
								    $customCol = $row.find( '.cakecious-block-hook-action-custom' ),
								    $notice = $row.find( '.cakecious-block-hook-action-notice' ),
								    $priority = $row.find( '.cakecious-block-hook-priority' );

								$hookSelect.on( 'change', function() {
									if ( '' !== this.value ) {
										$priority.show();
									} else {
										$priority.hide();
									}

									if ( 'custom' === this.value ) {
										$customCol.show();
										$notice.show();
									} else {
										$customCol.hide();
										$notice.hide();
									}
								});
							});
							
							$this.find( '.cakecious-block-user-roles' ).each(function() {
								var $repeater = $( this );

								var initSelect2 = function() {
									$repeater.find( '.cakecious-block-user-role select' ).select2( { width: '100%' } );
								};
								$repeater.on( 'cakecious-admin-repeater.ready', initSelect2 );
								$repeater.on( 'cakecious-admin-repeater.itemAdded', initSelect2 );
							});
						});

					})(jQuery);
				</script>
			</div>
		</div>
		<?php
	}
}

Cakecious_Pro_Module_Custom_Blocks_Admin::instance();