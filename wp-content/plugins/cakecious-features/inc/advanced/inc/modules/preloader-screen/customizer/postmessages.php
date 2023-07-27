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
 * Preloader Screen
 * ====================================================
 */

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['preloader_screen_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-preloader',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}

$add['preloader_screen_css_spinner_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-preloader-css-spinner',
		'property' => 'font-size',
	),
);

$add['preloader_screen_progress_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-preloader-progress-bar',
		'property' => 'width',
	),
);
$add['preloader_screen_progress_bar_height'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-preloader-progress-bar',
		'property' => 'height',
	),
);
$add['preloader_screen_progress_bar_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-preloader-progress-bar',
		'property' => 'border-radius',
	),
);

$add['preloader_screen_progress_image_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-preloader-progress-image',
		'property' => 'width',
	),
);

$add['preloader_screen_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-preloader',
		'property' => 'background-color',
	),
);
$add['preloader_screen_main_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-preloader',
		'property' => 'color',
	),
);

return $add;