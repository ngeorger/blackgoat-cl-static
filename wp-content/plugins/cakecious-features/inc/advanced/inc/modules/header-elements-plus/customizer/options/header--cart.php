<?php
/**
 * Customizer settings: Header > Cart
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_cart';

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_cart_off_canvas', array(
		'settings'            => array(
			'header_cart_amount',
			'header_cart_amount_visibility',
		),
		'selector'            => '.cakecious-header-shopping-cart-off-canvas',
		'container_inclusive' => true,
		'render_callback'     => function() {
			cakecious_header_element( 'shopping-cart-off-canvas' );
		},
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Search
 * ====================================================
 */

// Heading: Off Canvas
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_cart_off_canvas', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Off Canvas', 'cakecious-features' ),
	'priority'    => 40,
) ) );

// Width
$key = 'header_cart_off_canvas_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Width', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'   => 120,
			'max'   => 400,
			'step'  => 1,
		),
	),
	'priority'    => 40,
) ) );

// Padding
$key = 'header_cart_off_canvas_padding';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'step' => 0.05,
		),
		'%' => array(
			'min'  => 0,
			'step' => 0.01,
		),
	),
	'priority'    => 40,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_cart_off_canvas', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 40,
) ) );

// Box shadow
$key = 'header_cart_off_canvas_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Box shadow', 'cakecious-features' ),
	'exclude'     => array( 'h_offset', 'v_offset' ),
	'priority'    => 40,
) ) );

// Colors
$colors = array(
	'header_cart_off_canvas_bg_color'              => esc_html__( 'Background color', 'cakecious-features' ),
	'header_cart_off_canvas_text_color'            => esc_html__( 'Text color', 'cakecious-features' ),
	'header_cart_off_canvas_link_text_color'       => esc_html__( 'Link text color', 'cakecious-features' ),
	'header_cart_off_canvas_link_hover_text_color' => esc_html__( 'Link text color :hover', 'cakecious-features' ),
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
		'priority'    => 40,
	) ) );
}