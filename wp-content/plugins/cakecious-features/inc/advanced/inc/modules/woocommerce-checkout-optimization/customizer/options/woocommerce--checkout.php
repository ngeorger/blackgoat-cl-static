<?php
/**
 * Customizer settings: WooCommerce > Checkout Page
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_checkout';

/**
 * ====================================================
 * Distraction Free Mode
 * ====================================================
 */

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_woocommerce_checkout_distraction_free', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
) ) );

// Distraction free mode
$key = 'woocommerce_checkout_distraction_free';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Distraction free mode', 'cakecious-features' ),
	'description' => esc_html__( 'Simplify your original header, page header, and footer to only show logo and copyright. This will help users to focus only on the checkout process.', 'cakecious-features' ),
	'priority'    => 30,
) ) );