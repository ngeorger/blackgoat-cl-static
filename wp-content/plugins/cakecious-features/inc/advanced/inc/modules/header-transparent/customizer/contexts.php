<?php
/**
 * Customizer Customizer control's conditional display.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

$add['header_transparent'] =
$add['hr_header_transparent_colors'] = array(
	array(
		'setting'  => '__device',
		'value'    => 'desktop',
	),
);
foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $bar ) {
	$add['label_header_' . $bar . '_transparent_colors'] =
	$add['header_' . $bar . '_transparent_bg_color'] =
	$add['header_' . $bar . '_transparent_border_color'] =
	$add['header_' . $bar . '_alt_transparent_bg_color'] =
	$add['header_' . $bar . '_alt_transparent_border_color'] = array(
		array(
			'setting'  => '__device',
			'value'    => 'desktop',
		),
	);
}

$add['header_mobile_transparent'] =
$add['hr_header_mobile_transparent_colors'] =
$add['label_header_mobile_transparent_colors'] =
$add['header_mobile_main_bar_transparent_bg_color'] =
$add['header_mobile_main_bar_transparent_border_color'] =
$add['header_mobile_main_bar_alt_transparent_bg_color'] =
$add['header_mobile_main_bar_alt_transparent_border_color'] = array(
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
	$add['page_settings_' . $ps_type . '[header_transparent]'] = array(
		array(
			'setting'  => 'page_settings_' . $ps_type . '[disable_header]',
			'operator' => '!=',
			'value'    => 1,
		),
	);

	$add['page_settings_' . $ps_type . '[header_mobile_transparent]'] = array(
		array(
			'setting'  => 'page_settings_' . $ps_type . '[disable_mobile_header]',
			'operator' => '!=',
			'value'    => 1,
		),
	);
}

return $add;