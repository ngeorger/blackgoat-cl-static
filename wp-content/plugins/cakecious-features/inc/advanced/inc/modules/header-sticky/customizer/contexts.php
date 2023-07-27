<?php
/**
 * Customizer Customizer control's conditional display.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

$add['header_sticky'] =
$add['hr_header_sticky'] =
$add['header_sticky_bar'] =
$add['header_sticky_display'] =
$add['header_sticky_height'] =
$add['hr_header_sticky_logo'] =
$add['custom_logo_sticky'] =
$add['header_sticky_logo_width'] =
$add['hr_header_sticky_colors'] =
$add['header_sticky_bar_bg_color'] =
$add['header_sticky_bar_border_color'] =
$add['header_sticky_bar_text_color'] =
$add['header_sticky_bar_link_text_color'] =
$add['header_sticky_bar_link_hover_text_color'] =
$add['header_sticky_bar_menu_hover_highlight_color'] =
$add['header_sticky_bar_menu_hover_highlight_text_color'] =
$add['header_sticky_bar_menu_active_highlight_color'] =
$add['header_sticky_bar_menu_active_highlight_text_color'] =
$add['header_sticky_bar_shadow'] = array(
	array(
		'setting'  => '__device',
		'value'    => 'desktop',
	),
);

$add['header_mobile_sticky'] =
$add['hr_header_mobile_sticky'] =
$add['header_mobile_sticky_display'] =
$add['header_mobile_sticky_height'] =
$add['hr_header_mobile_sticky_logo'] =
$add['custom_logo_mobile_sticky'] =
$add['header_mobile_sticky_logo_width'] =
$add['hr_header_mobile_sticky_colors'] =
$add['header_mobile_sticky_bar_bg_color'] =
$add['header_mobile_sticky_bar_border_color'] =
$add['header_mobile_sticky_bar_text_color'] =
$add['header_mobile_sticky_bar_link_text_color'] =
$add['header_mobile_sticky_bar_link_hover_text_color'] =
$add['header_mobile_sticky_bar_shadow'] = array(
	array(
		'setting'  => '__device',
		'operator' => '!=',
		'value'    => 'desktop',
	),
);

/**
 * ====================================================
 * Page Settings
 * ====================================================
 */

foreach( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$add['page_settings_' . $ps_type . '[header_sticky]'] = array(
		array(
			'setting'  => 'page_settings_' . $ps_type . '[disable_header]',
			'operator' => '!=',
			'value'    => 1,
		),
	);

	$add['page_settings_' . $ps_type . '[header_mobile_sticky]'] = array(
		array(
			'setting'  => 'page_settings_' . $ps_type . '[disable_mobile_header]',
			'operator' => '!=',
			'value'    => 1,
		),
	);
}

return $add;