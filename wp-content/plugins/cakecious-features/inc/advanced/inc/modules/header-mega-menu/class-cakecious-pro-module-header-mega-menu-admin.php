<?php
/**
 * Cakecious Pro module: Header Mega Menu Admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_Header_Mega_Menu_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_Header_Mega_Menu_Admin
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
	 * @return Cakecious_Pro_Module_Header_Mega_Menu_Admin
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
		// Fallback compatibility for WordPress version older than 5.4.
		// Use custom walker to enable 'wp_nav_menu_item_custom_fields' hook.
		if ( version_compare( get_bloginfo( 'version' ), '5.4', '<' ) ) {
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'custom_walker_for_adding_custom_fields' ), 99 );
		}

		// Add custom fields to menu item editor.
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'render_fields' ), 10, 4 );

		// Add custom iframe page for mega menu settings.
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'current_screen', array( $this, 'render_settings' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Replace default menu editor walker class.
	 * Fallback compatibility for WordPress version older than 5.4.
	 * Since WordPress 5.4, the "wp_nav_menu_item_custom_fields" is added by default.
	 *
	 * @param string $walker
	 * @return string
	 */
	public function custom_walker_for_adding_custom_fields( $walker ) {
		$walker = 'Menu_Item_Custom_Fields_Walker';

		if ( ! class_exists( $walker ) ) {
			require_once( CAKECIOUS_PRO_DIR . 'inc/lib/class-menu-item-custom-fields-walker.php' );
		}

		return $walker;
	}

	/**
	 * Add admin submenu page: Dashboard > Cakecious Mega Menu
	 */
	public function register_admin_menu() {
		add_dashboard_page(
			'',
			'',
			'edit_theme_options',
			'cakecious-mega-menu-settings'
		);
	}
	
	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Print menu item settings.
	 */
	public function render_settings() {
		if ( empty( $_GET['page'] ) || 'cakecious-mega-menu-settings' !== $_GET['page'] || empty( $_GET['menu_item_id'] ) ) { // WPCS: CSRF ok, input var ok.
			return;
		}

		if ( ! defined( 'IFRAME_REQUEST' ) ) {
			define( 'IFRAME_REQUEST', true );
		}

		if ( ! isset( $_GET['depth'] ) ) {
			$_GET['depth'] = '2';
		}

		$depth = intval( $_GET['depth'] );
		$menu_item_id = intval( $_GET['menu_item_id'] );

		/**
		 * Dequeue unnecessary scripts.
		 */
		wp_dequeue_style( 'admin-bar' );

		/**
		 * WordPress Administration Template Header.
		 */
		iframe_header( esc_html__( 'Mega Menu Settings', 'cakecious-features' ) );
		?>
		<div class="wrap cakecious-nav-menu-item-mega-menu-settings">
			<?php
			/**
			 * Process save data.
			 */

			if ( isset( $_POST['submit'] ) ) {
				check_admin_referer( 'cakecious_mega_menu_settings', 'cakecious_mega_menu_settings_nonce' );

				$excludes = array(
					'cakecious_mega_menu_settings_nonce',
					'_wp_http_referer',
					'depth',
					'submit',
				);

				$data = array();

				foreach ( $_POST as $key => $value ) {
					if ( in_array( $key, $excludes ) ) {
						continue;
					}

					if ( '' === $value ) continue;

					// If value is 0 or 1, cast to integer.
					if ( '0' === $value || '1' === $value ) {
						$value = intval( $value );
					}
					
					$data[ $key ] = $value;
				}

				if ( 0 === intval( $_POST['depth'] ) ) {
					update_post_meta( $menu_item_id, '_menu_item_cakecious_mega_menu_settings', $data );
				} else {
					update_post_meta( $menu_item_id, '_menu_item_cakecious_mega_menu_sub_settings', $data );
				}

				?>
				<div class="notice inline notice-success">
					<p><?php esc_html_e( 'Settings saved!', 'cakecious-features' ); ?></p>
				</div>
				<?php
			}
			?>
			<hr class="wp-header-end">

			<form action="" method="post">
				<?php
				$menu_item_parent_id = get_post_meta( $menu_item_id, '_menu_item_menu_item_parent', true );
				
				wp_nonce_field( 'cakecious_mega_menu_settings', 'cakecious_mega_menu_settings_nonce' );

				switch ( $depth ) {
					// Show form for 1st level menu item.
					case 0:
						$this->_render_settings__depth_0( $menu_item_id );
						break;

					// Show form for 2nd level menu item.
					case 1:
						$this->_render_settings__depth_1( $menu_item_id );
						break;
					
					// Show nothing for other level menu item.
					default:
						$this->_render_settings__notice( $menu_item_id );
						break;
				}
				?>

				<input type="hidden" name="depth" value="<?php echo esc_attr( $depth ); ?>">
			</form>
		</div>

		<?php
		/**
		 * WordPress Administration Template Footer.
		 */
		iframe_footer();
		exit;
	}

	/**
	 * Print top menu item settings form.
	 *
	 * @param integer $menu_item_id
	 */
	private function _render_settings__depth_0( $menu_item_id ) {
		$values = get_post_meta( $menu_item_id, '_menu_item_cakecious_mega_menu_settings', true );
		?>
		<h2>
			<?php printf(
				/* translators: %s: theme name. */
				esc_html__( '%s Mega Menu - Container Settings', 'cakecious-features' ),
				cakecious_get_theme_info( 'name' )
			); ?>
		</h2>
		<div class="notice inline notice-info">
			<p><?php esc_html_e( 'Please note, Mega Menu only works in desktop header (top bar, main bar, bottom bar).', 'cakecious-features' ); ?></p>
		</div>
		<div class="cakecious-admin-form">
			<?php $key = 'enabled'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Enable Mega Menu', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'checkbox',
						'value'   => cakecious_array_value( $values, $key ),
						'label'   => esc_attr__( 'Enable Mega Menu mode on this menu item (all direct child menu items will be columns)', 'cakecious-features' ),
					) ); ?>
					<div class="notice notice-alt notice-info inline">
						<p><?php esc_html_e( 'You need to add at least 1 child menu item under this menu item.', 'cakecious-features' ); ?></p>
					</div>
				</div>
			</div>

			<?php $key = 'size'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row" <?php echo intval( cakecious_array_value( $values, 'enabled' ) ) ? '' : 'style="display: none;"'; ?>>
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Mega Menu width', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'select',
						'value'   => cakecious_array_value( $values, $key ),
						'choices' => array(
							''           => esc_attr__( 'Same as container width', 'cakecious-features' ),
							'full-width' => esc_attr__( 'Full width', 'cakecious-features' ),
							'custom'     => esc_attr__( 'Custom width', 'cakecious-features' ),
						),
					) ); ?>
				</div>
			</div>

			<?php $key = 'custom_width'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row" <?php echo intval( cakecious_array_value( $values, 'enabled' ) ) && 'custom' === cakecious_array_value( $values, 'size' ) ? '' : 'style="display: none;"'; ?>>
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Custom width', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'number',
						'min'     => 300,
						'value'   => cakecious_array_value( $values, $key ),
					) ); ?>px
				</div>
			</div>
		</div>

		<?php submit_button(); ?>

		<script type="text/javascript">
			(function( $ ) {
				$(function() {
					var $container = $( '.cakecious-nav-menu-item-mega-menu-settings' );

					$container.on( 'change', '#cakecious_mega_menu_enabled input', function( e ) {
						if ( this.checked ) {
							$( '#cakecious_mega_menu_size' ).show();

							if ( 'custom' === $( '#cakecious_mega_menu_size select' ).val() ) {
								$( '#cakecious_mega_menu_custom_width' ).show();
							}
						} else {
							$( '#cakecious_mega_menu_size' ).hide();
							$( '#cakecious_mega_menu_custom_width' ).hide();
						}
					});

					$container.on( 'change', '#cakecious_mega_menu_size select', function( e ) {
						if ( 'custom' === this.value ) {
							$( '#cakecious_mega_menu_custom_width' ).show();
						} else {
							$( '#cakecious_mega_menu_custom_width' ).hide();
						}
					});
				});
			})(jQuery);
		</script>
		<?php
	}

	/**
	 * Print sub menu item settings form.
	 *
	 * @param integer $menu_item_id
	 */
	private function _render_settings__depth_1( $menu_item_id ) {
		$values = get_post_meta( $menu_item_id, '_menu_item_cakecious_mega_menu_sub_settings', true );
		?>
		<h2>
			<?php printf(
				/* translators: %s: theme name. */
				esc_html__( '%s Mega Menu - Column Settings', 'cakecious-features' ),
				cakecious_get_theme_info( 'name' )
			); ?>
		</h2>
		<div class="notice inline notice-info">
			<p><?php esc_html_e( 'Please make sure you have enabled Mega Menu mode on parent menu item. Otherwise, these settings won\'t take effects.', 'cakecious-features' ); ?></p>
		</div>
		<div class="cakecious-admin-form">
			<?php $key = 'column_width'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Column width', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'number',
						'min'     => 0,
						'max'     => 100,
						'step'    => 0.1,
						'value'   => cakecious_array_value( $values, $key ),
					) ); ?>%
				</div>
			</div>

			<?php $key = 'hide_label'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Hide label', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'checkbox',
						'value'   => cakecious_array_value( $values, $key ),
						'label'   => esc_attr__( 'Hide column heading (navigation label)', 'cakecious-features' ),
					) ); ?>
				</div>
			</div>

			<?php $key = 'disable_label_link'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Disable label link', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'checkbox',
						'value'   => cakecious_array_value( $values, $key ),
						'label'   => esc_attr__( 'Disable link on column heading (navigation label)', 'cakecious-features' ),
					) ); ?>
				</div>
			</div>

			<?php $key = 'disable_padding'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Disable padding', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'checkbox',
						'value'   => cakecious_array_value( $values, $key ),
						'label'   => esc_attr__( 'Disable this column padding (might be useful when you use Gutenberg or page builders to build the custom content)', 'cakecious-features' ),
					) ); ?>
				</div>
			</div>

			<?php $key = 'custom_content'; ?>
			<div id="<?php echo esc_attr( 'cakecious_mega_menu_' . $key ); ?>" class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Custom content', 'cakecious-features' ); ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php
					$value = get_post_meta( $menu_item_id, '_menu_item_' . $key, true );
					Cakecious_Admin_Fields::render_field( array(
						'name'    => $key,
						'type'    => 'textarea',
						'rows'    => 3,
						'value'   => cakecious_array_value( $values, $key ),
						'class'   => 'widefat',
					) );
					?>
					<p class="description"><?php esc_html_e( 'You can insert plain text, HTML tags, or shortcodes.', 'cakecious-features' ); ?></p>
					<div class="notice notice-alt notice-info inline">
						<p><?php esc_html_e( 'TIPS: You can use our Custom Blocks module along with Gutenberg or other page builders to build more advanced and dynamic content. Create a new Custom Block, build the content, and then paste the Custom Block shortcode here.', 'cakecious-features' ); ?></p>
					</div>
				</div>
			</div>
		</div>

		<?php submit_button();
	}

	/**
	 * Print notice on 3rd level menu items or higher.
	 *
	 * @param integer $menu_item_id
	 */
	private function _render_settings__notice( $menu_item_id ) {
		?>
		<div class="notice inline notice-warning">
			<p><?php esc_html_e( 'Mega Menu Settings are only available for 1st and 2nd level menu items.', 'cakecious-features' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Print mega item fields.
	 *
	 * @param integer $id
	 * @param WP_Post $item
	 * @param integer $depth
	 * @param array $args
	 */
	public function render_fields( $id, $item, $depth, $args ) {
		add_thickbox();

		$button_query = array(
			'page'         => 'cakecious-mega-menu-settings',
			'menu_item_id' => $item->ID,
			'depth'        => 0,
			'TB_iframe'    => 'true',
			'width'        => 783,
			'height'       => 400,
		);
		?>
		<p class="cakecious-nav-menu-item-mega-menu description-wide">
			<?php $button_query['depth'] = 0; ?>
			<a href="<?php echo esc_url( add_query_arg( $button_query, admin_url() ) ); ?>" class="button button-secondary cakecious-nav-menu-item-mega-menu-button cakecious-nav-menu-item-mega-menu-button-depth-0 thickbox">
				<?php printf(
					/* translators: %s: theme name. */
					esc_html__( '%s Mega Menu - Container Settings', 'cakecious-features' ),
					cakecious_get_theme_info( 'name' )
				); ?>
			</a>

			<?php $button_query['depth'] = 1; ?>
			<a href="<?php echo esc_url( add_query_arg( $button_query, admin_url() ) ); ?>" class="button button-secondary cakecious-nav-menu-item-mega-menu-button cakecious-nav-menu-item-mega-menu-button-depth-1 thickbox">
				<?php printf(
					/* translators: %s: theme name. */
					esc_html__( '%s Mega Menu - Column Settings', 'cakecious-features' ),
					cakecious_get_theme_info( 'name' )
				); ?>
			</a>
		</p>
		<?php
	}
}

Cakecious_Pro_Module_Header_Mega_Menu_Admin::instance();