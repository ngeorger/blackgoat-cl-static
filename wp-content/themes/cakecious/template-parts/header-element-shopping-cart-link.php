<?php
/**
 * Header shopping cart link template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$cart = WC()->cart;

if ( empty( $cart ) ) {
	return;
}

// Amount
$amount_position = cakecious_get_theme_mod( 'header_cart_amount', '' );
$amount_html = '';
if ( '' !== $amount_position ) {
	$classes = array();
	$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), cakecious_get_theme_mod( 'header_cart_amount_visibility' ) );
	foreach( $hide_devices as $device ) {
		$classes[] = esc_attr( 'cakecious-hide-on-' . $device );
	}

	ob_start();
	?>
	<span class="shopping-cart-amount <?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php echo wp_kses_post($cart->get_cart_total()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	<?php
	$amount_html = ob_get_clean();
}
?>
<div class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?> cakecious-header-shopping-cart menu">
	<div class="menu-item">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shopping-cart-link cakecious-menu-item-link">
			<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'cakecious' ); ?></span>

			<?php if ( 'before' === $amount_position ) {
				echo do_shortcode($amount_html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} ?>

			<span class="shopping-cart-icon">
				<?php cakecious_icon( 'shopping-cart', array( 'class' => 'cakecious-menu-icon' ) ); ?>
			</span>

			<span class="shopping-cart-count" data-count="<?php echo esc_attr( $cart->get_cart_contents_count() ); ?>"><?php echo do_shortcode($cart->get_cart_contents_count()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>

			<?php if ( 'after' === $amount_position ) {
				echo do_shortcode($amount_html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} ?>
		</a>
	</div>
</div>