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
 * Header > Alternate Header Colors
 * ====================================================
 */

foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $bar ) {
	$slug = str_replace( '_', '-', $bar );

	$add['header_' . $bar . '_alt_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) .cakecious-header-' . $slug . '-inner',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_alt_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) .cakecious-header-' . $slug . '-inner',
			'property' => 'border-color',
		),
	);
	$add['header_' . $bar . '_alt_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view)',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_alt_link_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) a:not(.button), .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) .cakecious-toggle',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_alt_link_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) a:not(.button):hover, .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) a:not(.button):focus, .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) .cakecious-toggle:hover, .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) .cakecious-toggle:focus',
			'property' => 'color',
		),
	);

	$add['header_' . $bar . '_alt_menu_hover_highlight_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:hover:before, .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:focus:before',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_alt_menu_hover_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:hover, .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:focus',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_alt_menu_active_highlight_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-item > .cakecious-menu-item-link:before, .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-ancestor > .cakecious-menu-item-link:before',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_alt_menu_active_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-item > .cakecious-menu-item-link, .cakecious-header-main-alt-colors .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view):not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-ancestor > .cakecious-menu-item-link',
			'property' => 'color',
		),
	);

	$add['header_' . $bar . '_alt_transparent_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors.cakecious-header-main-transparent.cakecious-header-transparent .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) .cakecious-header-' . $slug . '-inner',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_alt_transparent_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-main-alt-colors.cakecious-header-main-transparent.cakecious-header-transparent .cakecious-header-' . $slug . ':not(.cakecious-sticky-in-view) .cakecious-header-' . $slug . '-inner',
			'property' => 'border-color',
		),
	);
}

$add['header_mobile_main_bar_alt_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) .cakecious-header-mobile-main-bar-inner',
		'property' => 'background-color',
	),
);
$add['header_mobile_main_bar_alt_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) .cakecious-header-mobile-main-bar-inner',
		'property' => 'border-color',
	),
);
$add['header_mobile_main_bar_alt_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) a:not(.button), .cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) .cakecious-toggle',
		'property' => 'color',
	),
);
$add['header_mobile_main_bar_alt_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) a:not(.button):hover, .cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) a:not(.button):focus, .cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) .cakecious-toggle:hover, .cakecious-header-mobile-alt-colors .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) .cakecious-toggle:focus',
		'property' => 'color',
	),
);
$add['header_mobile_main_bar_alt_transparent_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-alt-colors.cakecious-header-mobile-transparent.cakecious-header-transparent .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) .cakecious-header-mobile-main-bar-inner',
		'property' => 'background-color',
	),
);
$add['header_mobile_main_bar_alt_transparent_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-alt-colors.cakecious-header-mobile-transparent.cakecious-header-transparent .cakecious-header-mobile-main-bar:not(.cakecious-sticky-in-view) .cakecious-header-mobile-main-bar-inner',
		'property' => 'border-color',
	),
);

return $add;