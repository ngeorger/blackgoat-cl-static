<?php
/**
 * WooCommerce mobile sticky checkout button template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="cakecious-cart-mobile-sticky-checkout">
	<div class="cakecious-cart-mobile-sticky-checkout-inner wc-proceed-to-checkout">
		<div class="cakecious-cart-mobile-sticky-checkout-summary">
			<span>
				<?php printf(
					/* translators: %s: number of cart items. */
					_n( '%s item', '%s items', WC()->cart->get_cart_contents_count(), 'cakecious-features' ),
					number_format_i18n( WC()->cart->get_cart_contents_count() )
				); ?>
			</span>
			<span><?php wc_cart_totals_order_total_html(); ?></span>
		</div>
		<div class="cakecious-cart-mobile-sticky-checkout-button">
			<?php woocommerce_button_proceed_to_checkout(); ?>
		</div>
	</div>
</div>