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
 * Header > Transparent Header
 * ====================================================
 */

foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $bar ) {
	$slug = str_replace( '_', '-', $bar );

	$add['header_' . $bar . '_transparent_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-transparent.cakecious-header-transparent .cakecious-header-' . $slug . '-inner',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_transparent_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-transparent.cakecious-header-transparent .cakecious-header-' . $slug . '-inner',
			'property' => 'border-color',
		),
	);
}

$add['header_mobile_main_bar_transparent_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-transparent.cakecious-header-transparent .cakecious-header-mobile-main-bar-inner',
		'property' => 'background-color',
	),
);
$add['header_mobile_main_bar_transparent_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-transparent.cakecious-header-transparent .cakecious-header-mobile-main-bar-inner',
		'property' => 'border-color',
	),
);

return $add;