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
 * Header > Sticky Header
 * ====================================================
 */

$add['header_sticky_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-section-inner',
		'property' => 'background-color',
	),
);
$add['header_sticky_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view *',
		'property' => 'border-color',
	),
);
$add['header_sticky_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view',
		'property' => 'color',
	),
);
$add['header_sticky_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view a:not(.button), .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-toggle',
		'property' => 'color',
	),
);
$add['header_sticky_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view a:not(.button):hover, .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view a:not(.button):focus, .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-toggle:hover, .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-toggle:focus',
		'property' => 'color',
	),
);
$add['header_sticky_bar_menu_hover_highlight_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:hover:after, .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:focus:after',
		'property' => 'background-color',
	),
);
$add['header_sticky_bar_menu_hover_highlight_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:hover, .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:focus',
		'property' => 'color',
	),
);
$add['header_sticky_bar_menu_active_highlight_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-item > .cakecious-menu-item-link:after, .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-ancestor > .cakecious-menu-item-link:after',
		'property' => 'background-color',
	),
);
$add['header_sticky_bar_menu_active_highlight_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-item > .cakecious-menu-item-link, .cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view:not(.cakecious-header-menu-highlight-none) .cakecious-header-menu > .menu > .current-menu-ancestor > .cakecious-menu-item-link',
		'property' => 'color',
	),
);
$add['header_sticky_bar_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-main .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-section-inner',
		'property' => 'box-shadow',
	),
);

$add['header_mobile_sticky_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-section-inner',
		'property' => 'background-color',
	),
);
$add['header_mobile_sticky_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view *',
		'property' => 'border-color',
	),
);
$add['header_mobile_sticky_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view a:not(.button), .cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-toggle',
		'property' => 'color',
	),
);
$add['header_mobile_sticky_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view a:not(.button):hover, .cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view a:not(.button):focus, .cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-toggle:hover, .cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-toggle:focus',
		'property' => 'color',
	),
);
$add['header_mobile_sticky_bar_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile .cakecious-header-sticky.cakecious-sticky-in-view .cakecious-section-inner',
		'property' => 'box-shadow',
	),
);

return $add;