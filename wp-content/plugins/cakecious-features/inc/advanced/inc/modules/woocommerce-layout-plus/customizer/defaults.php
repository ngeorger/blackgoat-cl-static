<?php
/**
 * Customizer default values.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$colors = cakecious_get_default_colors();

$add = array();

/**
 * ====================================================
 * WooCommerce > Single Product Page
 * ====================================================
 */

$add['woocommerce_single_gallery_layout'] = 'bottom';

/**
 * ====================================================
 * WooCommerce > Products Grid
 * ====================================================
 */

$add['woocommerce_products_grid_item_padding'] = '0 0 0 0';
$add['woocommerce_products_grid_item_border'] = '0 0 0 0';
$add['woocommerce_products_grid_item_bg_color'] = '';
$add['woocommerce_products_grid_same_height_items'] = 0;

$add['woocommerce_products_grid_item_image_ignore_padding'] = 0;

/**
 * ====================================================
 * WooCommerce > Product Alternate Hover Image
 * ====================================================
 */

$add['woocommerce_products_grid_item_alt_hover_image'] = 0;

return $add;