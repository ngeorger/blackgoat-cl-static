<?php
/**
 * Cakecious Individual Page Settings metabox
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Admin_Metabox_Page_Settings {
	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Admin_Metabox_Page_Settings
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
	 * @return Cakecious_Admin_Metabox_Page_Settings
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
		// Post meta box
		add_action( 'add_meta_boxes', array( $this, 'add_post_meta_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'save_post_meta_box' ) );

		// Term meta box
		add_action( 'admin_init', array( $this, 'init_term_meta_boxes' ) );

		// Render actions
		add_action( 'cakecious/admin/metabox/page_settings/fields', array( $this, 'render_meta_box_fields__standard' ), 10, 2 );
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Return the key and label of available tabs.
	 *
	 * @return array
	 */
	private function get_tabs() {
		return apply_filters( 'cakecious/admin/metabox/page_settings/tabs', array(
			'content'          => esc_html__( 'Content Section', 'cakecious' ),
			'hero'             => esc_html__( 'Hero Section', 'cakecious' ),
			'header'           => esc_html__( 'Header', 'cakecious' ),
			'footer'           => esc_html__( 'Footer', 'cakecious' ),
			'custom-blocks'    => esc_html__( 'Custom Blocks (Hooks)', 'cakecious' ),
			'preloader-screen' => esc_html__( 'Preloader Screen', 'cakecious' ),
		) );
	}

	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Add page settings meta box to post edit page.
	 *
	 * @param string $post_type
	 * @param WP_Post $post
	 */
	public function add_post_meta_box( $post_type, $post ) {
		$post_types = cakecious_get_post_types_for_page_settings();

		add_meta_box(
			'cakecious_page_settings',
			/* translators: %s: theme name. */
			sprintf( esc_html__( 'Individual Page Settings (%s)', 'cakecious' ), esc_html( cakecious_get_theme_info( 'name' ) ) ),
			array( $this, 'render_meta_box__post' ),
			$post_types,
			'normal',
			'high'
		);
	}

	/**
	 * Handle save action for page settings meta box on post edit page.
	 *
	 * @param integer $post_id
	 */
	public function save_post_meta_box( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['cakecious_post_page_settings_nonce'] ) ) return;
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST['cakecious_post_page_settings_nonce'] ), 'cakecious_post_page_settings' ) ) return;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		// Sanitize values.
		$sanitized = array();

		if ( isset( $_POST['cakecious_page_settings'] ) && is_array( $_POST['cakecious_page_settings'] ) ) {
			$page_settings = array_map( 'sanitize_key', wp_unslash( $_POST['cakecious_page_settings'] ) );

			foreach ( $page_settings as $key => $value ) {
				if ( '' === $value ) continue;

				// If value is 0 or 1, cast to integer.
				if ( '0' === $value || '1' === $value ) {
					$value = intval( $value );
				}

				$sanitized[ $key ] = $value;
			}
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, '_cakecious_page_settings', $sanitized );
	}

	/**
	 * Initialize meta box on all public taxonomies.
	 */
	public function init_term_meta_boxes() {
		$taxonomies = array_merge(
			array( 'category', 'post_tag' ),
			get_taxonomies( array(
				'public'             => true,
				'publicly_queryable' => true,
				'rewrite'            => true,
				'_builtin'           => false,
			), 'names' )
		);
		foreach ( $taxonomies as $taxonomy ) {
			// add_action( $taxonomy . '_add_form_fields', array( $this, 'render_meta_box__term_add' ) );
			add_action( $taxonomy . '_edit_form_fields', array( $this, 'render_meta_box__term_edit' ) );

			// add_action( 'create_' . $taxonomy, array( $this, 'save_term_meta_box' ), 10, 2 );
			add_action( 'edit_' . $taxonomy, array( $this, 'save_term_meta_box' ), 10, 2 );
		}
	}

	/**
	 * Handle save action for page settings meta box on edit term page.
	 *
	 * @param integer $term_id
	 * @param integer $tt_id
	 */
	public function save_term_meta_box( $term_id, $tt_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['cakecious_term_page_settings_nonce'] ) ) return;

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( sanitize_key( $_POST['cakecious_term_page_settings_nonce'] ), 'cakecious_term_page_settings' ) ) return;

		// Sanitize values.
		$sanitized = array();
		if ( isset( $_POST['cakecious_page_settings'] ) && is_array( $_POST['cakecious_page_settings'] ) ) {
			$page_settings = array_map( 'sanitize_key', wp_unslash( $_POST['cakecious_page_settings'] ) );
			
			foreach ( $page_settings as $key => $value ) {
				if ( '' === $value ) continue;

				// If value is 0 or 1, cast to integer.
				if ( '0' === $value || '1' === $value ) {
					$value = intval( $value );
				}
				
				$sanitized[ $key ] = $value;
			}
		}
		
		// Update the meta field in the database.
		update_term_meta( $term_id, 'cakecious_page_settings', $sanitized );
	}

	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render page settings meta box on post / page edit page.
	 *
	 * @param WP_Post $post
	 */
	public function render_meta_box__post( $post ) {
		// Define an array of post IDs that will disable Individual Page Settings meta box.
		// The Individual Page Settings fields would not be displayed on those disabled IDs meta box.
		// Instead, The meta box would show the defined string specified on the disabled array.
		$disabled_ids = array();

		// Add posts page to disabled IDs.
		if ( 'page' === get_option( 'show_on_front' ) && $posts_page_id = get_option( 'page_for_posts' ) ) {
			$disabled_ids[ $posts_page_id ] = '<p><a href="' . esc_url( add_query_arg( array( 'autofocus[section]' => 'cakecious_section_page_settings_post_archive', 'url' => esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) ), admin_url( 'customize.php' ) ) ) . '">' .  esc_html__( 'Edit Page settings here', 'cakecious' ) . '</a></p>';
		}

		// Filter to modify disabled IDs.
		$disabled_ids = apply_filters( 'cakecious/admin/metabox/page_settings/disabled_posts', $disabled_ids, $post );

		// Check if current post ID is one of the disabled IDs
		if ( array_key_exists( $post->ID, $disabled_ids ) ) {
			// Print the notice here.
			echo $disabled_ids[ $post->ID ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			// There is no other content should be rendered.
			return;
		}

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'cakecious_post_page_settings', 'cakecious_post_page_settings_nonce' );

		// Render meta box.
		$this->render_meta_box_content( $post );
	}

	/**
	 * Render page settings meta box on add term page.
	 */
	public function render_meta_box__term_add() {
		?>
		<div class="form-field cakecious-add-term-page-settings" style="margin: 2em 0;">
			<h2>
				<?php
				/* translators: %s: theme name. */
				printf( esc_html__( 'Individual Page Settings (%s)', 'cakecious' ), esc_html( cakecious_get_theme_info( 'name' ) ) );
				?>
			</h2>
			<?php
			// Add a nonce field so we can check for it later.
			wp_nonce_field( 'cakecious_term_page_settings', 'cakecious_term_page_settings_nonce' );

			// Render meta box
			echo '<div class="cakecious-term-metabox-container">';
			$this->render_meta_box_content();
			echo '</div>';
			?>
		</div>
		<?php
	}

	/**
	 * Render page settings meta box on edit term page.
	 *
	 * @param string $taxonomy
	 */
	public function render_meta_box__term_edit( $term ) {
		?>
		<tr class="form-field cakecious-edit-term-page-settings">
			<td colspan="2" style="padding: 0;">
				<h3>
					<?php
					/* translators: %s: tdeme name. */
					printf( esc_html__( 'Individual Page Settings (%s)', 'cakecious' ), esc_html( cakecious_get_theme_info( 'name' ) ) );
					?>
				</h3>
				<?php
				// Add a nonce field so we can check for it later.
				wp_nonce_field( 'cakecious_term_page_settings', 'cakecious_term_page_settings_nonce' );
				
				// Render meta box
				echo '<div class="cakecious-term-metabox-container">';
				$this->render_meta_box_content( $term );
				echo '</div>';
				?>
			</th>
		</tr>
		<?php
	}

	/**
	 * Render meta box wrapper.
	 *
	 * @param WP_Post|WP_Term $obj
	 */
	public function render_meta_box_content( $obj = null ) {
		$tabs = $this->get_tabs();
		$first_tab = key( $tabs );
		?>
		<div id="cakecious-metabox-page-settings" class="cakecious-admin-metabox-page-settings cakecious-admin-metabox cakecious-admin-form">
			<ul class="cakecious-admin-metabox-nav">
				<?php foreach ( $tabs as $key => $label ) : ?>
					<li class="cakecious-admin-metabox-nav-item <?php echo esc_attr( $key == $first_tab ? 'active' : '' ); ?>">
						<a href="<?php echo esc_attr( '#cakecious-metabox-page-settings--' . $key ); ?>"><?php echo do_shortcode($label); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="cakecious-admin-metabox-panels">
				<?php foreach ( $tabs as $key => $label ) : ?>
					<div id="<?php echo esc_attr( 'cakecious-metabox-page-settings--' . $key ); ?>" class="cakecious-admin-metabox-panel <?php echo esc_attr( $key == $first_tab ? 'active' : '' ); ?>">
						<?php
						/**
						 * Hook: cakecious/admin/metabox/page_settings/fields
						 */
						do_action( 'cakecious/admin/metabox/page_settings/fields', $obj, $key );
						?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render standard page settings meta box fields.
	 *
	 * @param WP_Post|WP_Term $obj
	 * @param string $tab
	 */
	public function render_meta_box_fields__standard( $obj, $tab ) {
		$option_key = 'cakecious_page_settings';

		if ( is_a( $obj, 'WP_Post' ) ) {
			$values = get_post_meta( $obj->ID, '_' . $option_key, true );
		} elseif ( is_a( $obj, 'WP_Term' ) ) {
			$values = get_term_meta( $obj->term_id, $option_key, true );
		} else {
			$values = array();
		}

		switch ( $tab ) {
			case 'header':
				?>
				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Disable desktop header', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'disable_header';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '(Customizer)', 'cakecious' ),
								'0' => esc_html__( '&#x2718; No', 'cakecious' ),
								'1' => esc_html__( '&#x2714; Yes', 'cakecious' ),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Disable mobile header', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'disable_mobile_header';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '(Customizer)', 'cakecious' ),
								'0' => esc_html__( '&#x2718; No', 'cakecious' ),
								'1' => esc_html__( '&#x2714; Yes', 'cakecious' ),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<?php if ( cakecious_show_pro_teaser() ) : ?>
					<div class="notice notice-info notice-alt inline cakecious-metabox-field-pro-teaser">
						<h3><?php echo esc_html_x( 'More Options Available', 'Cakecious Pro upsell', 'cakecious' ); ?></h3>
						<p><?php echo esc_html_x( 'Enable / disable Transparent Header on this page.', 'Cakecious Pro upsell', 'cakecious' ); ?><br><?php echo esc_html_x( 'Enable / disable Sticky Header on this page.', 'Cakecious Pro upsell', 'cakecious' ); ?><br>
							<?php echo esc_html_x( 'Enable / disable Alternate Header Colors on this page.', 'Cakecious Pro upsell', 'cakecious' ); ?><br>
						</p>
						<p><a href="<?php echo esc_url( add_query_arg( array( 'utm_source' => 'cakecious-page-settings-metabox', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ); ?>" class="button button-secondary" target="_blank" rel="noopener"><?php echo esc_html_x( 'Learn More', 'Cakecious Pro upsell', 'cakecious' ); ?></a></p>
					</div>
				<?php endif;
				break;

			case 'hero':
				?>
				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Hero section', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'hero';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '(Customizer)', 'cakecious' ),
								'0' => esc_html__( '&#x2718; Disabled', 'cakecious' ),
								'1' => esc_html__( '&#x2714; Enabled', 'cakecious' ),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Container', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'hero_container';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'radioimage',
							'choices'     => array(
								''           => array(
									'label' => esc_html__( '(Customizer)', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/customizer.svg',
								),
								'default'    => array(
									'label' => esc_html__( 'Normal', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/hero-container--default.svg',
								),
								'full-width' => array(
									'label' => esc_html__( 'Full width', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/hero-container--full-width.svg',
								),
								'narrow'     => array(
									'label' => esc_html__( 'Narrow', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/hero-container--narrow.svg',
								),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>
				<?php
				break;

			case 'content':
				?>
				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Container', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'content_container';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'radioimage',
							'choices'     => array(
								''           => array(
									'label' => esc_html__( '(Customizer)', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/customizer.svg',
								),
								'default'    => array(
									'label' => esc_html__( 'Normal', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-container--default.svg',
								),
								'full-width' => array(
									'label' => esc_html__( 'Full width', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-container--full-width.svg',
								),
								'narrow'     => array(
									'label' => esc_html__( 'Narrow', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-container--narrow.svg',
								),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
						<div class="notice notice-info notice-alt inline">
							<p><?php esc_html_e( 'If you are using Page Builder and want a full width layout, please set the "Page Attributes > Template" to "Page Builder" or the one provided by your page builder.', 'cakecious' ); ?></p>
						</div>
					</div>
				</div>

				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Sidebar', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'content_layout';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'radioimage',
							'choices'     => array(
								''              => array(
									'label' => esc_html__( '(Customizer)', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/customizer.svg',
								),
								'right-sidebar' => array(
									'label' => is_rtl() ? esc_html__( 'Left', 'cakecious' ) : esc_html__( 'Right', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-sidebar-layout--right-sidebar.svg',
								),
								'left-sidebar'  => array(
									'label' => is_rtl() ? esc_html__( 'Right', 'cakecious' ) : esc_html__( 'Left', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-sidebar-layout--left-sidebar.svg',
								),
								'wide'          => array(
									'label' => esc_html__( 'None', 'cakecious' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-sidebar-layout--wide.svg',
								),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<hr>

				<?php if ( is_a( $obj, 'WP_Post' ) ) : ?>
					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Hide post title', 'cakecious' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'content_hide_title';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'select',
								'choices'     => array(
									''  => esc_html__( '(Customizer)', 'cakecious' ),
									'0' => esc_html__( '&#x2718; No', 'cakecious' ),
									'1' => esc_html__( '&#x2714; Yes', 'cakecious' ),
								),
								'value'       => cakecious_array_value( $values, $key ),
							) );
							?>
						</div>
					</div>

					<div class="cakecious-admin-form-row">
						<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Hide featured image', 'cakecious' ); ?></label></div>
						<div class="cakecious-admin-form-field">
							<?php
							$key = 'content_hide_thumbnail';
							Cakecious_Admin_Fields::render_field( array(
								'name'        => $option_key . '[' . $key . ']',
								'type'        => 'select',
								'choices'     => array(
									''  => esc_html__( '(Customizer)', 'cakecious' ),
									'0' => esc_html__( '&#x2718; No', 'cakecious' ),
									'1' => esc_html__( '&#x2714; Yes', 'cakecious' ),
								),
								'value'       => cakecious_array_value( $values, $key ),
							) );
							?>
						</div>
					</div>
				<?php endif; ?>

				<?php
				break;

			case 'footer':
				?>
				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Disable footer widgets', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'disable_footer_widgets';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '(Customizer)', 'cakecious' ),
								'0' => esc_html__( '&#x2718; No', 'cakecious' ),
								'1' => esc_html__( '&#x2714; Yes', 'cakecious' ),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>

				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Disable footer bottom', 'cakecious' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						$key = 'disable_footer_bottom';
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[' . $key . ']',
							'type'        => 'select',
							'choices'     => array(
								''  => esc_html__( '(Customizer)', 'cakecious' ),
								'0' => esc_html__( '&#x2718; No', 'cakecious' ),
								'1' => esc_html__( '&#x2714; Yes', 'cakecious' ),
							),
							'value'       => cakecious_array_value( $values, $key ),
						) );
						?>
					</div>
				</div>
				<?php
				break;

			case 'preloader-screen':
				if ( cakecious_show_pro_teaser() ) : ?>
					<div class="notice notice-info notice-alt inline cakecious-metabox-field-pro-teaser">
						<h3><?php echo esc_html_x( 'More Options Available', 'Cakecious Pro upsell', 'cakecious' ); ?></h3>
						<p><?php echo esc_html_x( 'Enable / disable Preloader Screen on this page.', 'Cakecious Pro upsell', 'cakecious' ); ?></p>
						<p><a href="<?php echo esc_url( add_query_arg( array( 'utm_source' => 'cakecious-page-settings-metabox', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ); ?>" class="button button-secondary" target="_blank" rel="noopener"><?php echo esc_html_x( 'Learn More', 'Cakecious Pro upsell', 'cakecious' ); ?></a></p>
					</div>
				<?php endif;
				break;

			case 'custom-blocks':
				if ( cakecious_show_pro_teaser() ) : ?>
					<div class="notice notice-info notice-alt inline cakecious-metabox-field-pro-teaser">
						<h3><?php echo esc_html_x( 'More Options Available', 'Cakecious Pro upsell', 'cakecious' ); ?></h3>
						<p><?php echo esc_html_x( 'Insert Custom Blocks (section / element) on any part of this page (header, footer, etc.).', 'Cakecious Pro upsell', 'cakecious' ); ?></p>
						<p><a href="<?php echo esc_url( add_query_arg( array( 'utm_source' => 'cakecious-page-settings-metabox', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ); ?>" class="button button-secondary" target="_blank" rel="noopener"><?php echo esc_html_x( 'Learn More', 'Cakecious Pro upsell', 'cakecious' ); ?></a></p>
					</div>
				<?php endif;
				break;
		}
	}
}

Cakecious_Admin_Metabox_Page_Settings::instance();