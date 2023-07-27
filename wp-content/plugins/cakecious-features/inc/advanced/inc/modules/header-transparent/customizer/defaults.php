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
 * Header > Transparent Header
 * ====================================================
 */

foreach ( array( 'main_bar', 'top_bar', 'bottom_bar', 'mobile_main_bar' ) as $bar ) {
	$add['header_' . $bar . '_transparent_bg_color'] = 'rgba(255,255,255,0)';
	$add['header_' . $bar . '_transparent_border_color'] = 'rgba(255,255,255,0)';
}

return $add;