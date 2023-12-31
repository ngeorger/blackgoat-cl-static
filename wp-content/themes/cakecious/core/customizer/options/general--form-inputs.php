<?php
/**
 * Customizer settings: Typography & Colors > Form Input
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_form_input';

// Padding
$key = 'input_padding';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 0.5,
		),
		'em' => array(
			'min'  => 0,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

// Border
$key = 'input_border';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Border radius
$key = 'input_border_radius';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border radius', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_input_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Input typography
$settings = array(
	'font_family'    => 'input_font_family',
	'font_weight'    => 'input_font_weight',
	'font_style'     => 'input_font_style',
	'text_transform' => 'input_text_transform',
	'font_size'      => 'input_font_size',
	'letter_spacing' => 'input_letter_spacing',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'input_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Input typography', 'cakecious' ),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_input_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Colors
$colors = array(
	'input_bg_color'           => esc_html__( 'Background color', 'cakecious' ),
	'input_border_color'       => esc_html__( 'Border color', 'cakecious' ),
	'input_text_color'         => esc_html__( 'Text color', 'cakecious' ),
	'input_focus_bg_color'     => esc_html__( 'Background color :focus', 'cakecious' ),
	'input_focus_border_color' => esc_html__( 'Border color :focus', 'cakecious' ),
	'input_focus_text_color'   => esc_html__( 'Text color :focus', 'cakecious' ),
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