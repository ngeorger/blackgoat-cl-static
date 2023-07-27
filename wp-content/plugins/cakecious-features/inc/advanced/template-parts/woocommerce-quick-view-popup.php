<?php
/**
 * WooCommerce quick view popup template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_script( 'flexslider' );
wp_enqueue_script( 'wc-add-to-cart-variation' );
?>
<div id="product-quick-view" class="cakecious-product-quick-view cakecious-popup">
	<div class="cakecious-popup-background cakecious-popup-close">
		<?php Cakecious_Helper_CSS_Spinner::render( 'ball-clip-rotate' ); ?>
	</div>

	<div class="cakecious-product-quick-view-box cakecious-popup-content">
		<div class="cakecious-product-quick-view-content woocommerce"><?php // Populated via Javascript ?></div>

		<button class="cakecious-popup-close-icon cakecious-popup-close cakecious-toggle"><?php cakecious_icon( 'close' ); ?></button>
	</div>
</div>