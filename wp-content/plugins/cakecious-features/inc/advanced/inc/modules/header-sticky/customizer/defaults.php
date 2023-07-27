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
 * Header > Vertical Bar
 * ====================================================
 */

$add['header_sticky_bar'] = 'main';
$add['header_sticky_display'] = 'fixed';
$add['header_sticky_height'] = '60px';

$add['header_mobile_sticky_display'] = 'fixed';
$add['header_mobile_sticky_height'] = '60px';

return $add;