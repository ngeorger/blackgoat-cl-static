<?php
/**
 * WooCommerce off-canvas filters popup template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$classes = array(
	'widget_title_alignment' => esc_attr( 'cakecious-widget-title-alignment-' . cakecious_get_theme_mod( 'woocommerce_off_canvas_filters_widget_title_alignment' ) ),
	'widget_title_decoration' => esc_attr( 'cakecious-widget-title-decoration-' . cakecious_get_theme_mod( 'woocommerce_off_canvas_filters_widget_title_decoration' ) ),
);
?>
<div id="products-off-canvas-filters" class="cakecious-products-off-canvas-filters <?php echo esc_attr( 'cakecious-products-off-canvas-filters-position-' . cakecious_get_theme_mod( 'woocommerce_off_canvas_filters_position' ) ); ?> cakecious-popup">
	<div class="cakecious-popup-background cakecious-popup-close"></div>

	<div class="cakecious-products-off-canvas-filters-bar <?php echo esc_attr( implode( ' ', $classes ) ); ?> cakecious-popup-content woocommerce">
		<?php if ( is_active_sidebar( 'cakecious-woocommerce-off-canvas-filters' ) ) {
			dynamic_sidebar( 'cakecious-woocommerce-off-canvas-filters' );
		} ?>
	</div>
</div>