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
 * Header > Top Bar
 * Header > Main Bar
 * Header > Bottom Bar
 * ====================================================
 */

foreach ( array( 'top_bar', 'main_bar', 'bottom_bar' ) as $bar ) {
	$add['header_' . $bar . '_mega_menu_heading_font_family'] = '';
	$add['header_' . $bar . '_mega_menu_heading_font_weight'] = 600;
	$add['header_' . $bar . '_mega_menu_heading_font_style'] = '';
	$add['header_' . $bar . '_mega_menu_heading_text_transform'] = 'uppercase';
	$add['header_' . $bar . '_mega_menu_heading_font_size'] = '0.9em';
	$add['header_' . $bar . '_mega_menu_heading_line_height'] = '';
	$add['header_' . $bar . '_mega_menu_heading_letter_spacing'] = '';

	$add['header_' . $bar . '_mega_menu_heading_text_color'] = '';
	$add['header_' . $bar . '_mega_menu_heading_hover_text_color'] = '';
}

return $add;