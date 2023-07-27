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
 * Header > Vertical Bar
 * ====================================================
 */

$add['cakecious_section_header_vertical_bar' ] = array(
	array(
		'setting'  => '__device',
		'value'    => 'desktop',
	),
);

return $add;