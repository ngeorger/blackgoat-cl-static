<?php
/**
 * Customizer settings: WooCommerce > Cart Page
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_cart';

/**
 * ====================================================
 * Checkout Button
 * ====================================================
 */

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_woocommerce_cart_mobile_sticky_checkout_button', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
) ) );

// Sticky checkout button on mobile
$key = 'woocommerce_cart_mobile_sticky_checkout_button';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Sticky checkout button on mobile', 'cakecious-features' ),
	'description' => esc_html__( 'When on tablet and mobile device, the checkout button will stick / float at bottom of screen. This might help your mobile users to checkout faster and increase your conversion.', 'cakecious-features' ),
	'priority'    => 30,
) ) );