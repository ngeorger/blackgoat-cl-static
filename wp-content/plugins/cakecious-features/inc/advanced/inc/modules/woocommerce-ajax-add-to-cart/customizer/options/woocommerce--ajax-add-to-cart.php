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

// Enable on product page
$key = 'woocommerce_enable_ajax_add_to_cart';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'type'        => 'option',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable on products grid', 'cakecious-features' ) . ' <span class="cakecious-icon-tooltip cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'This is a mirror setting from WooCommerce > Settings > Products (tab) > Add to cart behaviour > Enable AJAX add to cart buttons on archives.', 'cakecious-features' ) . '"><span class="dashicons dashicons-info"></span></span>',
	'priority'    => 10,
) ) );

// Enable on product page
$key = 'woocommerce_single_ajax_add_to_cart';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable on product page', 'cakecious-features' ),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_woocommerce_ajax_add_to_cart', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Show cart on header after succeed
$key = 'woocommerce_ajax_added_to_cart_open_header_cart';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show header cart after succeed', 'cakecious-features' ),
	'description' => esc_html__( 'After successfully added, open the header cart.', 'cakecious-features' ),
	'priority'    => 20,
) ) );