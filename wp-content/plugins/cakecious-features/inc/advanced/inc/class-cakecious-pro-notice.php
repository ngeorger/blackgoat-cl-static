<?php
/**
 * Class to handle Cakecious Pro notice via session.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Pro_Notice {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Pro
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
	 * @return Cakecious_Pro
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
		add_action( 'admin_notices', array( $this, 'render_notices' ) );
	}
	
	/**
	 * ====================================================
	 * Hook functions
	 * ====================================================
	 */

	/**
	 * Show admin notices.
	 */
	public function render_notices() {
		// Abort if it's an AJAX request.
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		// Get all existing notices from DB.
		$notices = get_option( 'cakecious_pro_notices', array() );

		// Abort if notices are not an array.
		if ( ! is_array( $notices ) ) {
			return;
		}

		// Abort if notices are empty.
		if ( 0 === count( $notices ) ) {
			return;
		}

		foreach ( $notices as $i => $notice ) {
			?>
			<div class="notice <?php echo esc_attr( 'notice-' . cakecious_array_value( $notice, 'type' ) ); ?> <?php echo esc_attr( intval( cakecious_array_value( $notice, 'dismissible' ) ) ? 'is-dismissible' : '' ); ?>">
				<p><?php echo cakecious_array_value( $notice, 'text' ); // WPCS: XSS OK ?></p>
			</div>
			<?php

			// Delete notice.
			unset( $notices[ $i ] );
		}

		update_option( 'cakecious_pro_notices', array() );
	}
	
	/**
	 * ====================================================
	 * Public functions
	 * ====================================================
	 */

	/**
	 * Add notice into temporary notices variable.
	 *
	 * @param array $notice
	 */
	public function add_notice( $notice ) {
		if ( ! is_array( $notice ) ) {
			$notice = array(
				'text' => $notice,
			);
		}

		// Create notice.
		$notice = wp_parse_args( $notice, array(
			'type'        => 'warning',
			'text'        => '',
			'dismissible' => true,
		) );

		// Get all existing notices from DB.
		$notices = get_option( 'cakecious_pro_notices', array() );

		// Make sure the notices are an array.
		if ( ! is_array( $notices ) ) {
			$notices = array();
		}

		// Add new notice to the notices.
		array_push( $notices, $notice );

		// Save the notices.
		update_option( 'cakecious_pro_notices', $notices );
	}
}

Cakecious_Pro_Notice::instance();