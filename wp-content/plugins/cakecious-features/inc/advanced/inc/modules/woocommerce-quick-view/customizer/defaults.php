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
 * WooCommerce > Product Quick View
 * ====================================================
 */

$add['woocommerce_quick_view'] = 0;
$add['woocommerce_quick_view_button_text'] = 'Quick View';
$add['woocommerce_quick_view_button_bg_color'] = '';
$add['woocommerce_quick_view_button_text_color'] = '';

$add['woocommerce_quick_view_popup_width'] = '900px';

return $add;