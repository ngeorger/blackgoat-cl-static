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
 * Blog > Posts Page
 * ====================================================
 */

$add['edit_entry_list'] = array(
	array(
		'setting'  => 'blog_index_loop_mode',
		'value'    => 'list',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['entry_list_read_more_text'] = array(
	array(
		'setting'  => 'entry_list_read_more_display',
		'operator' => '!=',
		'value'    => '',
	),
);

return $add;