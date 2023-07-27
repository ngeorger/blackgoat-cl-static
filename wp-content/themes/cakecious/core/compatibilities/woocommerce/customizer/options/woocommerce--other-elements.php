<?php
/**
 * Customizer settings: WooCommerce > Other Elements
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_woocommerce_elements';

/**
 * ====================================================
 * Sale Badge
 * ====================================================
 */

// Heading: Sale badge
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_elements_sale_badge', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Sale badge', 'cakecious' ),
	'priority'    => 10,
) ) );

// Colors
$colors = array(
	'woocommerce_sale_badge_bg_color'   => esc_html__( 'Badge background color', 'cakecious' ),
	'woocommerce_sale_badge_text_color' => esc_html__( 'Badge text color', 'cakecious' ),
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
		'priority'    => 10,
	) ) );
}

/**
 * ====================================================
 * Review Star
 * ====================================================
 */

// Heading: Review star
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_elements_star', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Review star', 'cakecious' ),
	'priority'    => 20,
) ) );

// Review star color
$key = 'woocommerce_review_star_color';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Rating (&#9733;) color', 'cakecious' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Alt Button
 * ====================================================
 */

// Heading: Alt Button
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_elements_alt_button', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Alt Button', 'cakecious' ),
	'description' => esc_html__( 'Used for single product\'s "Add to Cart" button and Checkout button.', 'cakecious' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'woocommerce_alt_button_bg_color'           => esc_html__( 'Background color', 'cakecious' ),
	'woocommerce_alt_button_border_color'       => esc_html__( 'Border color', 'cakecious' ),
	'woocommerce_alt_button_text_color'         => esc_html__( 'Text color', 'cakecious' ),
	'woocommerce_alt_button_hover_bg_color'     => esc_html__( 'Background color :hover', 'cakecious' ),
	'woocommerce_alt_button_hover_border_color' => esc_html__( 'Border color :hover', 'cakecious' ),
	'woocommerce_alt_button_hover_text_color'   => esc_html__( 'Text color :hover', 'cakecious' ),
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
		'priority'    => 30,
	) ) );
}