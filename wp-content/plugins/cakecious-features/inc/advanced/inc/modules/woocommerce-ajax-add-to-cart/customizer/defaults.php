<?php
/**
 * Customizer default values.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * WooCommerce > AJAX Add to Cart
 * ====================================================
 */

$add['woocommerce_single_ajax_add_to_cart'] = 0;
$add['woocommerce_quick_view_ajax_add_to_cart'] = 0;

$add['woocommerce_ajax_added_to_cart_open_header_cart'] = 0;

return $add;