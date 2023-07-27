<?php
/**
 * Customizer Customizer control's conditional display.
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

$add['custom_logo_alt'] =
$add['hr_header_alt_colors'] = array(
	array(
		'setting'  => '__device',
		'value'    => 'desktop',
	),
);

foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $bar ) {
	$add['label_header_' . $bar . '_alt_colors'] =
	$add['header_' . $bar . '_alt_bg_color'] =
	$add['header_' . $bar . '_alt_border_color'] =
	$add['header_' . $bar . '_alt_text_color'] =
	$add['header_' . $bar . '_alt_link_text_color'] =
	$add['header_' . $bar . '_alt_link_hover_text_color'] =
	$add['header_' . $bar . '_alt_link_active_text_color'] =
	$add['header_' . $bar . '_alt_menu_hover_highlight_color'] =
	$add['header_' . $bar . '_alt_menu_hover_highlight_text_color'] =
	$add['header_' . $bar . '_alt_menu_active_highlight_color'] =
	$add['header_' . $bar . '_alt_menu_active_highlight_text_color'] = array(
		array(
			'setting'  => '__device',
			'value'    => 'desktop',
		),
	);
}

$add['custom_logo_mobile_alt'] =
$add['hr_header_mobile_alt_colors'] =
$add['label_header_mobile_main_bar_alt_colors'] =
$add['header_mobile_main_bar_alt_bg_color'] =
$add['header_mobile_main_bar_alt_border_color'] =
$add['header_mobile_main_bar_alt_link_text_color'] =
$add['header_mobile_main_bar_alt_link_hover_text_color'] = array(
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
	$add['page_settings_' . $ps_type . '[header_alt_colors]'] = array(
		array(
			'setting'  => 'page_settings_' . $ps_type . '[disable_header]',
			'operator' => '!=',
			'value'    => 1,
		),
	);

	$add['page_settings_' . $ps_type . '[header_mobile_alt_colors]'] = array(
		array(
			'setting'  => 'page_settings_' . $ps_type . '[disable_mobile_header]',
			'operator' => '!=',
			'value'    => 1,
		),
	);
}

return $add;