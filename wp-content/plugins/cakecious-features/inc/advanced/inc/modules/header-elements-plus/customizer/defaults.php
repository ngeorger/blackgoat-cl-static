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
 * Header > Builder
 * ====================================================
 */

$add['header_elements_vertical_top'] = array();
$add['header_elements_vertical_bottom'] = array();

/**
 * ====================================================
 * Header > Search
 * ====================================================
 */

$add['header_search_mode'] = 'default';

/**
 * ====================================================
 * Header > HTML
 * ====================================================
 */

for ( $i = 2; $i <= 3; $i++ ) {
	$add['header_html_' . $i . '_content'] = 'Insert HTML text here';
}

/**
 * ====================================================
 * Header > Shopping Cart
 * ====================================================
 */

$add['header_cart_off_canvas_width'] = '300px';
$add['header_cart_off_canvas_padding'] = '30px 30px 30px 30px';

$add['header_cart_off_canvas_shadow'] = '0 0 20px 0 rgba(0,0,0,0.1)';
$add['header_cart_off_canvas_bg_color'] = '';
$add['header_cart_off_canvas_border_color'] = '';
$add['header_cart_off_canvas_text_color'] = '';
$add['header_cart_off_canvas_link_text_color'] = '';
$add['header_cart_off_canvas_link_hover_text_color'] = '';
$add['header_cart_off_canvas_menu_highlight_color'] = '';

/**
 * ====================================================
 * Header > Button
 * ====================================================
 */

for ( $i = 1; $i <= 2; $i++ ) {
	$add['header_button_' . $i . '_url'] = '#';
	$add['header_button_' . $i . '_text'] = esc_html__( 'Button Text', 'cakecious-features' );
	$add['header_button_' . $i . '_target'] = 'self';
}

/**
 * ====================================================
 * Header > Contact Info
 * ====================================================
 */

$add['header_contact_items'] = array( 'phone', 'time' );
$add['header_contact_email_text'] = 'john.doe@website.com';
$add['header_contact_phone_text'] = '123 456 7890';
$add['header_contact_address_text'] = '77 Awesome Street';
$add['header_contact_time_text'] = 'Mon - Sat: 8AM - 5PM';

return $add;