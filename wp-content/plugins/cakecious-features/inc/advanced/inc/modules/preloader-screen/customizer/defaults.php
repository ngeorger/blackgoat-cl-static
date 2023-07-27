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
 * Header > Preloader Screen
 * ====================================================
 */

$add['preloader_screen'] = '';
$add['preloader_screen_padding'] = '0px 20px 0px 20px';

$add['preloader_screen_type'] = 'css-spinner';
$add['preloader_screen_bg_color'] = $colors['bg'];
$add['preloader_screen_main_color'] = $colors['heading'];

$add['preloader_screen_progress_bar_width'] = '200px';
$add['preloader_screen_progress_bar_height'] = '10px';
$add['preloader_screen_progress_bar_border_radius'] = '5px';

$add['preloader_screen_progress_image'] = '';
$add['preloader_screen_progress_image_width'] = '200px';

$add['preloader_screen_css_spinner'] = 'ball-clip-rotate';
$add['preloader_screen_css_spinner_width'] = '50px';

return $add;