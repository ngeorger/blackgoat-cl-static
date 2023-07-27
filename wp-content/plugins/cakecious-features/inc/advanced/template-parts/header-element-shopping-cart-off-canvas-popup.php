<?php
/**
 * Header shopping cart off canvas panel template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// Dropdown
ob_start();
the_widget( 'WC_Widget_Cart', array(
	'title'         => '',
	'hide_if_empty' => false,
) );
$dropdown_html = ob_get_clean();
if ( ! empty( $dropdown_html ) ) {
	$is_dropdown = true;
} else {
	$is_dropdown = false;
}

if ( ! $is_dropdown ) {
	return;
}

?>
<div id="off-canvas-cart" class="cakecious-off-canvas-cart cakecious-popup">
	<div class="cakecious-popup-background cakecious-popup-close">
		<button class="cakecious-popup-close-icon cakecious-popup-close cakecious-toggle"><?php cakecious_icon( 'close' ); ?></button>
	</div>
	<div class="cakecious-off-canvas-cart-bar cakecious-popup-content">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'cakecious-features' ); ?></h2>

		<?php echo do_shortcode($dropdown_html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</div>