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
 * Footer > Builder
 * ====================================================
 */

for ( $i = 1; $i <= 6; $i++ ) {
	$add['footer_widgets_bar_column_' . $i . '_width'] = array(
		array(
			'setting'  => 'footer_widgets_bar',
			'operator' => '>=',
			'value'    => $i,
		),
	);
}

return $add;