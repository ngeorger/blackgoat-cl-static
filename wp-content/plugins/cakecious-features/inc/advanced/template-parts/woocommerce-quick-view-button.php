<?php
/**
 * WooCommerce quick view button template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

global $product;
?>
<button class="cakecious-product-quick-view-button cakecious-popup-toggle" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-target="product-quick-view" aria-expanded="false">
	<?php echo esc_html( cakecious_get_theme_mod( 'woocommerce_quick_view_button_text' ) ); ?>
</button>