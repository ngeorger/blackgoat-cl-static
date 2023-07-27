<?php
/**
 * Customizer Customizer control's conditional display.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * WooCommerce > Off Canvas Filters
 * ====================================================
 */

$add['woocommerce_off_canvas_filters_button_text'] =
$add['woocommerce_off_canvas_filters_selected_list'] = array(
	array(
		'setting'  => 'woocommerce_off_canvas_filters',
		'value'    => 1,
	),
);

return $add;