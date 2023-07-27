<?php
/**
 * Customizer & Front-End modification rules.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * Page Canvas & Wrapper
 * ====================================================
 */

$add['page_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-product-quick-view .cakecious-product-quick-view-box',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * General Styles > Headings
 * ====================================================
 */

$add['heading_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-quick-view-button',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Main Content Area
 * ====================================================
 */

$add['content_main_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-product-quick-view .cakecious-product-quick-view-box',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * WooCommerce > Product Quick View
 * ====================================================
 */

$add['woocommerce_quick_view_button_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-quick-view-button',
		'property' => 'background-color',
	),
);
$add['woocommerce_quick_view_button_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-quick-view-button',
		'property' => 'color',
	),
);
$add['woocommerce_quick_view_popup_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-product-quick-view .cakecious-product-quick-view-box',
		'property' => 'width',
	),
);

return $add;