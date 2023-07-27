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

$add['sidebar_sticky'] = '';
$add['sidebar_sticky_spacing_top'] = '30px';
$add['sidebar_sticky_spacing_bottom'] = '30px';
$add['sidebar_sticky_anchor'] = 'top';

return $add;