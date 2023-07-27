<?php
/**
 * Customizer settings: Header > Cart
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_cart';

if ( ! class_exists( 'WooCommerce' ) ) {
	// Notice
	$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'notice_header_cart', array(
		'section'     => $section,
		'settings'    => array(),
		'description' => '<div class="notice notice-warning notice-alt inline"><p>' . esc_html__( 'Only available if WooCommerce plugin is installed and activated.', 'cakecious' ) . '</p></div>',
		'priority'    => 10,
	) ) );
}

// Cart amount
$key = 'header_cart_amount';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Cart amount', 'cakecious' ),
	'choices'     => array(
		''       => esc_html__( 'Hidden', 'cakecious' ),
		'before' => esc_html__( 'Before icon', 'cakecious' ),
		'after'  => esc_html__( 'After icon', 'cakecious' ),
	),
	'priority'    => 10,
) );

// Cart amount visibility
$key = 'header_cart_amount_visibility';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_MultiCheck( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Cart amount visibility', 'cakecious' ),
	'choices'     => array(
		'desktop' => esc_html__( 'Desktop', 'cakecious' ),
		'tablet'  => esc_html__( 'Tablet', 'cakecious' ),
		'mobile'  => esc_html__( 'Mobile', 'cakecious' ),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_cart_count', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_cart_link', array(
		'settings'            => array(
			'header_cart_amount',
			'header_cart_amount_visibility',
		),
		'selector'            => '.cakecious-header-shopping-cart-link',
		'container_inclusive' => true,
		'render_callback'     => function() {
			cakecious_header_element( 'shopping-cart-link' );
		},
		'fallback_refresh'    => false,
	) );

	$wp_customize->selective_refresh->add_partial( 'header_cart_dropdown', array(
		'settings'            => array(
			'header_cart_amount',
			'header_cart_amount_visibility',
		),
		'selector'            => '.cakecious-header-shopping-cart-dropdown',
		'container_inclusive' => true,
		'render_callback'     => function() {
			cakecious_header_element( 'shopping-cart-dropdown' );
		},
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Colors
$colors = array(
	'header_cart_count_bg_color'   => esc_html__( 'Cart count BG color', 'cakecious' ),
	'header_cart_count_text_color' => esc_html__( 'Cart count text color', 'cakecious' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 20,
	) ) );
}