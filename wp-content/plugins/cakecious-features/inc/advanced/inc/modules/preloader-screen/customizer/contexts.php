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
 * Preloader Screen
 * ====================================================
 */

$add['preloader_screen_play_button'] = array(
	array(
		'setting'  => 'preloader_screen',
		'value'    => 1,
	),
);

$add['preloader_screen_css_spinner'] =
$add['preloader_screen_css_spinner_width'] = array(
	array(
		'setting'  => 'preloader_screen_type',
		'value'    => 'css-spinner',
	),
);

$add['preloader_screen_progress_bar_width'] =
$add['preloader_screen_progress_bar_height'] =
$add['preloader_screen_progress_bar_border_radius'] = array(
	array(
		'setting'  => 'preloader_screen_type',
		'value'    => 'progress-bar',
	),
);

$add['preloader_screen_progress_image'] =
$add['preloader_screen_progress_image_width'] = array(
	array(
		'setting'  => 'preloader_screen_type',
		'value'    => 'progress-image',
	),
);

$add['preloader_screen_main_color'] = array(
	array(
		'setting'  => 'preloader_screen_type',
		'value'    => 'progress-image',
		'operator' => '!=',
	),
);

return $add;