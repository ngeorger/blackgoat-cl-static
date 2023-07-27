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
 * WooCommerce > Cart Page
 * ====================================================
 */

$add['content_main_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-cart-mobile-sticky-checkout .cakecious-cart-mobile-sticky-checkout-inner',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * WooCommerce > Single Product Page
 * ====================================================
 */

$add['woocommerce_single_gallery_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce div.product div.images.cakecious-woocommerce-single-gallery-multiple-images.cakecious-woocommerce-single-gallery-thumbnails-position-left ~ span.onsale',
		'property' => 'left',
		'pattern'  => 'calc(0.15 * $)',
		'media'    => '@media screen and (min-width: 768px)',
	),
);

/**
 * ====================================================
 * WooCommerce > Products Grid
 * ====================================================
 */

$add['woocommerce_products_grid_item_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-wrapper',
		'property' => 'padding',
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-thumbnail.cakecious-product-thumbnail-ignore-padding',
		'property' => 'margin-top',
		'pattern'  => '-$ !important',
		'function' => array(
			'name' => 'explode_value',
			'args' => array( 0 ), // 1st part = top
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-thumbnail.cakecious-product-thumbnail-ignore-padding',
		'property' => 'margin-right',
		'pattern'  => '-$ !important',
		'function' => array(
			'name' => 'explode_value',
			'args' => array( 1 ), // 2nd part = right
		),
	),
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-thumbnail.cakecious-product-thumbnail-ignore-padding',
		'property' => 'margin-left',
		'pattern'  => '-$ !important',
		'function' => array(
			'name' => 'explode_value',
			'args' => array( 3 ), // 4rd part = left
		),
	),
);
$add['woocommerce_products_grid_item_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-wrapper',
		'property' => 'border-width',
	),
);
$add['woocommerce_products_grid_item_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.woocommerce ul.products li.product .cakecious-product-wrapper',
		'property' => 'background-color',
	),
);

return $add;