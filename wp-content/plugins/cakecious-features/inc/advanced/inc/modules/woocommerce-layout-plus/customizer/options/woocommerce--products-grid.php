<?php
/**
 * Customizer settings: WooCommerce > Products Grid
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_products_grid';

/**
 * ====================================================
 * Grid Item
 * ====================================================
 */

// Padding
$key = 'woocommerce_products_grid_item_padding';
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
	),
	'priority'    => 20,
) ) );

// Border
$key = 'woocommerce_products_grid_item_border';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Background color
$key = 'woocommerce_products_grid_item_bg_color';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Background color', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_woocommerce_products_grid_item', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Same height items in a row
$key = 'woocommerce_products_grid_same_height_items';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Same height items in a row', 'cakecious-features' ),
	'description' => esc_html__( 'Make all items in a row have same height. The add to cart button will be pushed at the bottom of the item.', 'cakecious-features' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Product Image
 * ====================================================
 */

// Heading: Product Image
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_products_grid_item_image', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Product Image', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Ignore padding
$key = 'woocommerce_products_grid_item_image_ignore_padding';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Ignore padding', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Enable alternate hover image
$key = 'woocommerce_products_grid_item_alt_hover_image';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable alternate hover image', 'cakecious-features' ),
	'description' => esc_html__( 'When product thumbnail is hovered, the main image will switch to the 1st image of defined "Product gallery". If there is no image found, the main product thumbnail will remain displayed.', 'cakecious-features' ),
	'priority'    => 30,
) ) );