<?php
/**
 * Customizer default values.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$colors = cakecious_get_default_colors();

$add = array();

/**
 * ====================================================
 * Header > Builder
 * ====================================================
 */

$add['header_elements_vertical_top'] = array();
$add['header_elements_vertical_middle'] = array();
$add['header_elements_vertical_bottom'] = array();

/**
 * ====================================================
 * Header > Vertical Bar
 * ====================================================
 */

$add['header_vertical_bar_display'] = 'drawer';
$add['header_vertical_bar_position'] = 'left';
$add['header_vertical_bar_alignment'] = 'left';
$add['header_vertical_bar_width'] = '300px';
$add['header_vertical_bar_padding'] = '30px 30px 30px 30px';
$add['header_vertical_bar_border'] = '0 0 0 0';

$add['header_vertical_bar_items_gutter'] = '12px';

$add['header_vertical_bar_font_family'] = '';
$add['header_vertical_bar_font_weight'] = '';
$add['header_vertical_bar_font_style'] = '';
$add['header_vertical_bar_text_transform'] = '';
$add['header_vertical_bar_font_size'] = '';
$add['header_vertical_bar_line_height'] = '';
$add['header_vertical_bar_letter_spacing'] = '';

$add['header_vertical_bar_menu_font_family'] = '';
$add['header_vertical_bar_menu_font_weight'] = '';
$add['header_vertical_bar_menu_font_style'] = '';
$add['header_vertical_bar_menu_text_transform'] = '';
$add['header_vertical_bar_menu_font_size'] = '';
$add['header_vertical_bar_menu_line_height'] = '';
$add['header_vertical_bar_menu_letter_spacing'] = '';

$add['header_vertical_bar_submenu_font_family'] = '';
$add['header_vertical_bar_submenu_font_weight'] = '';
$add['header_vertical_bar_submenu_font_style'] = '';
$add['header_vertical_bar_submenu_text_transform'] = '';
$add['header_vertical_bar_submenu_font_size'] = '';
$add['header_vertical_bar_submenu_line_height'] = '';
$add['header_vertical_bar_submenu_letter_spacing'] = '';

$add['header_vertical_bar_icon_size'] = '18px';

$add['header_vertical_bar_shadow'] = '0 0 20px 0 rgba(0,0,0,0.1)';
$add['header_vertical_bar_bg_color'] = '';
$add['header_vertical_bar_border_color'] = '';
$add['header_vertical_bar_text_color'] = '';
$add['header_vertical_bar_link_text_color'] = '';
$add['header_vertical_bar_link_hover_text_color'] = '';
$add['header_vertical_bar_menu_highlight_color'] = '';

return $add;