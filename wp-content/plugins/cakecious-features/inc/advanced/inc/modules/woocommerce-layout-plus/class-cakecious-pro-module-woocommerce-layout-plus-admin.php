<?php
/**
 * Cakecious Pro module: Blocks Admin page
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Module_WooCommerce_Layout_Plus_Admin {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro_Module_WooCommerce_Layout_Plus_Admin
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
	 * @return Cakecious_Pro_Module_WooCommerce_Layout_Plus_Admin
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
		// Page Settings
		add_action( 'cakecious/admin/metabox/page_settings/fields', array( $this, 'render_page_settings_fields__product' ), 10, 2 );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Render "Product Layout" options on Page Settings meta box.
	 *
	 * @param WP_Post|WP_Term $obj
	 * @param string $tab
	 */
	public function render_page_settings_fields__product( $obj, $tab ) {
		if ( 'woocommerce-single' !== $tab ) {
			return;
		}

		$option_key = 'cakecious_page_settings';

		$values = get_post_meta( $obj->ID, '_' . $option_key, true );

		$keys = array(
			'woocommerce_single_breadcrumb' => esc_html__( 'Show breadcrumb', 'cakecious-features' ),
			'woocommerce_single_gallery' => esc_html__( 'Show gallery', 'cakecious-features' ),
			'woocommerce_single_tabs' => esc_html__( 'Show tabs', 'cakecious-features' ),
			'woocommerce_single_up_sells' => esc_html__( 'Show up-sells', 'cakecious-features' ),
			'woocommerce_single_related' => esc_html__( 'Show related products', 'cakecious-features' ),
		);

		foreach ( $keys as $key => $label ) : ?>
			<div class="cakecious-admin-form-row">
				<div class="cakecious-admin-form-label"><label><?php echo do_shortcode($label); // WPCS: XSS OK ?></label></div>
				<div class="cakecious-admin-form-field">
					<?php
					Cakecious_Admin_Fields::render_field( array(
						'name'        => $option_key . '[' . $key . ']',
						'type'        => 'select',
						'choices'     => array(
							''  => esc_html__( '(Customizer)', 'cakecious-features' ),
							'0' => esc_html__( '&#x2718; No', 'cakecious-features' ),
							'1' => esc_html__( '&#x2714; Yes', 'cakecious-features' ),
						),
						'value'       => cakecious_array_value( $values, $key ),
					) );
					?>
				</div>
			</div>

			<?php if ( 'woocommerce_single_gallery' === $key ) : ?>
				<div class="cakecious-admin-form-row">
					<div class="cakecious-admin-form-label"><label><?php esc_html_e( 'Gallery layout', 'cakecious-features' ); ?></label></div>
					<div class="cakecious-admin-form-field">
						<?php
						Cakecious_Admin_Fields::render_field( array(
							'name'        => $option_key . '[woocommerce_single_gallery_layout]',
							'type'        => 'radioimage',
							'choices'     => array(
								''           => array(
									'label' => esc_html__( '(Customizer)', 'cakecious-features' ),
									'image' => CAKECIOUS_IMAGES_URL . '/customizer/customizer.svg',
								),
								'bottom' => array(
									'label' => esc_html__( 'Bottom', 'cakecious-features' ),
									'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/woocommerce-gallery-layout--bottom.svg',
								),
								'left'   => array(
									'label' => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
									'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/woocommerce-gallery-layout--left.svg',
								),
								'right'  => array(
									'label' => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
									'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/woocommerce-gallery-layout--right.svg',
								),
							),
							'value'       => cakecious_array_value( $values, 'woocommerce_single_gallery_layout' ),
						) );
						?>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach;
	}
}

Cakecious_Pro_Module_WooCommerce_Layout_Plus_Admin::instance();