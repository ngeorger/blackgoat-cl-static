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
 * General Styles > Border & Subtle Background
 * ====================================================
 */

$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-selected-filters .widget ul li.chosen a',
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * General Styles > Link
 * ====================================================
 */

$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-selected-filters .widget ul li.chosen a:hover,, .cakecious-products-selected-filters .widget ul li.chosen a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * WooCommerce > Off Canvas Filters
 * ====================================================
 */

$add['woocommerce_off_canvas_filters_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-products-off-canvas-filters',
		'pattern'  => 'cakecious-products-off-canvas-filters-position-$',
	),
);
$add['woocommerce_off_canvas_filters_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar',
		'property' => 'width',
	),
);
$add['woocommerce_off_canvas_filters_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar',
		'property' => 'padding',
	),
);
$add['woocommerce_off_canvas_filters_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar .widget',
		'property' => 'margin-bottom',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-products-off-canvas-filters-bar';
	$property = str_replace( '_', '-', $prop );

	$add['woocommerce_off_canvas_filters_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['woocommerce_off_canvas_filters_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['woocommerce_off_canvas_filters_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-products-off-canvas-filters-bar .widget-title';
	$property = str_replace( '_', '-', $prop );

	$add['woocommerce_off_canvas_filters_widget_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['woocommerce_off_canvas_filters_widget_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['woocommerce_off_canvas_filters_widget_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['woocommerce_off_canvas_filters_widget_title_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-products-off-canvas-filters-bar',
		'pattern'  => 'cakecious-widget-title-alignment-$',
	),
);
$add['woocommerce_off_canvas_filters_widget_title_decoration'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-products-off-canvas-filters-bar',
		'pattern'  => 'cakecious-widget-title-decoration-$',
	),
);

$add['woocommerce_off_canvas_filters_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters.cakecious-popup-active .cakecious-products-off-canvas-filters-bar',
		'property' => 'box-shadow',
	),
);

$add['woocommerce_off_canvas_filters_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar',
		'property' => 'background-color',
	),
);
$add['woocommerce_off_canvas_filters_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar',
		'property' => 'color',
	),
);
$add['woocommerce_off_canvas_filters_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar a',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar .woocommerce.widget_price_filter .price_slider',
		'property' => 'color',
	),
);
$add['woocommerce_off_canvas_filters_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar a:hover, .cakecious-products-off-canvas-filters-bar a:focus',
		'property' => 'color',
	),
);
$add['woocommerce_off_canvas_filters_widget_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar .widget-title',
		'property' => 'color',
	),
);
$add['woocommerce_off_canvas_filters_widget_title_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar.cakecious-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$add['woocommerce_off_canvas_filters_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-products-off-canvas-filters-bar .widget-title',
		'property' => 'border-color',
	),
);

return $add;