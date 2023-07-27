<?php
/**
 * Customizer settings: WooCommerce > Quick View
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_quick_view';

/**
 * ====================================================
 * Quick View
 * ====================================================
 */

// Enable quick view
$key = 'woocommerce_quick_view';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable quick view', 'cakecious-features' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Button
 * ====================================================
 */

// Heading: Button
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_quick_view_button', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Button', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Text
$key = 'woocommerce_quick_view_button_text';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Text', 'cakecious-features' ),
	'priority'    => 20,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'woocommerce_quick_view_button_text', array(
		'selector'            => '.cakecious-product-quick-view-button',
		'container_inclusive' => true,
		'render_callback'     => array( Cakecious_Pro_Module_WooCommerce_Quick_View::instance(), 'render_loop_item_quick_view_button' ),
		'fallback_refresh'    => false,
	) );
}

// Colors
$colors = array(
	'woocommerce_quick_view_button_bg_color'   => esc_html__( 'Background color', 'cakecious-features' ),
	'woocommerce_quick_view_button_text_color' => esc_html__( 'Text color', 'cakecious-features' ),
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

/**
 * ====================================================
 * Popup
 * ====================================================
 */

// Heading: Popup
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_quick_view_popup', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Popup', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Width
$key = 'woocommerce_quick_view_popup_width';
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
			'min'  => 600,
			'max'  => 1600,
			'step' => 1,
		),
	),
	'priority'    => 30,
) ) );