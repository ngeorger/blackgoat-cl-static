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
 * Header > Shopping Cart
 * ====================================================
 */

$add['header_cart_off_canvas_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-off-canvas-cart-bar',
		'property' => 'width',
	),
);

$add['header_cart_off_canvas_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-off-canvas-cart-bar',
		'property' => 'padding',
	),
);

$add['header_cart_off_canvas_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-popup-active .cakecious-off-canvas-cart-bar',
		'property' => 'box-shadow',
	),
);

$add['header_cart_off_canvas_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-off-canvas-cart-bar',
		'property' => 'background-color',
	),
);
$add['header_cart_off_canvas_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-off-canvas-cart-bar',
		'property' => 'color',
	),
);
$add['header_cart_off_canvas_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-off-canvas-cart-bar a:not(.button)',
		'property' => 'color',
	),
);
$add['header_cart_off_canvas_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-off-canvas-cart-bar a:not(.button):hover, .cakecious-off-canvas-cart-bar a:not(.button):focus',
		'property' => 'color',
	),
);

return $add;