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
 * Footer > Widgets Bar
 * ====================================================
 */

for ( $i = 1; $i <= 6; $i++ ) {
	$add['footer_widgets_bar_column_' . $i . '_width'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-footer-widgets-bar .cakecious-footer-widgets-bar-column-' . $i,
			'property' => 'width',
		),
	);
	$add['footer_widgets_bar_column_' . $i . '_width__tablet'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-footer-widgets-bar .cakecious-footer-widgets-bar-column-' . $i,
			'property' => 'width',
			'media'    => '@media screen and (max-width: 767px )',
		),
	);
	$add['footer_widgets_bar_column_' . $i . '_width__mobile'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-footer-widgets-bar .cakecious-footer-widgets-bar-column-' . $i,
			'property' => 'width',
			'media'    => '@media screen and (max-width: 499px )',
		),
	);
}

return $add;