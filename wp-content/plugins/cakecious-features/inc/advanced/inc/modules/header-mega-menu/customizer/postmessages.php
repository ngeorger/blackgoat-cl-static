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
 * Header > Mega Menu
 * ====================================================
 */

// Main bar is placed first because top bar and bottom bar can be merged into main bar.
foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $bar ) {
	$slug = str_replace( '_', '-', $bar );

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.cakecious-header-' . $slug . '  .menu > .menu-item.cakecious-mega-menu > .sub-menu > .cakecious-mega-menu-column > .cakecious-menu-item-link';
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $bar . '_mega_menu_heading_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	$add['header_' . $bar . '_mega_menu_heading_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '  .menu > .menu-item.cakecious-mega-menu > .sub-menu > .cakecious-mega-menu-column > .cakecious-menu-item-link',
			'property' => 'color',
		),
	);

	$add['header_' . $bar . '_mega_menu_heading_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '  .menu > .menu-item.cakecious-mega-menu > .sub-menu > .cakecious-mega-menu-column > a.cakecious-menu-item-link:hover, .cakecious-header-' . $slug . ' .menu > .menu-item.cakecious-mega-menu > .sub-menu > .cakecious-mega-menu-column > a.cakecious-menu-item-link:focus',
			'property' => 'color',
		),
	);
}

return $add;