<?php
/**
 * Customizer settings: WooCommerce > AJAX Add To Cart
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_ajax_add_to_cart';

/**
 * ====================================================
 * AJAX Add To Cart
 * ====================================================
 */

// Enable on quick view popup
$key = 'woocommerce_quick_view_ajax_add_to_cart';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable on quick view popup', 'cakecious-features' ),
	'priority'    => 15,
) ) );