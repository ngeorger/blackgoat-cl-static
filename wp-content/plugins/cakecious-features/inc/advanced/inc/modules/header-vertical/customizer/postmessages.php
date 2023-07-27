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
 * Header > Vertical Bar
 * ====================================================
 */

$add['header_vertical_bar_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-header-vertical',
		'pattern'  => 'cakecious-header-vertical-position-$',
	),
);
$add['header_vertical_bar_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-header-vertical',
		'pattern'  => 'cakecious-text-align-$',
	),
);

$add['header_vertical_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed, .cakecious-header-vertical-bar',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed.cakecious-header-vertical-position-left ~ #canvas',
		'property' => 'margin-left',
		'media'    => '@media screen and (min-width: 1024px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed.cakecious-header-vertical-position-right ~ #canvas',
		'property' => 'margin-right',
		'media'    => '@media screen and (min-width: 1024px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-off-canvas.cakecious-popup-active.cakecious-header-vertical-position-left ~ #canvas',
		'property' => 'transform',
		'pattern'  => 'translate( $, 0 )',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-off-canvas.cakecious-popup-active.cakecious-header-vertical-position-right ~ #canvas',
		'property' => 'transform',
		'pattern'  => 'translate( -$, 0 )',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-full-screen .cakecious-header-section-vertical-column',
		'property' => 'width',
	),

	// alignwide
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-narrow .alignwide',
		'property' => 'max-width',
		'pattern'  => 'calc( 100vw - $ )',
		'media'    => '@media screen and (min-width: 1024px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-narrow .alignwide',
		'property' => 'margin-left',
		'pattern'  => 'calc( -50vw + 50% + ( $ / 2 ) )',
		'media'    => '@media screen and (min-width: 1024px) and (max-width: ' . ( intval( cakecious_get_theme_mod( 'container_width' ) ) + intval( cakecious_get_theme_mod( 'header_vertical_bar_width' ) ) ) . 'px)', // currently can't find better way to do the media query.
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-narrow .alignwide',
		'property' => 'margin-right',
		'pattern'  => 'calc( -50vw + 50% + ( $ / 2 ) )',
		'media'    => '@media screen and (min-width: 1024px) and (max-width: ' . ( intval( cakecious_get_theme_mod( 'container_width' ) ) + intval( cakecious_get_theme_mod( 'header_vertical_bar_width' ) ) ) . 'px)', // currently can't find better way to do the media query.
	),

	// alignfull
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-narrow .alignfull, .cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-wide .alignfull',
		'property' => 'max-width',
		'pattern'  => 'calc( 100vw - $ )',
		'media'    => '@media screen and (min-width: 1024px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-narrow .alignfull, .cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-wide .alignfull',
		'property' => 'margin-left',
		'pattern'  => 'calc( -50vw + 50% + ( $ / 2 ) )',
		'media'    => '@media screen and (min-width: 1024px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-narrow .alignfull, .cakecious-header-vertical-display-fixed ~ .cakecious-canvas .cakecious-content-layout-wide .alignfull',
		'property' => 'margin-right',
		'pattern'  => 'calc( -50vw + 50% + ( $ / 2 ) )',
		'media'    => '@media screen and (min-width: 1024px)',
	),
);
$add['header_vertical_bar_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar',
		'property' => 'padding',
	),
);
$add['header_vertical_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar',
		'property' => 'border-width',
	),
);

$add['header_vertical_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar .cakecious-header-section-vertical-row > *',
		'property' => 'padding',
		'pattern'  => '$ 0',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar .cakecious-header-section-vertical-column',
		'property' => 'margin',
		'pattern'  => '-$ 0',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_vertical_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.cakecious-header-vertical-bar',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_vertical_bar_menu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.cakecious-header-vertical-bar .menu .menu-item > .cakecious-menu-item-link, .cakecious-header-vertical-bar .menu-item > .cakecious-toggle',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_vertical_bar_submenu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.cakecious-header-vertical-bar .sub-menu .menu-item > .cakecious-menu-item-link, .cakecious-header-vertical-bar .sub-menu .menu-item > .cakecious-toggle',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

$add['header_vertical_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar .cakecious-menu-icon',
		'property' => 'font-size',
	),
);

$add['header_vertical_bar_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-display-off-canvas.cakecious-popup-active .cakecious-header-vertical-bar, .cakecious-header-vertical-display-fixed .cakecious-header-vertical-bar',
		'property' => 'box-shadow',
	),
);

$add['header_vertical_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar',
		'property' => 'background-color',
	),
);
$add['header_vertical_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar *',
		'property' => 'border-color',
	),
);
$add['header_vertical_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar',
		'property' => 'color',
	),
);
$add['header_vertical_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar a:not(.button), .cakecious-header-vertical-bar .cakecious-toggle',
		'property' => 'color',
	),
);
$add['header_vertical_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-vertical-bar a:not(.button):hover, .cakecious-header-vertical-bar a:not(.button):focus, .cakecious-header-vertical-bar .cakecious-toggle:hover, .cakecious-header-vertical-bar .cakecious-toggle:focus',
		'property' => 'color',
	),
);

return $add;