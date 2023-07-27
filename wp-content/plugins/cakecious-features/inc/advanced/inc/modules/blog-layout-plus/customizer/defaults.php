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
 * Blog > Post Layout: List
 * ====================================================
 */

$add['blog_index_list_items_gap'] = '60px';

$add['entry_list_padding'] = '0 0 0 0';
$add['entry_list_border'] = '0 0 0 0';
$add['entry_list_border_radius'] = '0px';

$add['entry_list_thumbnail'] = 'left';
$add['entry_list_thumbnail_width'] = '35%';
$add['entry_list_thumbnail_size'] = 'medium_large';
$add['entry_list_thumbnail_gap'] = '30px';
$add['entry_list_thumbnail_ignore_padding'] = 0;

$add['entry_list_header'] = array( 'header-meta', 'title' );
$add['entry_list_header_meta'] = '{{date}}';

$add['entry_list_excerpt_length'] = 30;
$add['entry_list_read_more_text'] = '';
$add['entry_list_read_more_display'] = '';

$add['entry_list_footer'] = array( 'footer-meta' );
$add['entry_list_footer_meta'] = esc_html__( 'Posted in {{categories}} &nbsp;&bull;&nbsp; {{comments}}', 'cakecious-features' );

$add['entry_list_bg_color'] = '';
$add['entry_list_border_color'] = '';
$add['entry_list_shadow'] = '0px 0px 30px 0px rgba(0,0,0,0)';

return $add;