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
 * WooCommerce > Off Canvas Filters
 * ====================================================
 */

$add['woocommerce_off_canvas_filters'] = 0;
$add['woocommerce_off_canvas_filters_selected_list'] = 0;
$add['woocommerce_off_canvas_filters_button_text'] = 'Filter';

$add['woocommerce_off_canvas_filters_position'] = 'left';
$add['woocommerce_off_canvas_filters_width'] = '300px';
$add['woocommerce_off_canvas_filters_padding'] = '30px 30px 30px 30px';
$add['woocommerce_off_canvas_filters_widgets_gap'] = '40px';

$add['woocommerce_off_canvas_filters_font_family'] = '';
$add['woocommerce_off_canvas_filters_font_weight'] = '';
$add['woocommerce_off_canvas_filters_font_style'] = '';
$add['woocommerce_off_canvas_filters_text_transform'] = '';
$add['woocommerce_off_canvas_filters_font_size'] = '';
$add['woocommerce_off_canvas_filters_line_height'] = '';
$add['woocommerce_off_canvas_filters_letter_spacing'] = '';

$add['woocommerce_off_canvas_filters_widget_title_font_family'] = '';
$add['woocommerce_off_canvas_filters_widget_title_font_weight'] = '';
$add['woocommerce_off_canvas_filters_widget_title_font_style'] = '';
$add['woocommerce_off_canvas_filters_widget_title_text_transform'] = '';
$add['woocommerce_off_canvas_filters_widget_title_font_size'] = '';
$add['woocommerce_off_canvas_filters_widget_title_line_height'] = '';
$add['woocommerce_off_canvas_filters_widget_title_letter_spacing'] = '';

$add['woocommerce_off_canvas_filters_widget_title_alignment'] = 'left';
$add['woocommerce_off_canvas_filters_widget_title_decoration'] = 'border-bottom';

$add['woocommerce_off_canvas_filters_shadow'] = '0 0 20px 0 rgba(0,0,0,0.1)';
$add['woocommerce_off_canvas_filters_border_color'] = '';
$add['woocommerce_off_canvas_filters_text_color'] = '';
$add['woocommerce_off_canvas_filters_link_text_color'] = '';
$add['woocommerce_off_canvas_filters_link_hover_text_color'] = '';
$add['woocommerce_off_canvas_filters_widget_title_text_color'] = '';
$add['woocommerce_off_canvas_filters_widget_title_bg_color'] = '';
$add['woocommerce_off_canvas_filters_widget_title_border_color'] = '';

return $add;