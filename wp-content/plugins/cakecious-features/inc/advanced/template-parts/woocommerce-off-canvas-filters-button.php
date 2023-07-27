<?php
/**
 * WooCommerce off-canvas filters button template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$text = cakecious_get_theme_mod( 'woocommerce_off_canvas_filters_button_text' );
?>
<div class="cakecious-products-off-canvas-filters-button-wrapper">
	<button class="cakecious-products-off-canvas-filters-button cakecious-popup-toggle" data-target="products-off-canvas-filters">
		<?php cakecious_icon( 'filter' ); ?><?php echo esc_html( $text ? '&nbsp;&nbsp;' . $text : '' ); ?>
	</button>
</div>